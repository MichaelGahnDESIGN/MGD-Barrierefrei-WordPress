# MGD Barrierefrei für WordPress

**Aktueller Entwicklungsstand: 1.6.1** – Updates über theme.michael-gahn.de, Seite „Info und Updates“ mit neuer Ansicht „Weitere Plugins“, Anmeldung der Installation (abschaltbar), Bedienhilfe mit DE/EN, Hell/Dunkel und (?)-Erklärungen; [Kompatibilitäts-Testmatrix](docs/THEME-KOMPATIBILITAET.md).

Kostenloses WordPress-Plugin für eine lokal arbeitende Bedienhilfe, eine anpassbare Darstellung und einen Generator für einen Entwurf der **Erklärung zur Barrierefreiheit**.

> Die Bedienhilfe kann einzelne Darstellungspräferenzen erleichtern. Sie ersetzt weder eine barrierefreie Gestaltung noch Tests mit echten Nutzerinnen und Nutzern. Der erzeugte Erklärungstext ist ein Entwurf und keine Rechtsberatung.

## Funktionen

- gut erreichbarer Schalter mit tastaturbedienbarem Modal und sichtbarem Fokus
- 10 Funktionen: Schriftgröße, hoher Kontrast, Graustufen, mehr Abstand, lesbare Schrift, Links hervorheben, Fokus sichtbar, Bewegung stoppen, großer Mauszeiger, Lese-Lineal – jede mit Symbol und (?)-Erklärung
- Besucher wählen DE/EN und Hell/Dunkel; die Standards stellst du im Backend ein
- läuft mit Divi 4/5, Elementor, Bricks, Beaver Builder, Oxygen, Breakdance, Block-Themes; im Builder-Editor automatisch ausgeblendet
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

Version, Updates, weitere Plugins und Anmeldung unter **MGD Barrierefrei → Info und Updates**. [Anleitung](docs/WORDPRESS-VERWALTUNG.md).

## Anmeldung der Installation (ab 1.5.0)

Meldet sich höchstens einmal am Tag bei theme.michael-gahn.de (Plugin, Version, Shopsystem, Domain, zufällige ID). Abschaltbar in den Einstellungen.

1. Die Meldung ist ab Werk eingeschaltet.
2. Gemeldet wird höchstens einmal am Tag, wenn jemand mit Admin-Rechten das WordPress-Backend öffnet. Nie für Besucher der Website.
3. Abschalten (ab 1.6.0): **MGD Barrierefrei → Info und Updates** öffnen, den Haken **Installation bei Michael Gahn DESIGN melden** entfernen und speichern. Dann wird der Eintrag auf der Plattform gelöscht.
4. Löschst du das Plugin, wird die Installation ebenfalls abgemeldet.
5. Das Plugin funktioniert immer voll, auch ohne Meldung oder wenn die Plattform nicht erreichbar ist.
- Technik (ab 1.6.0): gemeinsamer Plugin-Baukasten aus dem Pro-Repo (`php bin/build-plugin-kit.php … --platform=wordpress --namespace='Mgd\Barrierefrei\Kit' --dir=includes/Kit`), hier unter `mgd-barrierefrei-wordpress/includes/Kit`. Diesen Ordner nicht von Hand ändern, er wird neu erzeugt.

## Updates (ab 1.6.0)

1. Neue Versionen zeigt WordPress unter **Plugins** an, wie bei jedem anderen Plugin.
2. Die Angaben kommen von theme.michael-gahn.de, die ZIP-Datei aus dem GitHub-Release.
3. Vor der Installation werden Größe und Prüfsumme geprüft. Stimmt etwas nicht, wird nichts installiert.
4. Automatische Updates bleiben aus, bis du sie selbst einschaltest.
5. Den Stand siehst du auch unter **MGD Barrierefrei → Info und Updates**.
