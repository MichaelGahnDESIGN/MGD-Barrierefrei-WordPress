<?php

declare(strict_types=1);

// Test Widget-Config ohne WordPress: php tests/widget-config.php
// Mini-Stubs für die paar WP Funktionen

define('ABSPATH', __DIR__);
define('MGD_BARRIEREFREI_URL', 'https://example.test/wp-content/plugins/mgd-barrierefrei-wordpress/');
define('MGD_BARRIEREFREI_VERSION', 'test');
$GLOBALS['opt'] = [];
$GLOBALS['get'] = [];
function get_option($k, $d = false) { return $GLOBALS['opt'][$k] ?? $d; }
function wp_parse_args($a, $d) { return array_merge($d, $a); }
function get_bloginfo($k) { return 'Testshop'; }
function home_url($p = '') { return 'https://example.test' . $p; }
function get_post_status($id) { return $id === 7 ? 'publish' : false; }
function get_permalink($id) { return 'https://example.test/barrierefreiheit/'; }
function wp_make_link_relative($u) { return (string) preg_replace('#^https?://[^/]+#', '', $u); }
function is_admin() { return false; }
function wp_doing_ajax() { return false; }
function is_feed() { return false; }
function is_embed() { return false; }
function apply_filters($h, $v) { return $v; }
function wp_json_encode($v, $f = 0) { return json_encode($v, $f); }

require __DIR__ . '/../mgd-barrierefrei-wordpress/includes/class-mgd-barrierefrei-statement.php';
require __DIR__ . '/../mgd-barrierefrei-wordpress/includes/class-mgd-barrierefrei-settings.php';
require __DIR__ . '/../mgd-barrierefrei-wordpress/includes/class-mgd-barrierefrei-renderer.php';

$fail = 0;
$check = static function (bool $ok, string $msg) use (&$fail): void {
    echo ($ok ? 'OK   ' : 'FAIL ') . $msg . "\n";
    $fail += $ok ? 0 : 1;
};
$r = new MGD_Barrierefrei_Renderer(new MGD_Barrierefrei_Settings());

$c = $r->widget_config();
$check($c['lang'] === 'auto' && $c['theme'] === 'auto' && $c['labels'] === ['de' => '', 'en' => ''] && $c['statementUrl'] === '', 'Defaults');

$GLOBALS['opt']['mgd_barrierefrei_settings'] = ['default_lang' => 'en', 'default_theme' => 'dark', 'position' => 'right', 'button_label' => 'Hilfe', 'statement_page_id' => 7, 'offset' => 500];
$c = $r->widget_config();
$check($c['lang'] === 'en' && $c['theme'] === 'dark' && $c['position'] === 'right' && $c['labels']['de'] === 'Hilfe', 'Gespeicherte Standards');
$check($c['statementUrl'] === '/barrierefreiheit/', 'Erklärung als relativer Link');
$check($c['offset'] === 200, 'Abstand max 200');

$GLOBALS['opt']['mgd_barrierefrei_settings'] = ['default_lang' => 'xx', 'default_theme' => '<b>', 'statement_page_id' => 9];
$c = $r->widget_config();
$check($c['lang'] === 'auto' && $c['theme'] === 'auto' && $c['statementUrl'] === '', 'Ungültig > auto, Entwurf-Seite ohne Link');

$GLOBALS['opt']['mgd_barrierefrei_settings'] = ['button_label' => '</script><script>alert(1)</script>'];
ob_start();
$r->config();
$out = (string) ob_get_clean();
$check(substr_count($out, '</script>') === 1, 'Config kann Script-Tag nicht schließen');

$_GET = ['et_fb' => '1'];
$check(MGD_Barrierefrei_Renderer::in_builder_editor(), 'Divi Visual Builder erkannt');
$_GET = ['elementor-preview' => '5'];
$check(MGD_Barrierefrei_Renderer::in_builder_editor(), 'Elementor Vorschau erkannt');
$_GET = ['bricks' => 'run'];
$check(MGD_Barrierefrei_Renderer::in_builder_editor(), 'Bricks erkannt');
$_GET = [];
$check(!MGD_Barrierefrei_Renderer::in_builder_editor(), 'Normale Seite: kein Editor');

exit($fail > 0 ? 1 : 0);
