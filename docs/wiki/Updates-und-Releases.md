# Updates und Releases

## Ab Version 1.6.0

1. WordPress fragt die Update-Datei `mgd-barrierefrei-wordpress.json` auf theme.michael-gahn.de ab.
2. Ist dort eine neuere Version eingetragen, zeigt WordPress das Update unter **Plugins** an.
3. Die ZIP-Datei kommt aus dem GitHub-Release. Vor der Installation werden Größe und Prüfsumme (SHA-256) geprüft.
4. Automatische Updates bleiben aus, bis du sie selbst einschaltest.

## Bis Version 1.5.1

WordPress prüfte die öffentliche GitHub-Release-API. Ein Release ist dafür nur updatefähig, wenn es ein stabiles Semver-Tag und das Asset `mgd-barrierefrei-wordpress.zip` enthält. Darum enthält jedes Release diese Datei weiterhin, damit alte Installationen die Brückenversion 1.6.0 finden.

Vor einem Update empfiehlt sich eine Sicherung von Dateien und Datenbank. Nach dem Update bitte die Bedienhilfe im Frontend, die Einstellungsseite und den Entwurf der Erklärung kontrollieren.

## Version 1.0.3

Die Karten unter „Weitere Plugins" zeigen Icons und Hintergründe aus theme.michael-gahn.de. Der Server holt jedes Bild einmal und speichert es lokal, der Browser lädt nichts von extern. Fehlt ein Bild, bleibt das mitgelieferte Motiv. Versionen werden ohne führendes „v" angezeigt. Die Datei heißt weiterhin `mgd-barrierefrei-wordpress.zip` und enthält die Version 1.0.3.

## Version 1.0.2

Der Release übernimmt die gemeinsame Plugin-Kollektion V4. Sie enthält sieben lokale Kartenmotive und Icons sowie Suche, Filter und eine Detailansicht. Dadurch erscheint die gleiche Übersicht auch dann, wenn nur MGD Barrierefrei installiert ist. Der zentrale Feed ergänzt lediglich öffentliche Metadaten; bei einer Störung bleibt die lokale Ersatzliste verfügbar.

Die installierbare GitHub-Datei heißt weiterhin `mgd-barrierefrei-wordpress.zip`. Sie enthält die Pluginwurzel `mgd-barrierefrei-wordpress/`, die Version 1.0.2 und alle lokalen Katalogdateien. Eine separat erzeugte WordPress.org-Ausgabe ist davon getrennt und wird durch diesen Build nicht ersetzt.

Vor einer Veröffentlichung sind der kanonische Bundle-Prüfmodus, `php tests/catalog-package.php`, `php tests/catalog-update-state.php`, die PHP-/JavaScript-Syntax und die Prüfung der fertig gebauten ZIP auszuführen. Das Release-ZIP und seine SHA-256-Datei liegen lokal unter `release/`.
