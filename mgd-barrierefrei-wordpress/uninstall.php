<?php

declare(strict_types=1);

// Deinstallieren: bei theme.michael-gahn.de abmelden + Baukasten-Daten weg, Einstellungen bleiben
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Hauptdatei wird hier nicht geladen > Kit selbst laden
spl_autoload_register(static function (string $class): void {
    $prefix = 'Mgd\\Barrierefrei\\Kit\\';
    if (str_starts_with($class, $prefix)) {
        $file = __DIR__ . '/includes/Kit/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
});

\Mgd\Barrierefrei\Kit\Platform\WordPress\Setup::uninstall('mgd-barrierefrei-wordpress', 'wordpress');
