---
name: wplite-sync-template-scss
description: Keeps a wplite theme page or page-template's Sass file in sync with its build-time Sass dependencies - the reusable components it renders via Component::render(), known vendor integrations it uses like Contact Form 7, and specific Bootstrap components (accordion, alert, carousel, nav) detected via CSS class usage - by writing/updating a managed block of @import lines. Scans the whole page, following anything it includes via get_template_part() or Component::render(), not just the top-level file. Use this whenever the user is building or editing a file under theme/pages/ or theme/page-templates/ in this repo and wants that page's component, vendor, or Bootstrap styles wired up, mentions "component styles", "scss imports", "sync scss", "wpcf7"/"contact form 7" styling, or asks why a component's, a form's, or a Bootstrap element's styles aren't showing up on a specific page. Also use proactively right after adding, removing, or changing a Component::render() call, a get_template_part() call, a Contact Form 7 shortcode, or Bootstrap markup like an alert/accordion/carousel/nav, in a page or page-template file, so its Sass stays correct without the user having to ask separately.
---

# wplite: Sync Template SCSS

## Why this exists

wplite is a parent theme: pages and page-templates each compile to their own CSS file (`pages/{slug}.scss` -> `pages/{slug}.css`, `page-templates/{name}/{name}.scss` -> `.css`), auto-enqueued per page by `AssetController` based on the current page's slug. Reusable components under `theme/components/` can ship their own `.scss` module, some vendor plugin integrations (e.g. Contact Form 7) ship a Sass partial under `theme/scss/vendor/`, and Bootstrap itself is split into many partials under `node_modules/bootstrap/scss/` that don't all need to load on every page.

Rather than bundling everything into one global stylesheet (ships unused CSS on every page) or wiring up runtime WordPress enqueue logic (`Component::render()` calls happen mid-body, after `wp_head()` has already fired and queued `<head>` styles — too late for a component to enqueue its own stylesheet at render time), this project resolves these dependencies at build time: a page's own `.scss` file `@import`s exactly what it needs. Sass compiles that straight into the page's own CSS file, which is already correctly `<head>`-loaded — no runtime enqueue logic needed at all, and no ordering problem to solve.

This skill keeps that import list correct as a page's dependencies change, so building a new page-template stays a matter of "write the markup you need" rather than also hand-maintaining a parallel Sass import list.

## When to run it

- The user asks to sync, update, or wire up SCSS imports for a page or page-template.
- You (or the user) just added, removed, or changed a `Component::render()` call, a `get_template_part()` call, a vendor integration like a Contact Form 7 shortcode, or Bootstrap markup (an alert, accordion, carousel, or nav), in a file under `theme/pages/` or `theme/page-templates/` — run this right after, without waiting to be asked, so the Sass file never drifts out of sync with what the page actually renders.
- The user reports a component's, a form's, or a Bootstrap element's styles aren't appearing on a specific page.

## How to run it

```bash
node .claude/skills/wplite-sync-template-scss/scripts/sync.mjs <path-to-php-file>
```

Point it at the page or page-template PHP file itself (e.g. `theme/pages/login.php` or `theme/page-templates/contact/contact.php`), not the `.scss` file. It only operates on files under `theme/pages/` or `theme/page-templates/` — those are the only directories this project's Sass build compiles per-file (see `compile:sass` in `package.json`). Anything else has no corresponding compiled CSS output for an `@import` to land in, so the script refuses and explains why rather than silently writing a `.scss` file nothing will ever compile.

If the user has a specific file open or in progress, use that one without asking which file to target. If they want a broader sync, offer to run it across every file under `theme/pages/**/*.php` and `theme/page-templates/**/*.php` — except `index.php`, which the script refuses on sight. Every directory in this theme has a blank `index.php` (WordPress's standard "Silence is golden" directory-listing guard), not a real template, so it's excluded rather than producing a pointless empty `.scss` file.

## What it does

1. Reads the PHP file, then follows every `get_template_part('slug', 'name')` and `Component::render('name', 'Namespace')` call it finds and reads those files too (recursively, with a visited-file guard). This matters because a page's own file is often just a thin wrapper — e.g. `pages/login.php` calls `get_template_part('pages/partials/login', 'form')`, and the markup that actually needs styling (an `alert` class, say) lives in `pages/partials/login-form.php`, not in `login.php` itself. Scanning only the top-level file would miss that.
2. Across all that combined content, it looks for three kinds of dependency:
   - **Components** — every `Component::render()` call. If `theme/components/{Namespace}/{name}/{name}.scss` exists, it's imported; if not, silently skipped (most components don't need their own stylesheet, so this is the common case, not a warning-worthy error).
   - **Vendor integrations** — a small list of known plugin signatures (currently just Contact Form 7, detected by the `contact-form-7` shortcode string) mapped to a partial under `theme/scss/vendor/`. Add an entry to `VENDOR_DETECTORS` in `scripts/sync.mjs` for any future plugin integration that gets its own partial there.
   - **Bootstrap components** — a small list of Bootstrap components (`accordion`, `alert`, `carousel`, `nav`) detected by exact CSS class token (so `nav` doesn't false-match `navbar`), pulled from `node_modules/bootstrap/scss/`. See "Why only these four Bootstrap partials" below before adding more.
3. Writes or updates a sibling `.scss` file — same directory, same basename as the PHP file — with a clearly delimited block, e.g.:
   ```scss
   // === wplite:sass-dependencies:start ===
   @import "components/Misc/social-links/social-links";
   @import "scss/vendor/wpcf7";
   @import "bootstrap/scss/functions";
   @import "bootstrap/scss/variables";
   @import "bootstrap/scss/variables-dark";
   @import "bootstrap/scss/maps";
   @import "bootstrap/scss/mixins";
   @import "bootstrap/scss/alert";
   // === wplite:sass-dependencies:end ===
   ```
   Component and vendor import paths are root-relative from `theme/` (via `--load-path=theme`, matching how `main.scss` already imports these same partials). Bootstrap import paths are relative to `node_modules/` (via `--load-path=node_modules`, added to `compile:sass`/`watch:sass` in `package.json` specifically to support this). Both load paths make the import work correctly regardless of how deep the page's own file lives, with no `../../` climbing.

   Whenever any Bootstrap component is included, the `functions`/`variables`/`variables-dark`/`maps`/`mixins` foundation is included first. This is required, not optional: every page/page-template `.scss` file compiles **standalone** (see the separate `theme/pages:theme/pages` and `theme/page-templates:theme/page-templates` entries in `compile:sass` — no shared scope with `main.scss`), so a Bootstrap component partial can't compile without its own copy of that foundation. This costs nothing extra: those five partials are pure Sass (functions/variables/mixins), they emit no CSS of their own, so re-importing them per page doesn't duplicate any output bytes — unlike, say, `root`, which does emit CSS and is deliberately left out of this per-page foundation since it's already loaded once, globally, via `main.min.css`.
4. Only that block is touched. Anything else already in the `.scss` file — hand-written styles, unrelated imports — is left exactly as-is below the block, so it's safe to re-run any time a page's dependencies change without losing custom work.
5. Prints a summary: which dependencies got imported, which were skipped because their Sass module doesn't exist, and which included files it followed to get there.

## Why only these four Bootstrap partials (`accordion`, `alert`, `carousel`, `nav`)

This list isn't arbitrary — it was verified against the actual codebase, not guessed. This skill can only see `theme/pages/` and `theme/page-templates/` (plus whatever they transitively include). Several Bootstrap components are used by templates *outside* that reach — `header.php` (navbar), `404.php` (buttons), `comments.php` (forms), and the `article-card` component (card), which is rendered from `archive.php`/`category.php`/`tag.php`/`index.php`/`single.php`. None of those are pages or page-templates, so this skill has no way to detect that they need `buttons`/`card`/`forms`/`navbar`/`pagination` — and no way to notice later if that changes. Making those conditional would silently break real, currently-working styling with no mechanism to catch it. So they stay unconditionally global in `main.scss`.

`accordion`, `alert`, `carousel`, and `nav` (Bootstrap's own base nav — distinct from `navbar`) were, at the time this was set up, used nowhere outside `theme/pages/`/`theme/page-templates/` (or, in `alert`'s case, only in `theme/pages/` and files it includes) — confirmed by actually grepping the codebase, not assumed. That's what makes them safe to move to on-demand loading.

**Before adding a new entry to `BOOTSTRAP_DETECTORS`**, grep the *whole* theme (not just `pages/`/`page-templates/`) for that component's class name. If it's used anywhere outside this skill's reach, it needs to stay in `main.scss` instead, exactly like `buttons`/`card`/`forms`/`navbar`/`pagination` above.

## Notes

- Re-running on a file replaces the whole block with the page's current dependencies — imports no longer needed disappear, newly-needed ones appear. Nothing accumulates across runs.
- If the PHP file (and everything it includes) has no matching dependencies, the script still writes an empty managed block. This keeps re-runs idempotent — there's nothing left implicit for a future run to "discover."
- Class detection is a static text scan (`class="..."` / `class='...'` attribute values). A class assembled entirely at runtime with no literal fragment in the scanned files (e.g. built from a PHP variable with no static hint) won't be seen — same inherent limitation as the `Component::render()`/`get_template_part()` scanning.
- This does not run the Sass compiler itself — it only manages the import list. Run `npm run compile:sass`, or rely on `npm run watch:sass` (already running under `make dev`), to actually rebuild the CSS afterward.