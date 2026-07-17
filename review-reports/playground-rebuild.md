# Clean Playground rebuild

## Package validation

- `blueprint.json` is valid JSON.
- Bundled theme ZIP is present at the bundle root as `pethomescout-theme.zip`.
- Blueprint uses a bundled `installTheme` resource.
- Blueprint installs Advanced Custom Fields from WordPress.org.
- Blueprint sets `blog_public` to `0` and `/%postname%/` permalinks.
- Blueprint creates fixture Pages and Posts and flushes rewrite rules.
- Bundle archive paths use POSIX forward slashes.

## Automated rebuild result

The clean bundle was started with the WordPress Playground CLI using WordPress 6.7 and PHP 8.2. The fresh site booted and the root review route returned HTTP 200 with the PetHomeScout title.

The separate `build-snapshot` command reached WordPress boot but could not release the SQLite `.htaccess` file lock on Windows. This is an environment limitation of snapshot export, not a missing theme/resource error. The browser-based Playground rebuild itself is confirmed.
