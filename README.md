> **WordPress.org-Kandidat:** Dieser Branch verwendet native Verzeichnis-Updates. Paketbau, Prüfergebnisse und Wechselhinweise: [WordPress.org-Vorbereitung](docs/WORDPRESS-ORG.md). Die nachfolgende bisherige Dokumentation beschreibt auch die separate GitHub-Ausgabe.

## Verzeichnisfassung 1.0.1

Die verbliebenen statischen Hinweise wurden gezielt nachgearbeitet. [Änderungen und 46 Integrationstests](docs/wordpress-org/ERGEBNIS.md) sowie [offengelegte Einzel-Ausnahmen](docs/wordpress-org/GEPRUEFTE-AUSNAHMEN.md) dokumentieren den neuen Stand.

![Plugin-Banner](wordpress-org/assets/banner-1544x500.png)

Für das WordPress.org-Profil [michaelgahndesign](https://profiles.wordpress.org/michaelgahndesign/) vorbereitet. Vorgeschlagener Slug: `mgd-barrierefrei`; der endgültige Name wird bei der Aufnahme bestätigt.

- [Einreichungs-Readme](mgd-barrierefrei-wordpress/readme.txt) mit Funktionen, Installation, Datenschutz und Screenshots.
- [Prüfbericht](docs/wordpress-org/ERGEBNIS.md) mit Einordnung aller verbleibenden lokalen Plugin-Check-Hinweise.
- [Paketbau, Updatekanal und sicherer Wechsel](docs/WORDPRESS-ORG.md).

`python3 scripts/build-wordpress-org.py` baut das installierbare ZIP mit Prüfsumme. `php tests/wordpress-org-contract.php` prüft Metadaten, Version, Grafiken und den nativen Updatekanal. Verzeichnisgrafiken und echte Backend-Screenshots liegen getrennt unter `wordpress-org/assets`; sie gehören später in den obersten SVN-assets-Ordner.

**Noch nicht eingereicht oder von WordPress.org zugelassen.** Diese Fassung lädt keinen externen Plugin-Katalog und installiert keine GitHub-Updatepakete. Die unten folgende Projektdokumentation enthält zusätzlich die Geschichte und Bedienung der eigenständigen GitHub-Ausgabe auf main. Nicht beide Ausgaben gleichzeitig aktivieren.

---

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
- Empfehlungen weiterer MGD-Plugins nur im Backend über den datensparsamen Katalog von `theme.michael-gahn.de`

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

Das Plugin übermittelt keine Besucherpräferenzen. Frontend-Einstellungen liegen im Browser und können über „Einstellungen zurücksetzen“ entfernt werden. Die optionale Backend-Empfehlung ruft höchstens einmal täglich einen öffentlichen JSON-Katalog ab; bei Fehlern bleibt sie leer. Es sind keine Zugangsdaten, Tokens oder Fernsteuerungsfunktionen enthalten.

## Barrierefreiheit

Die Bedienoberfläche nutzt native Buttons, `aria-pressed`, einen Fokusfang im Modal, Escape zum Schließen und sichtbare Fokusmarkierungen. Teste jede Website trotzdem mit Tastatur, Bildschirmleser, Zoom und den eigenen Inhalten. Details: [Wiki](docs/wiki/Home.md).

## Lokaler Release-Build

```bash
./scripts/build-release.sh
```

Der Befehl erzeugt `release/mgd-barrierefrei-wordpress.zip`, eine SHA-256-Datei und prüft das Archiv. `release/` ist nicht versioniert.

## Lizenz

GPL-2.0-or-later. © Michael Gahn DESIGN.

## 1.0.1 – Plugin-Verwaltung

Separate Update-Prüfung, Plugin-Links und ergänzte lokale Details. [Anleitung](docs/WORDPRESS-VERWALTUNG.md).
