<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/** Empfehlungen sind ausschließlich im WordPress-Backend sichtbar und haben ein sicheres Offline-Fallback. */
final class MGD_Barrierefrei_Catalog
{
    private const TRANSIENT = 'mgd_barrierefrei_catalog_v1';
    private const ENDPOINT = 'https://theme.michael-gahn.de/api/catalog/plugins.json';

    public function register(): void {}

    /** @return list<array<string, string>> */
    private function items(): array
    {
        $cached = get_transient(self::TRANSIENT);
        if (is_array($cached)) {
            return $cached;
        }
        $response = wp_remote_get(self::ENDPOINT, ['timeout' => 3, 'redirection' => 0, 'headers' => ['Accept' => 'application/json']]);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return [];
        }
        $body = json_decode((string) wp_remote_retrieve_body($response), true);
        if (!is_array($body) || ($body['schemaVersion'] ?? null) !== 1 || !is_array($body['items'] ?? null)) {
            return [];
        }
        $items = [];
        foreach ($body['items'] as $item) {
            if (!is_array($item) || !in_array($item['platform'] ?? '', ['wordpress', 'shopware', 'jtl', 'shopify'], true)) {
                continue;
            }
            $url = isset($item['detailsUrl']) && is_string($item['detailsUrl']) ? esc_url_raw($item['detailsUrl']) : '';
            if ($url === '' || wp_parse_url($url, PHP_URL_HOST) !== 'theme.michael-gahn.de') {
                continue;
            }
            $items[] = ['name' => sanitize_text_field((string) ($item['name'] ?? '')), 'description' => sanitize_text_field((string) ($item['description'] ?? '')), 'url' => $url];
        }
        set_transient(self::TRANSIENT, $items, DAY_IN_SECONDS);

        return $items;
    }

    public function render(): void
    {
        $items = $this->items();
        if ($items === []) {
            return;
        }
        ?><section class="mgd-a11y-card mgd-a11y-recommendations"><h2>Weitere kostenlose MGD-Plugins</h2><ul><?php foreach ($items as $item): ?><li><a href="<?= esc_url($item['url']) ?>" target="_blank" rel="noopener noreferrer"><strong><?= esc_html($item['name']) ?></strong><span><?= esc_html($item['description']) ?></span></a></li><?php endforeach; ?></ul></section><?php
    }
}
