<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/** Einstellungen und zugängliche WordPress-Verwaltungsseite. */
final class MGD_Barrierefrei_Settings
{
    public const OPTION_NAME = 'mgd_barrierefrei_settings';
    private const CAPABILITY = 'manage_options';

    /** @return array<string, mixed> */
    public static function defaults(): array
    {
        return [
            'enabled' => true,
            'button_label' => 'Barrierefreiheit',
            'position' => 'left',
            'accent_color' => '#c8171f',
            'panel_title' => 'Einstellungen für bessere Lesbarkeit',
            'statement_page_id' => 0,
            'organisation' => get_bloginfo('name'),
            'website_url' => home_url('/'),
            'responsible_name' => '',
            'responsible_role' => '',
            'contact_email' => get_option('admin_email'),
            'contact_phone' => '',
            'statement_status' => 'teilweise',
            'known_barriers' => '',
            'statement_date' => gmdate('Y-m-d'),
        ];
    }

    /** @return array<string, mixed> */
    public function all(): array
    {
        $value = get_option(self::OPTION_NAME, []);

        return wp_parse_args(is_array($value) ? $value : [], self::defaults());
    }

    public function register(MGD_Barrierefrei_Statement $statement): void
    {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'save']);
        add_action('admin_enqueue_scripts', [$this, 'assets']);
        add_action('admin_post_mgd_barrierefrei_create_statement_page', [$statement, 'create_or_update_page']);
    }

    public function add_menu(): void
    {
        add_menu_page(
            'MGD Barrierefrei',
            'MGD Barrierefrei',
            self::CAPABILITY,
            'mgd-barrierefrei',
            [$this, 'page'],
            'dashicons-universal-access-alt',
            81
        );
    }

    public function assets(string $hook): void
    {
        if ($hook !== 'toplevel_page_mgd-barrierefrei') {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_style('mgd-barrierefrei-admin', MGD_BARRIEREFREI_URL . 'assets/css/admin.css', [], MGD_BARRIEREFREI_VERSION);
        wp_enqueue_script('mgd-barrierefrei-admin', MGD_BARRIEREFREI_URL . 'assets/js/admin.js', ['jquery'], MGD_BARRIEREFREI_VERSION, true);
    }

    public function save(): void
    {
        if (!is_admin() || !isset($_POST['mgd_barrierefrei_save'])) {
            return;
        }
        if (!current_user_can(self::CAPABILITY)) {
            wp_die(esc_html__('Du hast keine Berechtigung für diese Einstellung.', 'mgd-barrierefrei'));
        }
        check_admin_referer('mgd_barrierefrei_save');

        $raw = wp_unslash($_POST['mgd_barrierefrei'] ?? []);
        $raw = is_array($raw) ? $raw : [];
        $current = $this->all();
        $colors = sanitize_hex_color((string) ($raw['accent_color'] ?? ''));
        $date = sanitize_text_field((string) ($raw['statement_date'] ?? ''));

        $next = [
            'enabled' => !empty($raw['enabled']),
            'button_label' => sanitize_text_field((string) ($raw['button_label'] ?? $current['button_label'])),
            'position' => in_array(($raw['position'] ?? ''), ['left', 'right'], true) ? $raw['position'] : 'left',
            'accent_color' => $colors ?: '#c8171f',
            'panel_title' => sanitize_text_field((string) ($raw['panel_title'] ?? $current['panel_title'])),
            'statement_page_id' => absint($raw['statement_page_id'] ?? 0),
            'organisation' => sanitize_text_field((string) ($raw['organisation'] ?? '')),
            'website_url' => esc_url_raw((string) ($raw['website_url'] ?? '')),
            'responsible_name' => sanitize_text_field((string) ($raw['responsible_name'] ?? '')),
            'responsible_role' => sanitize_text_field((string) ($raw['responsible_role'] ?? '')),
            'contact_email' => sanitize_email((string) ($raw['contact_email'] ?? '')),
            'contact_phone' => sanitize_text_field((string) ($raw['contact_phone'] ?? '')),
            'statement_status' => in_array(($raw['statement_status'] ?? ''), ['vollstaendig', 'teilweise', 'nicht'], true) ? $raw['statement_status'] : 'teilweise',
            'known_barriers' => sanitize_textarea_field((string) ($raw['known_barriers'] ?? '')),
            'statement_date' => preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) === 1 ? $date : gmdate('Y-m-d'),
        ];
        update_option(self::OPTION_NAME, $next, false);
        add_settings_error('mgd_barrierefrei', 'saved', 'Die Einstellungen wurden gespeichert.', 'updated');
    }

    public function page(): void
    {
        if (!current_user_can(self::CAPABILITY)) {
            return;
        }
        $s = $this->all();
        settings_errors('mgd_barrierefrei');
        ?>
        <div class="wrap mgd-a11y-admin">
          <header class="mgd-a11y-admin__hero">
            <div><span class="mgd-a11y-admin__eyebrow">MGD Plugin Collection</span><h1>Barrierefreiheit</h1><p>Bedienhilfe, klare Einstellungen und ein anpassbarer Entwurf für deine Erklärung zur Barrierefreiheit.</p></div>
            <div class="mgd-a11y-admin__status"><span aria-hidden="true"></span><strong>Datensparsam</strong><small>Keine Analyse, keine externen Ressourcen</small></div>
          </header>
          <form method="post" class="mgd-a11y-form">
            <?php wp_nonce_field('mgd_barrierefrei_save'); ?>
            <input type="hidden" name="mgd_barrierefrei_save" value="1">
            <section class="mgd-a11y-card mgd-a11y-card--switch">
              <div><h2>Bedienhilfe im Shop</h2><p>Zeigt einen gut erreichbaren Schalter und ein Modal mit lokalen Darstellungsoptionen.</p></div>
              <label class="mgd-a11y-switch"><input type="checkbox" name="mgd_barrierefrei[enabled]" value="1" <?= checked((bool) $s['enabled'], true, false) ?>><span aria-hidden="true"></span><b>Aktiv</b></label>
            </section>
            <div class="mgd-a11y-layout">
              <section class="mgd-a11y-card"><h2>Darstellung</h2>
                <p class="description">Alle Werte wirken erst nach dem Speichern auf der Website.</p>
                <?php $this->text('button_label', 'Beschriftung des Schalters', $s['button_label']); ?>
                <?php $this->text('panel_title', 'Titel im Modal', $s['panel_title']); ?>
                <p><label for="mgd-a11y-position">Position</label><select id="mgd-a11y-position" name="mgd_barrierefrei[position]"><option value="left" <?= selected($s['position'], 'left', false) ?>>Unten links</option><option value="right" <?= selected($s['position'], 'right', false) ?>>Unten rechts</option></select></p>
                <p><label for="mgd-a11y-color">Akzentfarbe</label><input id="mgd-a11y-color" type="color" name="mgd_barrierefrei[accent_color]" value="<?= esc_attr($s['accent_color']) ?>"></p>
              </section>
              <aside class="mgd-a11y-preview" aria-label="Vorschau der Bedienhilfe"><span class="mgd-a11y-preview__label">Vorschau</span><div class="mgd-a11y-preview__page"><strong><?= esc_html(get_bloginfo('name')) ?></strong><span>Deine Inhalte bleiben im Mittelpunkt.</span><button type="button" style="--mgd-accent: <?= esc_attr($s['accent_color']) ?>"><span aria-hidden="true">♿</span><?= esc_html($s['button_label']) ?></button></div></aside>
            </div>
            <section class="mgd-a11y-card"><h2>Erklärung zur Barrierefreiheit</h2><p>Der Generator erstellt einen bearbeitbaren Entwurf. Prüfe ihn vor der Veröffentlichung rechtlich und fachlich für dein Angebot.</p>
              <div class="mgd-a11y-fields">
                <?php $this->text('organisation', 'Name des Unternehmens oder der Organisation', $s['organisation']); ?>
                <?php $this->url('website_url', 'Adresse der Website', $s['website_url']); ?>
                <?php $this->text('responsible_name', 'Verantwortliche Person', $s['responsible_name']); ?>
                <?php $this->text('responsible_role', 'Rolle oder Abteilung', $s['responsible_role']); ?>
                <?php $this->email('contact_email', 'E-Mail für Feedback', $s['contact_email']); ?>
                <?php $this->text('contact_phone', 'Telefon für Feedback', $s['contact_phone']); ?>
                <p><label for="mgd-a11y-status">Einschätzung des Stands</label><select id="mgd-a11y-status" name="mgd_barrierefrei[statement_status]"><option value="vollstaendig" <?= selected($s['statement_status'], 'vollstaendig', false) ?>>Vollständig barrierefrei</option><option value="teilweise" <?= selected($s['statement_status'], 'teilweise', false) ?>>Teilweise barrierefrei</option><option value="nicht" <?= selected($s['statement_status'], 'nicht', false) ?>>Noch nicht vollständig barrierefrei</option></select></p>
                <p><label for="mgd-a11y-date">Stand der Erklärung</label><input id="mgd-a11y-date" type="date" name="mgd_barrierefrei[statement_date]" value="<?= esc_attr($s['statement_date']) ?>"></p>
              </div>
              <p><label for="mgd-a11y-barriers">Bekannte Barrieren oder geplante Verbesserungen</label><textarea id="mgd-a11y-barriers" name="mgd_barrierefrei[known_barriers]" rows="5" placeholder="Zum Beispiel: Einzelne ältere PDF-Dateien werden schrittweise überarbeitet."><?= esc_textarea($s['known_barriers']) ?></textarea></p>
              <p><label for="mgd-a11y-page">Vorhandene Seite für den Entwurf</label><?php wp_dropdown_pages(['name' => 'mgd_barrierefrei[statement_page_id]', 'id' => 'mgd-a11y-page', 'show_option_none' => 'Neue Seite beim Erstellen anlegen', 'option_none_value' => '0', 'selected' => (int) $s['statement_page_id']]); ?></p>
            </section>
            <p class="submit"><button class="button button-primary button-hero" type="submit">Einstellungen speichern</button></p>
          </form>
          <form method="post" action="<?= esc_url(admin_url('admin-post.php')) ?>" class="mgd-a11y-create">
            <?php wp_nonce_field('mgd_barrierefrei_create_statement_page'); ?><input type="hidden" name="action" value="mgd_barrierefrei_create_statement_page"><button class="button button-secondary" type="submit">Erklärung als Seite erstellen oder aktualisieren</button>
          </form>
        </div>
        <?php
    }

    private function text(string $key, string $label, string $value): void { ?><p><label for="mgd-a11y-<?= esc_attr($key) ?>"><?= esc_html($label) ?></label><input id="mgd-a11y-<?= esc_attr($key) ?>" class="regular-text" type="text" name="mgd_barrierefrei[<?= esc_attr($key) ?>]" value="<?= esc_attr($value) ?>"></p><?php }
    private function email(string $key, string $label, string $value): void { ?><p><label for="mgd-a11y-<?= esc_attr($key) ?>"><?= esc_html($label) ?></label><input id="mgd-a11y-<?= esc_attr($key) ?>" type="email" name="mgd_barrierefrei[<?= esc_attr($key) ?>]" value="<?= esc_attr($value) ?>"></p><?php }
    private function url(string $key, string $label, string $value): void { ?><p><label for="mgd-a11y-<?= esc_attr($key) ?>"><?= esc_html($label) ?></label><input id="mgd-a11y-<?= esc_attr($key) ?>" type="url" name="mgd_barrierefrei[<?= esc_attr($key) ?>]" value="<?= esc_attr($value) ?>"></p><?php }
}
