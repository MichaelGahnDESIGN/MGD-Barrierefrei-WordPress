<?php
/**
 * Plugin Name: MGD Barrierefrei
 * Plugin URI: https://github.com/MichaelGahnDESIGN/MGD-Barrierefrei-WordPress
 * Description: Bedienhilfe, konfigurierbares Modal und Generator für eine Erklärung zur Barrierefreiheit.
 * Version: 1.0.1
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

define('MGD_BARRIEREFREI_VERSION', '1.0.1');
define('MGD_BARRIEREFREI_FILE', __FILE__);
define('MGD_BARRIEREFREI_DIR', plugin_dir_path(__FILE__));
define('MGD_BARRIEREFREI_URL', plugin_dir_url(__FILE__));

require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-settings.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-statement.php';
require_once MGD_BARRIEREFREI_DIR . 'includes/class-mgd-barrierefrei-renderer.php';

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

require_once __DIR__ . '/includes/class-mgd-plugin-admin-tools.php';
\MGD_WordPress_Org_Admin_Tools::register([
    'file' => __FILE__,
    'repo' => 'MGD-Barrierefrei-WordPress',
    'slug' => 'mgd-barrierefrei',
    'name' => 'MGD Barrierefrei',
    'description' => 'Bedienhilfe, konfigurierbares Modal und Generator für eine Erklärung zur Barrierefreiheit.',
    'version' => '1.0.1',
    'settings' => 'admin.php?page=mgd-barrierefrei',
    'requires' => '6.5',
    'php' => '8.1',
    'caches' => ['mgd_barrierefrei_release_v1'],
    'package' => '',
]);
