<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/** Bedienhilfe im Frontend. Widget baut sich selbst im Shadow DOM, hier nur Config + Script. */
final class MGD_Barrierefrei_Renderer
{
    private const HANDLE = 'mgd-barrierefrei';

    public function __construct(private MGD_Barrierefrei_Settings $settings) {}

    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'assets']);
        add_action('wp_footer', [$this, 'config'], 5);
        add_filter('script_loader_tag', [$this, 'script_tag'], 10, 2);

        // Cache/Optimierungs-Plugins: Widget nicht verzögern oder zusammenfassen
        $exclude = static function ($list) {
            $list = is_array($list) ? $list : [];
            $list[] = 'mgd-barrierefrei-wordpress/assets/js/frontend.js';
            $list[] = 'mgd-barrierefrei-config';
            return $list;
        };
        foreach (['rocket_delay_js_exclusions', 'rocket_exclude_js', 'rocket_exclude_defer_js', 'litespeed_optm_js_defer_exc', 'litespeed_optm_js_exc', 'litespeed_optm_js_delay_inc_exc', 'perfmatters_delay_js_exclusions', 'sgo_javascript_combine_exclude', 'sgo_js_minify_exclude', 'sgo_js_async_exclude'] as $hook) {
            add_filter($hook, $exclude);
        }
        add_filter('autoptimize_filter_js_exclude', static function ($csv) {
            return trim((string) $csv . ', mgd-barrierefrei-wordpress/assets/js/frontend.js, mgd-barrierefrei-config', ', ');
        });
    }

    public function should_render(): bool
    {
        if (is_admin() || wp_doing_ajax() || is_feed() || is_embed() || (function_exists('wp_is_json_request') && wp_is_json_request())) {
            return false;
        }
        if (!$this->settings->all()['enabled']) {
            return false;
        }

        return !self::in_builder_editor();
    }

    /** Im Editor der Page-Builder nicht stören (Divi 4/5, Elementor, Bricks, Beaver, Oxygen ...) */
    public static function in_builder_editor(): bool
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- nur Erkennung, keine Aktion
        $get = $_GET;
        foreach (['et_fb', 'et_bfb', 'elementor-preview', 'fl_builder', 'bricks', 'ct_builder', 'oxygen_iframe', 'breakdance', 'breakdance_iframe', 'brizy-edit', 'brizy-edit-iframe', 'vc_editable', 'vc_action', 'tve', 'tb-preview', 'zionbuilder-preview', 'cs-render', 'uxb_iframe', 'givewp-route'] as $key) {
            if (isset($get[$key])) {
                return true;
            }
        }
        if (function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled()) {
            return true;
        }
        if (class_exists('\Elementor\Plugin') && isset(\Elementor\Plugin::$instance->preview) && \Elementor\Plugin::$instance->preview->is_preview_mode()) {
            return true;
        }
        if (function_exists('bricks_is_builder') && bricks_is_builder()) {
            return true;
        }
        if (class_exists('FLBuilderModel') && method_exists('FLBuilderModel', 'is_builder_active') && FLBuilderModel::is_builder_active()) {
            return true;
        }

        return (bool) apply_filters('mgd_barrierefrei_in_builder_editor', false);
    }

    public function assets(): void
    {
        if (!$this->should_render()) {
            return;
        }
        wp_enqueue_script(self::HANDLE, MGD_BARRIEREFREI_URL . 'assets/js/frontend.js', [], MGD_BARRIEREFREI_VERSION, ['in_footer' => true, 'strategy' => 'defer']);
    }

    public function script_tag(string $tag, string $handle): string
    {
        if ($handle !== self::HANDLE) {
            return $tag;
        }

        return str_replace(' src=', ' data-no-optimize="1" data-no-defer="1" data-no-minify="1" data-cfasync="false" src=', $tag);
    }

    /** @return array<string, mixed> */
    public function widget_config(): array
    {
        $s = $this->settings->all();
        $de = trim((string) $s['button_label']);
        $en = trim((string) $s['button_label_en']);
        $url = '';
        if ((int) $s['statement_page_id'] > 0 && get_post_status((int) $s['statement_page_id']) === 'publish') {
            // relativ, klappt auch ohne https lokal
            $url = wp_make_link_relative((string) get_permalink((int) $s['statement_page_id']));
        }

        return [
            'position' => $s['position'] === 'right' ? 'right' : 'left',
            'accent' => (string) $s['accent_color'],
            'lang' => in_array($s['default_lang'], ['auto', 'de', 'en'], true) ? $s['default_lang'] : 'auto',
            'theme' => in_array($s['default_theme'], ['auto', 'light', 'dark'], true) ? $s['default_theme'] : 'auto',
            'labels' => ['de' => $de === 'Barrierefreiheit' ? '' : $de, 'en' => $en === 'Accessibility' ? '' : $en],
            'statementUrl' => str_starts_with($url, '/') && !str_starts_with($url, '//') ? $url : '',
            'offset' => max(0, min(200, (int) $s['offset'])),
        ];
    }

    public function config(): void
    {
        if (!$this->should_render()) {
            return;
        }
        $json = wp_json_encode($this->widget_config(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($json)) {
            return;
        }
        // JSON ist durch JSON_HEX_TAG sicher im Script-Tag
        echo '<script type="application/json" id="mgd-barrierefrei-config" data-no-optimize="1">' . $json . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
