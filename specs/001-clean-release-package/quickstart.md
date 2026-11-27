# Quickstart: check the clean release package

1. `composer run build` (or `sh bin/build-package.sh`): expect
   `Built …/wp-post-nav.zip`.
2. `unzip -l wp-post-nav.zip`: expect only `admin/`, `includes/`,
   `languages/`, `public/`, `index.php`, `uninstall.php`, `wp-post-nav.php`,
   `README.txt`, `LICENSE.txt` and `Examples.txt` under `wp-post-nav/`.
3. `unzip -t wp-post-nav.zip`: expect "No errors detected".
4. `touch includes/STRAY.md && sh bin/build-package.sh`: expect the build to
   fail and name `includes/STRAY.md`; then `rm includes/STRAY.md`.
5. `rm wp-post-nav.zip` (never commit the package).
