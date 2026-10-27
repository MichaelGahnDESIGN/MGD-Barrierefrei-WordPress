# MGD Barrierefrei für WordPress

Kostenloses WordPress-Plugin für eine lokal arbeitende Bedienhilfe, eine anpassbare Darstellung und einen Generator für einen Entwurf der **Erklärung zur Barrierefreiheit**.

> Die Bedienhilfe kann einzelne Darstellungspräferenzen erleichtern. Sie ersetzt weder eine barrierefreie Gestaltung noch Tests mit echten Nutzerinnen und Nutzern. Der erzeugte Erklärungstext ist ein Entwurf und keine Rechtsberatung.

## Funktionen

- gut erreichbarer Schalter mit tastaturbedienbarem Modal und sichtbarem Fokus
- Kontrast, Graustufen, größere oder kleinere Schrift, Lesemodus, Link-Hervorhebung und „Bewegung stoppen“
- Präferenzen bleiben ausschließlich im `localStorage` des verwendeten Browsers
- keine Analyse, keine Cookies, keine externen Schriften oder Drittanbieter-Skripte
- modernes WordPress-Dashboard für Position, Akzentfarbe, Texte und Kontaktangaben
- Generator erstellt oder aktualisiert eine bearbeitbare WordPress-Seite als Entwurf
- Update-Prüfung über veröffentlichte GitHub-Releases, ohne GitHub-Token im Plugin
- gemeinsame Übersicht weiterer MGD-Plugins nur im Backend, mit sieben Karten, passenden lokalen Bildern, Suche und Filtern

## Installation

1. Lade `mgd-barrierefrei-wordpress.zip` aus dem passenden [GitHub-Release](https://github.com/MichaelGahnDESIGN/MGD-Barrierefrei-WordPress/releases) herunter.
2. Öffne in WordPress **Plugins → Installieren → Plugin hochladen**.
3. Aktiviere das Plugin und öffne **MGD Barrierefrei** im linken Menü.
4. Passe die Darstellung und die Angaben für die Erklärung an. Danach speicherst du und erzeugst den Seitenentwurf.
5. Prüfe Inhalt, Zuständigkeiten und Rechtslage, bevor du die Seite veröffentlichst.

## Update über GitHub

Das Plugin liest ausschließlich die öffentliche Release-Metadaten-API des festen Repositorys. Ein Update erscheint nur, wenn:

- das Release stabil ist und ein Tag wie `v1.2.3` verwendet,
- das Release das Asset `mgd-barrierefrei-wordpress.zip` enthält,
- dieses Asset von GitHub bereitgestellt wird,
- seine Version höher ist als die installierte Version.

WordPress installiert das ZIP anschließend über seinen üblichen Plugin-Update-Prozess. Das Paket enthält immer den Ordner `mgd-barrierefrei-wordpress/` als ZIP-Wurzel.

## Datenschutz und Sicherheit

Das Plugin übermittelt keine Besucherpräferenzen. Frontend-Einstellungen liegen im Browser und können über „Einstellungen zurücksetzen“ entfernt werden. Die Backend-Empfehlungen laden öffentliche Produktmetadaten von `theme.michael-gahn.de`; dargestellt werden sie durch die lokal mitgelieferte Katalogkomponente. Die lokale Ersatzliste und die eigenen Icons und Hintergrundbilder bleiben bei Ausfällen verfügbar. Der Katalog lädt keinen ausführbaren Code nach. Installation und Updates werden ausschließlich durch eine ausdrückliche Verwaltungsaktion gestartet. Es sind keine Zugangsdaten, Tokens oder Fernsteuerungsfunktionen enthalten.

## Barrierefreiheit

Die Bedienoberfläche nutzt native Buttons, `aria-pressed`, einen Fokusfang im Modal, Escape zum Schließen und sichtbare Fokusmarkierungen. Teste jede Website trotzdem mit Tastatur, Bildschirmleser, Zoom und den eigenen Inhalten. Details: [Wiki](docs/wiki/Home.md).

## Lokaler Release-Build

```bash
./scripts/build-release.sh
```

Der Befehl erzeugt `release/mgd-barrierefrei-wordpress.zip`, eine SHA-256-Datei und prüft das fertige Archiv auf Pluginwurzel, Version, Katalogdateien und unerwünschte Entwicklungsdateien. `mgd-plugin.json` beschreibt die Pflichtbilder und Dokumentation; der Paketprüfer stammt aus dem MGD Plugin Builder. `release/` ist nicht versioniert.

## 1.0.3 – Icons und Hintergründe aus dem Feed

Die Karten unter **Weitere Plugins** bekommen Icons und Hintergründe aus theme.michael-gahn.de. Der Server holt sie einmal und speichert sie lokal; der Browser lädt nichts extern. Ohne Bild bleibt das mitgelieferte Motiv. Versionen erscheinen ohne führendes „v". [Änderungsprotokoll](CHANGELOG.md).

## 1.0.2 – Gemeinsame Plugin-Kollektion

Der Bereich **Weitere Plugins** nutzt dieselbe lokale Katalogkomponente wie die übrigen aktuellen MGD-Plugins. Sieben Karten bieten passende Icons und Hintergrundbilder, Suche, Filter, Installationsstatus und eine Detailansicht. Die Zentrale liefert öffentliche Metadaten; Darstellung und Ersatzbilder werden mit dem Plugin ausgeliefert. [Release-Anleitung](docs/wiki/Updates-und-Releases.md) · [Änderungsprotokoll](CHANGELOG.md).

## Lizenz

GPL-2.0-or-later. © Michael Gahn DESIGN.

## 1.0.1 – Plugin-Verwaltung

Separate Update-Prüfung, Plugin-Links und ergänzte lokale Details. [Anleitung](docs/WORDPRESS-VERWALTUNG.md).
