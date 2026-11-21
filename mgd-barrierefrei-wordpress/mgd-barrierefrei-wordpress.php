<?php
/**
 * Plugin Name: MGD Barrierefrei
 * Plugin URI: https://github.com/MichaelGahnDESIGN/MGD-Barrierefrei-WordPress
 * Description: Bedienhilfe, konfigurierbares Modal und Generator für eine Erklärung zur Barrierefreiheit. Meldet sich höchstens einmal am Tag bei theme.michael-gahn.de (Plugin, Version, Shopsystem, Domain, zufällige ID). Abschaltbar in den Einstellungen.
 * Version: 1.6.0
 * Update URI: https://github.com/MichaelGahnDESIGN/MGD-Barrierefrei-WordPress
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Author: Michael Gahn DESIGN
 * Author URI: https://michael-gahn.de
 * License: GPL-2.0-or-later
 * Text Domain: mgd-barrierefrei
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

define('MGD_BARRIEREFREI_VERSION', '1.6.0');
define('MGD_BARRIEREFREI_FILE', __FILE__);
define('MGD_BARRIEREFREI_DIR', plugin_dir_path(__FILE__));
define('MGD_BARRIEREFREI_URL', plugin_dir_url(__FILE__));

require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-settings.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-statement.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-renderer.php';

// Baukasten aus MichaThemeV5-Pro > includes/Kit (bin/build-plugin-kit.php)
spl_autoload_register(static function (string $class): void {
    $prefix = 'Mgd\\Barrierefrei\\Kit\\';
    if (str_starts_with($class, $prefix)) {
        $file = MGD_BARRIEREFREI_DIR . 'includes/Kit/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
});

// Updater vom Baukasten, startet auch den Install-Melder - alter GitHub-Updater + Admin-Tools sind raus
MGD_Barrierefrei_Settings::$updater = \Mgd\Barrierefrei\Kit\Platform\WordPress\Setup::updater(__FILE__, 'mgd-barrierefrei-wordpress', 'wordpress', MGD_BARRIEREFREI_VERSION, 'MGD Barrierefrei', admin_url('admin.php?page=' . MGD_Barrierefrei_Settings::INFO_PAGE));
// Reste vom alten Updater wegräumen, 1x pro Version - nur eigene Keys, die anderen MGD-Plugins nutzen den Rest noch
\Mgd\Barrierefrei\Kit\Platform\WordPress\Setup::cleanupLegacy('mgd-barrierefrei-wordpress', MGD_BARRIEREFREI_VERSION, ['mgd_barrierefrei_release_v1', 'mgd_admin_release_mgd-barrierefrei-wordpress']);

add_action('plugins_loaded', static function (): void {
    $settings = new MGD_Barrierefrei_Settings();
    $statement = new MGD_Barrierefrei_Statement($settings);

    $settings->register($statement);
    (new MGD_Barrierefrei_Renderer($settings))->register();
});

register_activation_hook(__FILE__, static function (): void {
    if (get_option(MGD_Barrierefrei_Settings::OPTION_NAME, null) === null) {
        add_option(MGD_Barrierefrei_Settings::OPTION_NAME, MGD_Barrierefrei_Settings::defaults(), '', false);
    }
});
