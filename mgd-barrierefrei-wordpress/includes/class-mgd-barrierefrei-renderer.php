<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/** Lokale Bedienhilfe im Frontend. Einstellungen bleiben im Browser und werden nicht übertragen. */
final class MGD_Barrierefrei_Renderer
{
    public function __construct(private MGD_Barrierefrei_Settings $settings) {}

    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'assets']);
        add_action('wp_footer', [$this, 'markup']);
    }

    public function assets(): void
    {
        if (is_admin() || !$this->settings->all()['enabled']) {
            return;
        }
        wp_enqueue_style('mgd-barrierefrei', MGD_BARRIEREFREI_URL . 'assets/css/frontend.css', [], MGD_BARRIEREFREI_VERSION);
        wp_enqueue_script('mgd-barrierefrei', MGD_BARRIEREFREI_URL . 'assets/js/frontend.js', [], MGD_BARRIEREFREI_VERSION, true);
    }

    public function markup(): void
    {
        $s = $this->settings->all();
        if (!$s['enabled'] || is_admin()) {
            return;
        }
        $id = 'mgd-a11y-panel';
        ?>
        <div class="mgd-a11y mgd-a11y--<?= esc_attr($s['position']) ?>" style="--mgd-a11y-accent: <?= esc_attr($s['accent_color']) ?>">
          <button class="mgd-a11y__trigger" type="button" aria-expanded="false" aria-controls="<?= esc_attr($id) ?>"><span aria-hidden="true">♿</span><span><?= esc_html($s['button_label']) ?></span></button>
          <div class="mgd-a11y__backdrop" hidden></div>
          <section id="<?= esc_attr($id) ?>" class="mgd-a11y__panel" role="dialog" aria-modal="true" aria-labelledby="mgd-a11y-title" aria-describedby="mgd-a11y-help" hidden tabindex="-1">
            <header><h2 id="mgd-a11y-title"><?= esc_html($s['panel_title']) ?></h2><button type="button" class="mgd-a11y__close" aria-label="Einstellungen schließen">×</button></header>
            <p id="mgd-a11y-help">Die Auswahl wird nur auf diesem Gerät gespeichert und kann jederzeit zurückgesetzt werden.</p>
            <div class="mgd-a11y__controls">
              <button type="button" data-mgd-a11y="contrast" aria-pressed="false">Kontrast</button>
              <button type="button" data-mgd-a11y="grayscale" aria-pressed="false">Graustufen</button>
              <button type="button" data-mgd-a11y="focus" aria-pressed="false">Fokus</button>
              <button type="button" data-mgd-a11y="font-increase">Schrift +</button>
              <button type="button" data-mgd-a11y="font-decrease">Schrift −</button>
              <button type="button" data-mgd-a11y="readable" aria-pressed="false">Lesemodus</button>
              <button type="button" data-mgd-a11y="links" aria-pressed="false">Links hervorheben</button>
              <button type="button" data-mgd-a11y="motion" aria-pressed="false">Bewegung stoppen</button>
            </div>
            <button class="mgd-a11y__reset" type="button" data-mgd-a11y="reset">Einstellungen zurücksetzen</button>
            <footer><a href="https://michael-gahn.de" target="_blank" rel="noopener noreferrer">MGD Barrierefrei von Michael Gahn DESIGN</a></footer>
          </section>
        </div>
        <?php
    }
}
