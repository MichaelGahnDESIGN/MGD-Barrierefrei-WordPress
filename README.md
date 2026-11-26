# MGD Barrierefrei für WordPress

**Aktuelle Version: 2.1.4** – Bedienhilfe mit DE/EN, Hell/Dunkel und (?)-Erklärungen. Verwaltung zusammen mit allen MGD-Plugins unter **MGD Tools**; [Kompatibilitäts-Testmatrix](docs/THEME-KOMPATIBILITAET.md).

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
- Updates über theme.michael-gahn.de, die Prüfsumme wird vor der Installation kontrolliert
- **MGD Tools:** eine gemeinsame Verwaltung für alle MGD-Plugins mit Übersicht und Updates, Lizenz und Weitere Plugins

## Installation

1. Lade `mgd-barrierefrei-wordpress.zip` aus dem passenden [GitHub-Release](https://github.com/MichaelGahnDESIGN/MGD-Barrierefrei-WordPress/releases) herunter.
2. Öffne in WordPress **Plugins → Installieren → Plugin hochladen**.
3. Aktiviere das Plugin und öffne im linken Menü **MGD Tools → Barrierefrei**.
4. Passe die Darstellung und die Angaben für die Erklärung an. Danach speicherst du und erzeugst den Seitenentwurf.
5. Prüfe Inhalt, Zuständigkeiten und Rechtslage, bevor du die Seite veröffentlichst.

## MGD Tools (neu in 2.1.3)

Im Menü **MGD Tools** siehst du alle MGD-Plugins auf einen Blick:

1. **Aktivieren oder Deaktivieren:** Bei jedem Plugin gibt es einen Schalter. Du musst nicht mehr in die Plugin-Liste wechseln.
2. **Lizenz:** Bei jedem Plugin steht, ob es Free oder Pro ist. Dieses Plugin ist kostenlos, es braucht keinen Schlüssel.
3. **Updates:** Gibt es eine neue Version, siehst du sie dort und unter **Plugins**.

## Updates

1. WordPress fragt die Datei `mgd-barrierefrei-wordpress.json` auf theme.michael-gahn.de ab.
2. Ist dort eine neuere Version eingetragen, zeigt WordPress das Update unter **Plugins** an.
3. Das ZIP kommt aus dem GitHub-Release. Vor der Installation werden Größe und Prüfsumme (SHA-256) geprüft.
4. Automatische Updates bleiben aus, bis du sie selbst einschaltest.

Mach vor einem Update eine Sicherung.

## Datenschutz und Sicherheit

Das Plugin übermittelt keine Besucherpräferenzen. Frontend-Einstellungen liegen im Browser und können über „Einstellungen zurücksetzen“ entfernt werden. Die Backend-Empfehlungen laden öffentliche Produktmetadaten von `theme.michael-gahn.de`; dargestellt werden sie durch die lokal mitgelieferte Katalogkomponente. Die lokale Ersatzliste und die eigenen Icons und Hintergrundbilder bleiben bei Ausfällen verfügbar. Der Katalog lädt keinen ausführbaren Code nach. Installation und Updates werden ausschließlich durch eine ausdrückliche Verwaltungsaktion gestartet. Es sind keine Zugangsdaten, Tokens oder Fernsteuerungsfunktionen enthalten.

## Barrierefreiheit

Die Bedienoberfläche nutzt native Buttons, `aria-pressed`, einen Fokusfang im Modal, Escape zum Schließen und sichtbare Fokusmarkierungen. Teste jede Website trotzdem mit Tastatur, Bildschirmleser, Zoom und den eigenen Inhalten. Details: [Wiki](docs/wiki/Home.md).

## Lokaler Release-Build

```bash
./scripts/build-release.sh
```

Der Befehl erzeugt `release/mgd-barrierefrei-wordpress-<Version>.zip`, eine SHA-256-Datei und prüft das fertige Archiv auf Pluginwurzel, Version, Katalogdateien und unerwünschte Entwicklungsdateien. `mgd-plugin.json` beschreibt die Pflichtbilder und Dokumentation; der Paketprüfer stammt aus dem MGD Plugin Builder. `release/` ist nicht versioniert.

Änderungen: [Änderungsprotokoll](CHANGELOG.md).
