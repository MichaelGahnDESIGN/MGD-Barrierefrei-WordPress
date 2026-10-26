# Playbook · Gemeinsamer Plugin-Katalog, Release 1.0.2

## Ziel und Grenzen

Das bereits lokal integrierte V4-Katalogpaket als installierbare GitHub-Ausgabe vorbereiten: sieben gemeinsame Karten mit lokalen Icons und Hintergrundmotiven, konsistente Versionsangaben und geprüfte ZIP. Keine Änderung an Bedienhilfe oder gespeicherten Einstellungen. Keine WordPress.org-Ausgaben überschreiben. Commit, Zusammenführung, Push und Release erfolgen getrennt nach Prüfung durch den Hauptagenten.

## Grundlinie

- 26.10.2026: Arbeitskopie `main`, `47f5a0b`, vor Beginn sauber; Pluginversion 1.0.1.
- GitHub `main`: `caf6e279e024cb1ef340be47b6f8976cc00c0bbf`. Lokale und entfernte Linie sind je einen Commit vor dem gemeinsamen `bb7c204`. Remote ergänzt ausschließlich Dependabot und Sicherheits-CI; diese Änderungen müssen bei der späteren Zusammenführung erhalten bleiben.
- Letzter öffentlicher Release: v1.0.1 mit `mgd-barrierefrei-wordpress.zip` und SHA-256-Datei. Der neue V4-Katalog ist dort noch nicht enthalten.
- Rückfall: bisheriger Release und Git-Grundlinie. Keine Produktivdaten oder bestehenden Container betroffen.
- Bestehende Doku: `README.md`, `CHANGELOG.md`, `docs/wiki/Updates-und-Releases.md`; keine zweite Aufgabenliste.

## Schritte

| ID | Änderung | Voraussetzung | Erfolgskriterium / Prüfung | Rückfall | Status | Beleg |
| --- | --- | --- | --- | --- | --- | --- |
| R1 | Versionsangaben, Readme und Wiki | Grundlinie gelesen | Kopf, Konstante, Verwaltungsmetadaten, Testkonfiguration und Stable-Tag sind 1.0.2 | Git-Grundlinie | geprüft | PHP-Paketvertrag und fertiges ZIP |
| R2 | Kanonisches Bundle und Paketprüfung | R1 | Builder-Prüfmodus meldet Gleichheit; PHP-/JS-Syntax und Katalogfälle bestanden | keine Abhängigkeiten ändern | geprüft | „PASS: gemeinsames Katalog-Bundle ist aktuell.“; Gegenprobe unten |
| R3 | Release-ZIP | R1, R2 | genau eine Pluginwurzel, V4-Dateien/7 Icons/7 Motive, Version 1.0.2 und SHA-256 belegt; keine Entwicklungs-/Secretdateien | nur eigener Build austauschbar | geprüft | `release/mgd-barrierefrei-wordpress.zip`; Hash unten |
| R4 | Übergabe | R1–R3 | Dateiliste, Tests, ZIP-Hash und divergierte Git-Linien gemeldet | nichts veröffentlichen | geprüft | Bericht an Hauptagenten, kein Commit/Push/Release |

## Planänderung und Prüfnachweise

26.10.2026: Der vorgeschriebene Befehl war zunächst im installierten Builderklon und im öffentlichen GitHub-main nicht vorhanden. Der Hauptagent fand anschließend die aktuelle kanonische Arbeitskopie. Dort wurde `node scripts/sync-wordpress-plugin-catalog.mjs --target <Pluginwurzel> --check` erfolgreich ausgeführt. Eine Synchronisation oder Änderung des Bundles war nicht nötig. Der zusätzliche Dateivergleich mit anderen Verbrauchern bleibt als unabhängige Gegenprobe erhalten.

- Alle 21 V4-Bundledateien sind bytegleich mit der aktuellen KI-Kennzeichnung für WordPress. Beim Maintenance-Plugin weichen ausschließlich zwei gleichwertige Zeichenkettenprüfungen ab (`str_contains`/`strpos` und `str_starts_with`/`strpos`). Das Bundle wurde nicht verändert.
- PHP-Syntax: zehn Dateien bestanden. JavaScript-Syntax: Frontend, Admin und Katalog bestanden.
- `php tests/catalog-package.php`: Version, sieben bekannte Plugins und vollständige lokale Kartenmotive bestanden.
- `php tests/catalog-update-state.php`: sieben Fälle bestanden, einschließlich gleicher/älterer Versionen und fehlender Berechtigung.
- Builder-Paketprüfer `scripts/check_plugin_ready.py` auf fertiger ZIP: bestanden. Das Skript wurde unverändert aus dem installierten Builder-Skill übernommen und in den bestehenden Build eingebunden.
- `tests/release-package.py`: Pluginwurzel, Versionsdreiklang, Stable-Tag, vollständiges V4-Bundle und Paketgrenzen bestanden. Drei gezielt beschädigte Testarchive (Pfadtraversal, abweichende Version, fehlendes Kartenbild) wurden jeweils abgewiesen.
- Gitleaks auf der Laufzeit: keine Befunde. Das ist eine Prüfung auf bekannte Geheimnismuster, keine Sicherheitszertifizierung.
- ZIP-SHA-256: `a69341fe45a4d8b36fed9cb9486ea8382146b0e3f93fa59f6fce2316f94a373c`.
- Die Prüfsummendatei verwendet nur den Paketdateinamen und enthält keinen lokalen Arbeitsplatzpfad.
- `zip -X` lässt zusätzliche lokale Datei-Metadaten weg. Zwei direkt aufeinanderfolgende Builds waren bytegleich; frühere Zwischenbuilds ohne diesen Schalter sind durch den oben genannten Hash ersetzt.

## Abschluss

Release 1.0.2 ist lokal vorbereitet und gezielt geprüft. Die Git-Linien müssen vor dem Push zusammengeführt werden. Lokaler Release-Build ist kein veröffentlichter GitHub-Release und kein Live-Deployment. Eine Installation dieser neuen ZIP übernimmt die separate isolierte WordPress-Abnahme des Hauptagenten.
