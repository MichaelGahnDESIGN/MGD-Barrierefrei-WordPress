<?php
/** Paketvertrag ab MGD Tools: Version, Baukasten, kein eigenes Menü, Icons, alte Teile weg. */
$root = dirname(__DIR__);
$config = json_decode(file_get_contents(__DIR__ . '/catalog-config.json'), true);
$runtime = $root . '/' . $config['runtime'];
function mgd_catalog_assert(bool $ok, string $name): void {
    if (!$ok) { fwrite(STDERR, 'FAIL ' . $name . "\n"); exit(1); }
}
$main = file_get_contents($runtime . '/' . $config['main']);
$settings = file_get_contents($runtime . '/includes/class-mgd-barrierefrei-settings.php');
mgd_catalog_assert((bool) preg_match('/Version:\s*' . preg_quote($config['version'], '/') . '\s/', $main), 'Pluginversion');
// MGD Tools: Updater + Menü vom Baukasten, eigenes Menü raus
mgd_catalog_assert(str_contains($main, "Setup::updater(__FILE__, 'mgd-barrierefrei-wordpress'"), 'Baukasten-Updater angemeldet');
mgd_catalog_assert(str_contains($main, "Setup::tools(__FILE__, 'mgd-barrierefrei-wordpress'") && str_contains($main, "'page' => 'mgd-barrierefrei'"), 'Einstellungen unter MGD Tools, Seiten-Kennung bleibt');
mgd_catalog_assert(!str_contains($settings, 'add_menu_page') && !str_contains($settings, 'add_submenu_page') && !str_contains($settings, 'add_options_page'), 'kein eigenes Menü');
mgd_catalog_assert(!str_contains($settings, 'INFO_PAGE') && !str_contains($settings, 'self::$updater'), 'keine Reste vom alten Info-Menü');
mgd_catalog_assert(str_contains($settings, 'data-mgd-color') && !str_contains($settings, 'type="color"'), 'Farbfeld nutzt den MGD Farbwähler');
mgd_catalog_assert(str_contains($main, 'Plugin URI: https://theme.michael-gahn.de/plugins/plugin-barrierefrei-wordpress') && !str_contains($main, 'Update URI'), 'Plugin-Kopf nach Norm');
// alte Teile komplett weg
foreach (array('includes/class-mgd-plugin-admin-tools.php', 'includes/class-mgd-barrierefrei-updater.php', 'includes/class-mgd-barrierefrei-catalog.php', 'includes/class-mgd-wordpress-plugin-catalog.php', 'includes/plugin-catalog', 'assets/plugin-catalog') as $name) {
    mgd_catalog_assert(!file_exists($runtime . '/' . $name), 'Alter Teil entfernt: ' . $name);
}
// Icons + Baukasten + Abmelden
foreach (array('assets/icon-128x128.png', 'assets/icon-256x256.png', 'includes/Kit/Platform/WordPress/Tools.php', 'includes/Kit/Platform/WordPress/Updater.php') as $f) {
    mgd_catalog_assert(is_file($runtime . '/' . $f), 'Datei da: ' . $f);
}
mgd_catalog_assert(str_contains((string) file_get_contents($runtime . '/uninstall.php'), "Setup::uninstall('mgd-barrierefrei-wordpress', 'wordpress')"), 'Abmelden beim Deinstallieren');
echo "PASS Pluginversion, MGD Tools, Icons, alter Update- und Katalogcode entfernt\n";
