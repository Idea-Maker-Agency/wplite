---
name: wplite-sync-component-scss
description: Keeps a wplite theme page or page-template's Sass file in sync with its build-time Sass dependencies - both the reusable components it renders via Component::render(), and known vendor integrations it uses like Contact Form 7 - by writing/updating a managed block of @import lines. Use this whenever the user is building or editing a file under theme/pages/ or theme/page-templates/ in this repo and wants that page's component or vendor styles wired up, mentions "component styles", "scss imports", "sync scss", "wpcf7"/"contact form 7" styling, or asks why a component's or a form's styles aren't showing up on a specific page. Also use proactively right after adding, removing, or changing a Component::render() call, or after adding a Contact Form 7 shortcode, in a page or page-template file, so its Sass stays correct without the user having to ask separately.
---

# wplite: Sync Component SCSS

## Why this exists

wplite is a parent theme: pages and page-templates each compile to their own CSS file (`pages/{slug}.scss` -> `pages/{slug}.css`, `page-templates/{name}/{name}.scss` -> `.css`), auto-enqueued per page by `AssetController` based on the current page's slug. Reusable components under `theme/components/` can ship their own `.scss` module, and some vendor plugin integrations (e.g. Contact Form 7) ship a Sass partial under `theme/scss/vendor/`.

Rather than bundling every component's or vendor's styles into one global stylesheet (ships unused CSS on every page) or wiring up runtime WordPress enqueue logic (`Component::render()` calls happen mid-body, after `wp_head()` has already fired and queued `<head>` styles — too late for a component to enqueue its own stylesheet at render time), this project resolves these dependencies at build time: a page's own `.scss` file simply `@import`s the `.scss` module of each component it uses, and the vendor partial for any plugin integration it needs. Sass compiles that straight into the page's own CSS file, which is already correctly `<head>`-loaded — no runtime enqueue logic needed at all, and no ordering problem to solve.

This skill keeps that import list correct as a page's dependencies change, so building a new page-template stays a matter of "call the components you need" rather than also hand-maintaining a parallel Sass import list.

## When to run it

- The user asks to sync, update, or wire up SCSS imports for a page or page-template.
- You (or the user) just added, removed, or changed a `Component::render()` call, or a vendor integration like a Contact Form 7 shortcode, in a file under `theme/pages/` or `theme/page-templates/` — run this right after, without waiting to be asked, so the Sass file never drifts out of sync with what the page actually renders.
- The user reports a component's or a form's styles aren't appearing on a specific page.

## How to run it

```bash
node .claude/skills/wplite-sync-component-scss/scripts/sync.mjs <path-to-php-file>
```

Point it at the page or page-template PHP file itself (e.g. `theme/pages/login.php` or `theme/page-templates/contact/contact.php`), not the `.scss` file. It only operates on files under `theme/pages/` or `theme/page-templates/` — those are the only directories this project's Sass build compiles per-file (see `compile:sass` in `package.json`). Anything else has no corresponding compiled CSS output for an `@import` to land in, so the script refuses and explains why rather than silently writing a `.scss` file nothing will ever compile.

If the user has a specific file open or in progress, use that one without asking which file to target. If they want a broader sync, offer to run it across every file under `theme/pages/**/*.php` and `theme/page-templates/**/*.php`.

## What it does

1. Reads the PHP file and finds every `Component::render('name', 'Namespace', ...)` call (namespace is optional — omitted means the component lives directly under `theme/components/{name}/`, not inside a namespace subfolder). For each one, checks whether `theme/components/{Namespace}/{name}/{name}.scss` exists. Components without a Sass module are silently skipped — most components (buttons, links, layout wrappers) never need their own stylesheet, so this is the common case, not an error worth surfacing as a warning.
2. Also checks the PHP file against a small list of known vendor integrations (currently just Contact Form 7, detected by the presence of the `contact-form-7` shortcode string) and, if matched and `theme/scss/vendor/_<name>.scss` exists, includes that partial too. Adding support for another plugin integration later is a one-line addition to the `VENDOR_DETECTORS` list in `scripts/sync.mjs`.
3. Writes or updates a sibling `.scss` file — same directory, same basename as the PHP file — with a clearly delimited block, e.g.:
   ```scss
   // === wplite:sass-dependencies:start ===
   @import "components/Misc/social-links/social-links";
   @import "scss/vendor/wpcf7";
   // === wplite:sass-dependencies:end ===
   ```
   Import paths are root-relative from `theme/`, matching how `theme/scss/main.scss` already imports these same partials today — this project's Sass compile commands run with `--load-path=theme`, so this resolves correctly without `../../` climbing regardless of how deep the page's own file lives.
4. Only that block is touched. Anything else already in the `.scss` file — hand-written styles, unrelated imports — is left exactly as-is below the block, so it's safe to re-run any time a page's dependencies change without losing custom work.
5. Prints a summary: which dependencies got imported, and which were skipped because their Sass module doesn't exist, so "correctly has no styles to add" is distinguishable from "silently missed something."

## Notes

- Re-running on a file replaces the whole block with the page's current dependencies — imports no longer needed disappear, newly-needed ones appear. Nothing accumulates across runs.
- If the PHP file has no matching dependencies, or none of the ones it has ship a Sass module, the script still writes an empty managed block. This keeps re-runs idempotent — there's nothing left implicit for a future run to "discover."
- Since a vendor partial like `theme/scss/vendor/_wpcf7.scss` is now only pulled in per-page by this skill, it should be removed from `theme/scss/main.scss`'s global import list — otherwise every page still ships that CSS regardless of whether it uses the integration, defeating the point.
- This does not run the Sass compiler itself — it only manages the import list. Run `npm run compile:sass`, or rely on `npm run watch:sass` (already running under `make dev`), to actually rebuild the CSS afterward.
