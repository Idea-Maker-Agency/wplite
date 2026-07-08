#!/usr/bin/env node
/**
 * Keeps a page/page-template's sibling .scss file in sync with its Sass
 * dependencies: the components it renders via Component::render(), known
 * vendor integrations it uses (e.g. Contact Form 7), and specific Bootstrap
 * components it uses (via CSS class detection) that aren't bundled globally.
 * Managed as a delimited block of @import lines. See ../SKILL.md for why
 * this exists, and for which Bootstrap partials are intentionally excluded
 * from this detection because root-level templates outside this skill's
 * reach also depend on them.
 *
 * Usage: node sync.mjs <path-to-php-file>
 */

import fs from 'node:fs';
import path from 'node:path';

const START_MARKER = '// === wplite:sass-dependencies:start ===';
const END_MARKER = '// === wplite:sass-dependencies:end ===';

// Vendor integrations that ship a Sass partial under theme/scss/vendor/.
// Detected by a plain substring test against the page's PHP source (and
// anything it transitively includes) - add an entry here for any future
// plugin/vendor integration that gets its own theme/scss/vendor/_<name>.scss.
const VENDOR_DETECTORS = [
  {
    name: 'wpcf7',
    test: (phpContents) => phpContents.includes('contact-form-7'),
    // Sass partials are prefixed with `_` on disk but imported without it.
    // Written root-relative from theme/ (matching --load-path=theme) since
    // the actual file lives at theme/scss/vendor/_wpcf7.scss, not theme/vendor/.
    partialRelPath: 'scss/vendor/_wpcf7.scss',
    importPath: 'scss/vendor/wpcf7',
  },
];

// Bootstrap components that are deliberately NOT bundled in theme/scss/main.scss,
// so they're only pulled in for pages that actually use them. Detected by exact
// CSS class token, not substring, so e.g. "nav" doesn't match "navbar".
//
// IMPORTANT: only add a Bootstrap partial here if nothing outside theme/pages/
// and theme/page-templates/ depends on it (header.php, footer.php, and other
// root-level templates, plus any component rendered from them, are invisible
// to this skill - if a root template needs a partial, it must stay global in
// main.scss instead, or this skill will silently break its styling with no
// way to detect or fix it). See SKILL.md for the current global/conditional
// split and how it was verified.
const BOOTSTRAP_DETECTORS = [
  { name: 'accordion', classes: ['accordion'] },
  { name: 'alert', classes: ['alert'] },
  { name: 'carousel', classes: ['carousel'] },
  { name: 'nav', classes: ['nav', 'nav-item', 'nav-link', 'nav-tabs', 'nav-pills'] },
];

// Every page/page-template .scss file compiles standalone (see the separate
// theme/pages:theme/pages, theme/page-templates:theme/page-templates entries
// in compile:sass) - it does not share Sass scope with main.scss. So a
// Bootstrap component partial can't compile on its own; it needs this same
// Sass-only foundation main.scss itself imports first (functions/variables/
// mixins - no direct CSS output, so importing them again here doesn't
// duplicate any CSS bytes, unlike e.g. "root" which does emit CSS and is
// already loaded globally via main.min.css on every page regardless).
const BOOTSTRAP_FOUNDATION = ['functions', 'variables', 'variables-dark', 'maps', 'mixins'];

function main() {
  const phpArg = process.argv[2];
  if (!phpArg) {
    console.error('Usage: node sync.mjs <path-to-php-file>');
    process.exit(1);
  }

  const phpPath = path.resolve(phpArg);
  if (!fs.existsSync(phpPath) || !phpPath.endsWith('.php')) {
    console.error(`Not a PHP file, or file not found: ${phpPath}`);
    process.exit(1);
  }

  if (path.basename(phpPath) === 'index.php') {
    console.error(
      'Skipping: index.php is WordPress\'s standard "Silence is golden" directory-listing guard, not a real ' +
        'template - it has no markup or dependencies to sync, in this file or any other directory.'
    );
    process.exit(1);
  }

  const themeRoot = findThemeRoot(phpPath);
  if (!themeRoot) {
    console.error(
      'Could not locate the theme root (expected an ancestor directory named "theme" containing a "components" folder).'
    );
    process.exit(1);
  }

  const relFromTheme = path.relative(themeRoot, phpPath).split(path.sep).join('/');
  if (!/^pages\//.test(relFromTheme) && !/^page-templates\//.test(relFromTheme)) {
    console.error(
      `Skipping: "${relFromTheme}" is not under pages/ or page-templates/. ` +
        'Those are the only directories this project\'s Sass build compiles per-file ' +
        '(see compile:sass in package.json), so a sibling .scss file elsewhere would ' +
        'never actually get compiled or enqueued.'
    );
    process.exit(1);
  }

  const { combinedContents, visitedFiles } = collectPhpSources(phpPath, themeRoot);
  const components = extractComponents(combinedContents);
  const classTokens = extractClassTokens(combinedContents);

  const resolved = [];
  const skipped = [];

  for (const { name, namespace } of components) {
    const scssRelPath = namespace
      ? `components/${namespace}/${name}/${name}.scss`
      : `components/${name}/${name}.scss`;
    const scssAbsPath = path.join(themeRoot, scssRelPath);

    if (fs.existsSync(scssAbsPath)) {
      resolved.push({ kind: 'component', name, namespace, importPath: scssRelPath.replace(/\.scss$/, '') });
    } else {
      skipped.push({ kind: 'component', name, namespace, scssRelPath });
    }
  }

  for (const detector of VENDOR_DETECTORS) {
    if (!detector.test(combinedContents)) {
      continue;
    }

    const partialAbsPath = path.join(themeRoot, detector.partialRelPath);
    if (fs.existsSync(partialAbsPath)) {
      resolved.push({ kind: 'vendor', name: detector.name, importPath: detector.importPath });
    } else {
      skipped.push({ kind: 'vendor', name: detector.name, scssRelPath: detector.partialRelPath });
    }
  }

  const bootstrapComponents = BOOTSTRAP_DETECTORS.filter((detector) =>
    detector.classes.some((cls) => classTokens.has(cls))
  );

  if (bootstrapComponents.length) {
    // Foundation first, once, so the standalone compile has functions/variables/
    // mixins available before any component partial that depends on them.
    for (const name of BOOTSTRAP_FOUNDATION) {
      resolved.push({ kind: 'bootstrap', name, importPath: `bootstrap/scss/${name}` });
    }
    for (const detector of bootstrapComponents) {
      resolved.push({ kind: 'bootstrap', name: detector.name, importPath: `bootstrap/scss/${detector.name}` });
    }
  }

  const scssPath = phpPath.replace(/\.php$/, '.scss');
  const importLines = resolved.map((r) => `@import "${r.importPath}";`);
  const block = [START_MARKER, ...importLines, END_MARKER].join('\n');

  const existing = fs.existsSync(scssPath) ? fs.readFileSync(scssPath, 'utf8') : '';
  const blockRegex = new RegExp(`${escapeRegex(START_MARKER)}[\\s\\S]*?${escapeRegex(END_MARKER)}`);

  let updated;
  if (blockRegex.test(existing)) {
    updated = existing.replace(blockRegex, block);
  } else if (existing.trim() === '') {
    updated = `${block}\n`;
  } else {
    updated = `${block}\n\n${existing}`;
  }

  fs.mkdirSync(path.dirname(scssPath), { recursive: true });
  fs.writeFileSync(scssPath, updated, 'utf8');

  report({ relFromTheme, scssPath, themeRoot, resolved, skipped, visitedFiles });
}

/**
 * Reads the entry PHP file plus everything it transitively includes via
 * get_template_part() and Component::render(), so a page whose styling-relevant
 * markup actually lives in an included partial (e.g. a "wpcf7"/"alert" class
 * used inside a get_template_part()'d partial rather than the page file itself)
 * still gets detected correctly.
 */
function collectPhpSources(entryPath, themeRoot) {
  const visited = new Set();
  const chunks = [];
  const queue = [entryPath];

  while (queue.length) {
    const filePath = queue.shift();
    const relPath = path.relative(themeRoot, filePath);

    if (visited.has(relPath) || !fs.existsSync(filePath)) {
      continue;
    }
    visited.add(relPath);

    const contents = fs.readFileSync(filePath, 'utf8');
    chunks.push(contents);

    for (const includedPath of extractIncludedFiles(contents, themeRoot)) {
      queue.push(includedPath);
    }
  }

  return { combinedContents: chunks.join('\n'), visitedFiles: [...visited] };
}

function extractIncludedFiles(phpContents, themeRoot) {
  const found = [];

  const templatePartRegex = /get_template_part\(\s*'([^']+)'\s*(?:,\s*'([^']*)')?/g;
  let match;
  while ((match = templatePartRegex.exec(phpContents)) !== null) {
    const slug = match[1];
    const name = match[2];
    // WP's own resolution order: "{slug}-{name}.php" falling back to "{slug}.php".
    if (name) {
      found.push(path.join(themeRoot, `${slug}-${name}.php`));
    }
    found.push(path.join(themeRoot, `${slug}.php`));
  }

  for (const { name, namespace } of extractComponents(phpContents)) {
    const componentPhpPath = namespace
      ? `components/${namespace}/${name}/${name}.php`
      : `components/${name}/${name}.php`;
    found.push(path.join(themeRoot, componentPhpPath));
  }

  return found;
}

function extractComponents(phpContents) {
  const regex = /Component::render\(\s*'([^']+)'\s*(?:,\s*'([^']*)')?/g;
  const found = [];
  const seen = new Set();
  let match;

  while ((match = regex.exec(phpContents)) !== null) {
    const name = match[1];
    const namespace = match[2] || '';
    const key = `${namespace}::${name}`;

    if (!seen.has(key)) {
      seen.add(key);
      found.push({ name, namespace });
    }
  }

  return found;
}

/**
 * Pulls every class="..."/class='...' attribute value out of the given PHP/HTML
 * source and returns the set of individual class name tokens. This is a static,
 * textual scan - classes assembled entirely at runtime (e.g. a variable with no
 * literal class fragment in this file) won't be seen, same limitation as the
 * Component::render()/get_template_part() detection above.
 */
function extractClassTokens(phpContents) {
  const tokens = new Set();
  const classAttrRegex = /class=["']([^"']*)["']/g;
  let match;

  while ((match = classAttrRegex.exec(phpContents)) !== null) {
    for (const token of match[1].split(/\s+/)) {
      if (token) {
        tokens.add(token);
      }
    }
  }

  return tokens;
}

function findThemeRoot(startAbsPath) {
  let dir = path.dirname(startAbsPath);

  while (true) {
    if (path.basename(dir) === 'theme' && fs.existsSync(path.join(dir, 'components'))) {
      return dir;
    }

    const parent = path.dirname(dir);
    if (parent === dir) {
      return null;
    }

    dir = parent;
  }
}

function escapeRegex(str) {
  return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function label(entry) {
  const prefix = entry.namespace ? `${entry.namespace}/` : '';
  const suffix = entry.kind !== 'component' ? ` (${entry.kind})` : '';
  return `${prefix}${entry.name}${suffix}`;
}

function report({ relFromTheme, scssPath, themeRoot, resolved, skipped, visitedFiles }) {
  console.log(`Scanned: ${relFromTheme}`);
  if (visitedFiles.length > 1) {
    console.log(`Also followed ${visitedFiles.length - 1} included file(s): ${visitedFiles.slice(1).join(', ')}`);
  }
  console.log(`Sass file: ${path.relative(themeRoot, scssPath).split(path.sep).join('/')}`);

  if (resolved.length) {
    console.log(`Imported (${resolved.length}):`);
    resolved.forEach((r) => console.log(`  - ${label(r)}`));
  } else {
    console.log('Imported: none');
  }

  if (skipped.length) {
    console.log(`Skipped, no Sass module found (${skipped.length}):`);
    skipped.forEach((r) => console.log(`  - ${label(r)} (expected ${r.scssRelPath})`));
  }
}

main();
