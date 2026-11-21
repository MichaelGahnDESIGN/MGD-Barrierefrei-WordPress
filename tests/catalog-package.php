<?php
/** Paketvertrag: gemeinsame Katalogdaten, neue Klasse, Versionsangaben und lokale Grafiken. */
$root = dirname(__DIR__);
$config = json_decode(file_get_contents(__DIR__ . '/catalog-config.json'), true);
$runtime = $root . '/' . $config['runtime'];
function mgd_catalog_assert(bool $ok, string $name): void {
    if (!$ok) { fwrite(STDERR, 'FAIL ' . $name . "\n"); exit(1); }
}
$main = file_get_contents($runtime . '/' . $config['main']);
mgd_catalog_assert((bool) preg_match('/Version:\s*' . preg_quote($config['version'], '/') . '\s/', $main), 'Pluginversion');
$metadata = json_decode(file_get_contents($runtime . '/includes/plugin-catalog/plugins.json'), true);
mgd_catalog_assert(count($metadata) === 7, 'Sieben bekannte WordPress-Plugins');
foreach ($metadata as $repo => $item) {
    mgd_catalog_assert($item['repository'] === $repo && $item['tier'] === 'free', 'Bekannte kostenlose Einträge');
    $file = $runtime . '/assets/plugin-catalog/icons/' . $item['icon'];
    mgd_catalog_assert(is_file($file) && filesize($file) > 100, 'Lokales Icon ' . $repo);
    mgd_catalog_assert(!str_contains(file_get_contents($file), 'https://'), 'Kein externer Bildabruf im Icon');
    $picture = $runtime . '/assets/plugin-catalog/backgrounds/' . pathinfo($item['icon'], PATHINFO_FILENAME) . '.webp';
    $size = is_file($picture) ? getimagesize($picture) : false;
    mgd_catalog_assert($size && $size[0] === 1080 && $size[1] === 360 && $size['mime'] === 'image/webp', 'Lokales Kartenmotiv ' . $repo);
    mgd_catalog_assert(filesize($picture) < 80000, 'Kompaktes Kartenmotiv ' . $repo);
}
// ab 1.6.1: alte Seite MGD Plugin-Kollektion ganz raus, nur plugins.json bleibt als Ersatzliste
mgd_catalog_assert(is_file($runtime . '/includes/plugin-catalog/plugins.json'), 'Ersatzliste plugins.json');
foreach (array('includes/class-mgd-wordpress-plugin-catalog.php', 'includes/plugin-catalog/class-provider.php', 'includes/plugin-catalog/class-media.php', 'includes/plugin-catalog/view.php', 'assets/plugin-catalog/catalog.css', 'assets/plugin-catalog/catalog.js') as $name) {
    mgd_catalog_assert(!is_file($runtime . '/' . $name), 'Alte Katalogdatei entfernt: ' . $name);
}
$bootstrap = $main;
foreach (glob($runtime . '/includes/*.php') as $file) { $bootstrap .= file_get_contents($file); }
// ab 1.6.0: Weitere Plugins + Updates über den Baukasten, alte Updater nicht mehr angemeldet
mgd_catalog_assert(str_contains($bootstrap, "Setup::dashboard('mgd-barrierefrei-wordpress'"), 'Info und Updates über das Baukasten-Dashboard');
mgd_catalog_assert(str_contains($bootstrap, "Setup::recommendations('mgd-barrierefrei-wordpress', 'wordpress', 'plugin-barrierefrei-wordpress'"), 'Weitere Plugins über den Baukasten');
mgd_catalog_assert(str_contains($bootstrap, "Setup::catalogActions('mgd-barrierefrei-wordpress'") && str_contains($bootstrap, "add_action('admin_init', [self::class, 'catalog_actions'])"), 'Knopf Installieren über admin-post angemeldet');
mgd_catalog_assert(is_file($runtime . '/includes/Kit/Platform/WordPress/CatalogInstaller.php') && is_file($runtime . '/includes/Kit/Platform/WordPress/assets/kit-catalog.js'), 'Neue Ansicht Weitere Plugins im Baukasten');
mgd_catalog_assert(!str_contains($bootstrap, 'class-mgd-wordpress-plugin-catalog.php') && !str_contains($bootstrap, 'MGD_Catalog_V4_Provider'), 'Kein require der alten Katalogseite');
mgd_catalog_assert(str_contains($main, "Setup::updater(__FILE__, 'mgd-barrierefrei-wordpress'"), 'Baukasten-Updater angemeldet');
mgd_catalog_assert(!str_contains($main, 'MGD_Plugin_Admin_Tools_20261023::register') && !str_contains($main, 'MGD_Barrierefrei_Updater') && !str_contains($main, 'MGD_WordPress_Plugin_Catalog_V4'), 'Alte Updater und alte Katalogseite abgeschaltet');
mgd_catalog_assert(is_file($runtime . '/includes/Kit/Platform/WordPress/Updater.php'), 'Baukasten vorhanden');
mgd_catalog_assert(str_contains((string) file_get_contents($runtime . '/uninstall.php'), "Setup::uninstall('mgd-barrierefrei-wordpress', 'wordpress')"), 'Abmelden beim Deinstallieren');
foreach ($metadata as $repo => $item) { mgd_catalog_assert(!empty($item['slug']), 'Katalog-Kennung ' . $repo); }
echo "PASS Pluginversion, sieben Katalogeinträge, lokale Icons, neue Ansicht Weitere Plugins, alte Katalogseite entfernt\n";
