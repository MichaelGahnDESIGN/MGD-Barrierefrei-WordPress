<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/** GitHub-Release-Update ohne Token: nur signierte HTTPS-Metadaten des festen öffentlichen Repositorys. */
final class MGD_Barrierefrei_Updater
{
    private const REPOSITORY = 'MichaelGahnDESIGN/MGD-Barrierefrei-WordPress';
    private const TRANSIENT = 'mgd_barrierefrei_release_v1';

    public function register(): void
    {
        add_filter('pre_set_site_transient_update_plugins', [$this, 'inject']);
        add_filter('plugins_api', [$this, 'details'], 10, 3);
    }

    public function inject(object $transient): object
    {
        if (empty($transient->checked) || !is_array($transient->checked)) {
            return $transient;
        }
        $release = $this->release();
        if ($release === null || !version_compare($release['version'], MGD_BARRIEREFREI_VERSION, '>')) {
            return $transient;
        }
        $file = plugin_basename(MGD_BARRIEREFREI_FILE);
        $transient->response[$file] = (object) ['slug' => 'mgd-barrierefrei-wordpress', 'plugin' => $file, 'new_version' => $release['version'], 'url' => 'https://github.com/' . self::REPOSITORY, 'package' => $release['download']];

        return $transient;
    }

    public function details(mixed $result, string $action, object $args): mixed
    {
        if ($action !== 'plugin_information' || ($args->slug ?? '') !== 'mgd-barrierefrei-wordpress') {
            return $result;
        }
        $release = $this->release();
        if ($release === null) {
            return $result;
        }

        return (object) ['name' => 'MGD Barrierefrei', 'slug' => 'mgd-barrierefrei-wordpress', 'version' => $release['version'], 'homepage' => 'https://github.com/' . self::REPOSITORY, 'sections' => ['description' => 'Bedienhilfe, anpassbares Modal und Generator für eine Erklärung zur Barrierefreiheit.']];
    }

    /** @return array{version:string,download:string}|null */
    private function release(): ?array
    {
        $cached = get_site_transient(self::TRANSIENT);
        if (is_array($cached) && isset($cached['version'], $cached['download'])) {
            return $cached;
        }
        $response = wp_remote_get('https://api.github.com/repos/' . self::REPOSITORY . '/releases/latest', ['timeout' => 5, 'headers' => ['Accept' => 'application/vnd.github+json', 'User-Agent' => 'MGD-Barrierefrei-WordPress/' . MGD_BARRIEREFREI_VERSION]]);
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return null;
        }
        $data = json_decode((string) wp_remote_retrieve_body($response), true);
        $tag = is_array($data) ? ltrim((string) ($data['tag_name'] ?? ''), 'v') : '';
        $download = '';
        if (is_array($data['assets'] ?? null)) {
            foreach ($data['assets'] as $asset) {
                if (is_array($asset) && ($asset['name'] ?? '') === 'mgd-barrierefrei-wordpress.zip') {
                    $download = (string) ($asset['browser_download_url'] ?? '');
                    break;
                }
            }
        }
        $host = wp_parse_url($download, PHP_URL_HOST);
        if (preg_match('/^\d+\.\d+\.\d+$/', $tag) !== 1 || !in_array($host, ['github.com', 'objects.githubusercontent.com'], true)) {
            return null;
        }
        $release = ['version' => $tag, 'download' => esc_url_raw($download)];
        set_site_transient(self::TRANSIENT, $release, 6 * HOUR_IN_SECONDS);

        return $release;
    }
}
