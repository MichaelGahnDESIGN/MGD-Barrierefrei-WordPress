<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/** Erzeugt einen transparenten, ausdrücklich zu prüfenden Seitenentwurf. */
final class MGD_Barrierefrei_Statement
{
    public function __construct(private MGD_Barrierefrei_Settings $settings) {}

    public function create_or_update_page(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Du hast keine Berechtigung für diese Aktion.', 'mgd-barrierefrei'));
        }
        check_admin_referer('mgd_barrierefrei_create_statement_page');
        $s = $this->settings->all();
        $post = ['post_title' => 'Erklärung zur Barrierefreiheit', 'post_content' => $this->content($s), 'post_status' => 'draft', 'post_type' => 'page'];
        $id = (int) $s['statement_page_id'];
        if ($id > 0 && get_post_type($id) === 'page') {
            $post['ID'] = $id;
            wp_update_post(wp_slash($post));
        } else {
            $id = (int) wp_insert_post(wp_slash($post));
            if ($id > 0) {
                $s['statement_page_id'] = $id;
                update_option(MGD_Barrierefrei_Settings::OPTION_NAME, $s, false);
            }
        }
        wp_safe_redirect(add_query_arg(['page' => 'mgd-barrierefrei', 'statement' => $id > 0 ? 'created' : 'failed'], admin_url('admin.php')));
        exit;
    }

    /** @param array<string,mixed> $s */
    public function content(array $s): string
    {
        $organisation = esc_html((string) $s['organisation']);
        $website = esc_url((string) $s['website_url']);
        $date = esc_html(wp_date(get_option('date_format'), strtotime((string) $s['statement_date']) ?: time()));
        $status = match ($s['statement_status']) {
            'vollstaendig' => 'Die Website ist nach eigener Einschätzung vollständig barrierefrei.',
            'nicht' => 'Die Website ist nach eigener Einschätzung noch nicht vollständig barrierefrei.',
            default => 'Die Website ist nach eigener Einschätzung teilweise barrierefrei.',
        };
        $contact = array_filter([trim((string) $s['responsible_name']), trim((string) $s['responsible_role']), trim((string) $s['contact_email']), trim((string) $s['contact_phone'])]);
        $barriers = trim((string) $s['known_barriers']);
        // Kein Absatz im Absatz: Gutenberg erwartet innerhalb des Blocks nur den Textinhalt.
        $barrierText = $barriers === ''
            ? 'Uns sind derzeit keine konkreten Barrieren bekannt. Diese Aussage bitte vor Veröffentlichung fachlich prüfen und bei Änderungen aktualisieren.'
            : nl2br(esc_html($barriers));

        return "<!-- wp:heading --><h2>Erklärung zur Barrierefreiheit</h2><!-- /wp:heading -->\n"
            . "<!-- wp:paragraph --><p>Diese Erklärung zur Barrierefreiheit gilt für <a href=\"{$website}\">{$organisation}</a>. Stand: {$date}.</p><!-- /wp:paragraph -->\n"
            . "<!-- wp:heading {\"level\":3} --><h3>Stand der Vereinbarkeit mit den Anforderungen</h3><!-- /wp:heading -->\n"
            . "<!-- wp:paragraph --><p>{$status}</p><!-- /wp:paragraph -->\n"
            . "<!-- wp:paragraph --><p>Wir arbeiten daran, die Website für alle Menschen zugänglich und verständlich zu gestalten. Dabei orientieren wir uns an den für das Angebot anwendbaren gesetzlichen Anforderungen sowie an den WCAG 2.2.</p><!-- /wp:paragraph -->\n"
            . "<!-- wp:heading {\"level\":3} --><h3>Nicht barrierefreie Inhalte</h3><!-- /wp:heading -->\n<!-- wp:paragraph --><p>{$barrierText}</p><!-- /wp:paragraph -->\n"
            . "<!-- wp:heading {\"level\":3} --><h3>Feedback und Kontakt</h3><!-- /wp:heading -->\n"
            . "<!-- wp:paragraph --><p>Wenn dir Barrieren auffallen oder du Hilfe bei der Nutzung benötigst, melde dich bitte bei uns: " . esc_html(implode(' · ', $contact)) . ".</p><!-- /wp:paragraph -->\n"
            . "<!-- wp:paragraph --><p><strong>Hinweis:</strong> Dieser Text ist ein technisch erzeugter Entwurf und keine Rechtsberatung. Angaben, Zuständigkeiten und gesetzliche Anforderungen müssen vor der Veröffentlichung geprüft und fortlaufend aktualisiert werden.</p><!-- /wp:paragraph -->";
    }
}
