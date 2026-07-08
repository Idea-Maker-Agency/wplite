#!/usr/bin/env node
/**
 * Keeps a page/page-template's sibling .scss file in sync with its Sass
 * dependencies - both the components it renders via Component::render(),
 * and known vendor integrations it uses (e.g. Contact Form 7) - by managing
 * a delimited block of @import lines. See ../SKILL.md for why this exists.
 *
 * Usage: node sync.mjs <path-to-php-file>
 */

import fs from 'node:fs';
import path from 'node:path';

const START_MARKER = '// === wplite:sass-dependencies:start ===';
const END_MARKER = '// === wplite:sass-dependencies:end ===';

// Vendor integrations that ship a Sass partial under theme/scss/vendor/.
// Detected by a plain substring test against the page's PHP source - add an
// entry here for any future plugin/vendor integration that gets its own
// theme/scss/vendor/_<name>.scss partial.
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

  const phpContents = fs.readFileSync(phpPath, 'utf8');
  const components = extractComponents(phpContents);

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
    if (!detector.test(phpContents)) {
      continue;
    }

    const partialAbsPath = path.join(themeRoot, detector.partialRelPath);
    if (fs.existsSync(partialAbsPath)) {
      resolved.push({ kind: 'vendor', name: detector.name, importPath: detector.importPath });
    } else {
      skipped.push({ kind: 'vendor', name: detector.name, scssRelPath: detector.partialRelPath });
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

  report({ relFromTheme, scssPath, themeRoot, resolved, skipped });
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
  const suffix = entry.kind === 'vendor' ? ' (vendor)' : '';
  return `${prefix}${entry.name}${suffix}`;
}

function report({ relFromTheme, scssPath, themeRoot, resolved, skipped }) {
  console.log(`Scanned: ${relFromTheme}`);
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
