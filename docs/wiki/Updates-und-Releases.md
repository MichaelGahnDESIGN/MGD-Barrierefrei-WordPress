# Updates und Releases

WordPress prüft in den üblichen Abständen die öffentliche GitHub-Release-API. Ein Release ist nur updatefähig, wenn es ein stabiles Semver-Tag und das Asset `mgd-barrierefrei-wordpress.zip` enthält.

Vor einem Update empfiehlt sich eine Sicherung von Dateien und Datenbank. Nach dem Update bitte die Bedienhilfe im Frontend, die Einstellungsseite und den Entwurf der Erklärung kontrollieren.

## Version 1.0.2

Der Release übernimmt die gemeinsame Plugin-Kollektion V4. Sie enthält sieben lokale Kartenmotive und Icons sowie Suche, Filter und eine Detailansicht. Dadurch erscheint die gleiche Übersicht auch dann, wenn nur MGD Barrierefrei installiert ist. Der zentrale Feed ergänzt lediglich öffentliche Metadaten; bei einer Störung bleibt die lokale Ersatzliste verfügbar.

Die installierbare GitHub-Datei heißt weiterhin `mgd-barrierefrei-wordpress.zip`. Sie enthält die Pluginwurzel `mgd-barrierefrei-wordpress/`, die Version 1.0.2 und alle lokalen Katalogdateien. Eine separat erzeugte WordPress.org-Ausgabe ist davon getrennt und wird durch diesen Build nicht ersetzt.

Vor einer Veröffentlichung sind der kanonische Bundle-Prüfmodus, `php tests/catalog-package.php`, `php tests/catalog-update-state.php`, die PHP-/JavaScript-Syntax und die Prüfung der fertig gebauten ZIP auszuführen. Das Release-ZIP und seine SHA-256-Datei liegen lokal unter `release/`.
