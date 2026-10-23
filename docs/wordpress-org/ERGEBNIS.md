# Plugin Check – nachgezogene Warnungen

Kandidat 1.0.1. Lokaler offizieller Plugin Check 2.1.0 auf WordPress 7.1.3/PHP 8.3 mit Runtime-Bootstrap: **0 Fehler, 0 statische Warnungen**. Der vollständige lokale Bericht steht in `plugin-check.txt`. Der zusätzliche wp-env-Lauf in GitHub Actions kann funktional notwendige Enqueue-Scope-Hinweise ausgeben; sein vollständiger Bericht gehört zur Paketübergabe.

## Tatsächliche Änderungen

Die aktivierte Bedienhilfe ist eine seitenweite Funktion und benötigt ihre kleine lokale CSS- und JS-Datei auf allen öffentlichen Seitentypen. Sie bleibt abschaltbar, ihr Skript wird mit defer geladen. Die beiden Enqueued-Scopes-Hinweise sind daher funktional begründet; ein Abschalten oder Verstecken dieser Laufzeitprüfung wäre keine sinnvolle Verbesserung.

## Umgang mit Prüfregeln

Keine Prüfgruppe und kein Laufzeitcheck wird ausgeschaltet. Technisch notwendige Direktabfragen, rein lesende URL-Auswahl, signierte öffentliche Tokens und die feste Cache-Konstante sind nach Einzelprüfung mit dem jeweils engsten PHPCS-Code und einer Begründung an der konkreten Stelle gekennzeichnet. Diese statischen Einzel-Ausnahmen sind **keine zusätzlichen Sicherheitsprüfungen** und werden ausdrücklich offengelegt. Verzeichnis: `GEPRUEFTE-AUSNAHMEN.md`. Keine Zusage einer WordPress.org-Zulassung.

## Nachweise

41 Integrationstests bestanden: ursprüngliche 22 Schutzgrenzen-/Datenprüfungen plus 19 Cache-, Invalidierungs-, Empfänger- und AI-Seiten-ID-Prüfungen. Browser: keine Giveaway-Ressourcen ohne Formular, normale und nach wp_head gerenderte Shortcodes, Modal/Escape, 390px sowie echter CSV-Multipart-Import. Ungültige Upload-Nonce und falsche Endung werden abgewiesen. PHP-Syntax aller 86 Laufzeitdateien unter PHP 8.1 und der 15 MCP-Dateien zusätzlich unter PHP 7.4 geprüft. Keine produktiven Daten, keine Live-Einreichung.
