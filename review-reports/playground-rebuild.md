# Clean Playground rebuild

## Package validation

- `blueprint.json` is valid JSON.
- Bundled theme ZIP is present at the bundle root as `pethomescout-theme.zip`.
- Blueprint uses a bundled `installTheme` resource.
- Blueprint installs Advanced Custom Fields from WordPress.org.
- Blueprint sets `blog_public` to `0` and `/%postname%/` permalinks.
- Blueprint creates fixture Pages and Posts and flushes rewrite rules.
- `runPHP` explicitly loads `/wordpress/wp-load.php` before creating fixtures.
- Bundle archive paths use POSIX forward slashes.

## Public review blueprint

- `playground-blueprint-public.json` installs the theme ZIP from the review branch and includes the same fixture bootstrap.
- Browser rebuild URL: `https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/Linhca-Git/PetHomeScout.com/codex/pethomescout-review-final/playground-blueprint-public.json`
- Fresh browser scope `brave-vintage-river` rendered all nine review routes with one H1, JSON-LD, and `noindex, nofollow`.

## Automated rebuild result

The clean bundle was started with the WordPress Playground CLI using WordPress 6.7 and PHP 8.2. The fresh site booted and the root review route returned HTTP 200 with the PetHomeScout title.

The separate `build-snapshot` command reached WordPress boot but could not release the SQLite `.htaccess` file lock on Windows. This is an environment limitation of snapshot export, not a missing theme/resource error. The browser-based Playground rebuild itself is confirmed. The generated scope is temporary and its canonical URLs include the Playground scope prefix; final canonical validation must still be repeated on US-hosted staging.
