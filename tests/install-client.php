<?php

declare(strict_types=1);

// Free-Lizenz: Client da, Produktname stimmt, Kurztext in Header + readme
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
$hint = (string) file_get_contents($base . 'includes/Install/Settings.php');

$check(is_file($base . 'includes/Install/InstallClient.php') && is_file($base . 'includes/Install/Platform/WordPress.php'), 'Install-Client liegt im Plugin');
$check(str_contains($main, "WordPress::boot(__FILE__, 'mgd-barrierefrei', 'wordpress', MGD_BARRIEREFREI_VERSION"), 'boot mit Produktname der Update-Datei');
$check(str_contains($settings, "settingsHtml('mgd-barrierefrei', 'wordpress'"), 'Schalter auf der Einstellungsseite');
$check(str_contains($main, $kurz) && str_contains($readme, $kurz), 'Kurztext in Plugin-Header und readme.txt');
$check(!str_contains($hint, 'ENTWURF'), 'Hinweistext freigegeben');

require_once $base . 'includes/Install/Transport.php';
require_once $base . 'includes/Install/Response.php';
require_once $base . 'includes/Install/Store.php';
require_once $base . 'includes/Install/CallbackStore.php';
require_once $base . 'includes/Install/CurlTransport.php';
require_once $base . 'includes/Install/InstallClient.php';
require_once $base . 'includes/Install/Factory.php';
$v = '';
$c = \MGD\Barrierefrei\Install\Factory::create(new \MGD\Barrierefrei\Install\CallbackStore(static function () use (&$v): mixed { return $v; }, static function (string $n) use (&$v): void { $v = $n; }), 'mgd-barrierefrei', 'wordpress', '1.5.0', 'example.org');
$check($c->isEnabled(), 'ab Werk an');
$c->setEnabled(false);
$check(!$c->isEnabled() && $c->ping(true) === false, 'aus = sendet nichts');
exit($fail === 0 ? 0 : 1);
