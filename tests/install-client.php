<?php

declare(strict_types=1);

// Free-Lizenz über den Baukasten: Client da, Produktname stimmt, Kurztext in Header + readme
$base = __DIR__ . '/../mgd-barrierefrei-wordpress/';
$fail = 0;
$check = static function (bool $ok, string $name) use (&$fail): void {
    echo ($ok ? 'OK   ' : 'FAIL ') . $name . "\n";
    $fail += $ok ? 0 : 1;
};
$kurz = 'Meldet sich höchstens einmal am Tag bei theme.michael-gahn.de (Plugin, Version, Shopsystem, Domain, zufällige ID). Abschaltbar in den Einstellungen.';
$main = (string) file_get_contents($base . 'mgd-barrierefrei-wordpress.php');
$readme = (string) file_get_contents($base . 'readme.txt');
$settings = (string) file_get_contents($base . 'includes/class-mgd-barrierefrei-settings.php');
$hint = (string) file_get_contents($base . 'includes/Kit/Install/Settings.php');

$check(is_file($base . 'includes/Kit/Install/InstallClient.php') && is_file($base . 'includes/Kit/Install/Platform/WordPress.php'), 'Install-Client liegt im Baukasten');
$check(!is_dir($base . 'includes/Install'), 'alter Install-Client ist raus (kein zweiter Client)');
$check(str_contains($main, "Setup::updater(__FILE__, 'mgd-barrierefrei-wordpress', 'wordpress', MGD_BARRIEREFREI_VERSION"), 'updater mit Produktname der Update-Datei (startet den Install-Client)');
$check(!str_contains($main, 'WordPress::boot('), 'kein doppelter boot-Aufruf');
$check(str_contains($settings, "Setup::dashboard('mgd-barrierefrei-wordpress', 'wordpress'"), 'Schalter auf Info und Updates');
$check(str_contains($main, $kurz) && str_contains($readme, $kurz), 'Kurztext in Plugin-Header und readme.txt');
$check(!str_contains($hint, 'ENTWURF'), 'Hinweistext freigegeben');

foreach (['Transport', 'Response', 'Store', 'CallbackStore', 'CurlTransport', 'InstallClient', 'Factory'] as $f) {
    require_once $base . 'includes/Kit/Install/' . $f . '.php';
}
$v = '';
$c = \Mgd\Barrierefrei\Kit\Install\Factory::create(new \Mgd\Barrierefrei\Kit\Install\CallbackStore(static function () use (&$v): mixed { return $v; }, static function (string $n) use (&$v): void { $v = $n; }), 'mgd-barrierefrei-wordpress', 'wordpress', '1.6.1', 'example.org');
$check($c->isEnabled(), 'ab Werk an');
$c->setEnabled(false);
$check(!$c->isEnabled() && $c->ping(true) === false, 'aus = sendet nichts');
exit($fail === 0 ? 0 : 1);
