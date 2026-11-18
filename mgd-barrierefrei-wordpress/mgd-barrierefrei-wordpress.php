<?php
/**
 * Plugin Name: MGD Barrierefrei
 * Plugin URI: https://github.com/MichaelGahnDESIGN/MGD-Barrierefrei-WordPress
 * Description: Bedienhilfe, konfigurierbares Modal und Generator für eine Erklärung zur Barrierefreiheit. Meldet sich höchstens einmal am Tag bei theme.michael-gahn.de (Plugin, Version, Shopsystem, Domain, zufällige ID). Abschaltbar in den Einstellungen.
 * Version: 1.5.1
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

define('MGD_BARRIEREFREI_VERSION', '1.5.1');
define('MGD_BARRIEREFREI_FILE', __FILE__);
define('MGD_BARRIEREFREI_DIR', plugin_dir_path(__FILE__));
define('MGD_BARRIEREFREI_URL', plugin_dir_url(__FILE__));

require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-settings.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-statement.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-wordpress-plugin-catalog.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-updater.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-renderer.php';

// Install-Client (Free-Lizenz) laden > includes/Install
spl_autoload_register(static function (string $class): void {
    $prefix = 'MGD\\Barrierefrei\\Install\\';
    if (str_starts_with($class, $prefix)) {
        $file = MGD_BARRIEREFREI_DIR . 'includes/Install/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
});
// meldet sich max 1x am Tag im Admin, Schalter auf der Einstellungsseite
\MGD\Barrierefrei\Install\Platform\WordPress::boot(__FILE__, 'mgd-barrierefrei-wordpress', 'wordpress', MGD_BARRIEREFREI_VERSION, admin_url('admin.php?page=mgd-barrierefrei#mgd-install'));

add_action('plugins_loaded', static function (): void {
    $settings = new MGD_Barrierefrei_Settings();
    $statement = new MGD_Barrierefrei_Statement($settings);

    $settings->register($statement);
    (new MGD_Barrierefrei_Renderer($settings))->register();
    (new MGD_WordPress_Plugin_Catalog_V4())->register('mgd-barrierefrei');
    (new MGD_Barrierefrei_Updater())->register();
});

register_activation_hook(__FILE__, static function (): void {
    if (get_option(MGD_Barrierefrei_Settings::OPTION_NAME, null) === null) {
        add_option(MGD_Barrierefrei_Settings::OPTION_NAME, MGD_Barrierefrei_Settings::defaults(), '', false);
    }
});

require_once __DIR__ . '/includes/class-mgd-plugin-admin-tools.php';
\MGD_Plugin_Admin_Tools_20261023::register([
    'file' => __FILE__,
    'repo' => 'MGD-Barrierefrei-WordPress',
    'slug' => 'mgd-barrierefrei-wordpress',
    'name' => 'MGD Barrierefrei',
    'description' => 'Bedienhilfe, konfigurierbares Modal und Generator für eine Erklärung zur Barrierefreiheit.',
    'version' => '1.5.1',
    'settings' => 'admin.php?page=mgd-barrierefrei',
    'requires' => '6.5',
    'php' => '8.1',
    'caches' => ['mgd_barrierefrei_release_v1'],
    'package' => '',
]);
