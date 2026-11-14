# Changelog

Alle wichtigen Änderungen werden in dieser Datei dokumentiert.

## 1.4.0 – 2026-11-14

- Gemeinsame Versionsnummer **1.4.0** für alle Produkte von Michael Gahn DESIGN. So sieht man auf einen Blick, welche Fassungen zusammengehören.
- Keine Änderung an den Funktionen.

## 1.1.0 – 2026-11-11

- **Neu: Bedienhilfe komplett überarbeitet.** Neues Symbol (Person im Kreis) statt Rollstuhl. Der Text daneben erscheint nur, wenn die Maus darüber fährt oder die Tastatur den Button erreicht.
- **Neu:** Besucher wählen selbst **DE oder EN** und **Hell oder Dunkel**. Was beim ersten Besuch gilt, stellst du im Backend ein (Standard-Sprache, Standard-Design). Dazu: englische Beschriftung und „Abstand nach oben“, falls der Button einen Chat-Button verdeckt.
- **Neu:** Jede Funktion hat ein Symbol und ein **(?)**, das kurz erklärt, was sie tut.
- **Neu:** 10 Funktionen, die wirklich wirken: Schriftgröße (90–150 %, auch bei festen Pixel-Schriften), hoher Kontrast, Graustufen, mehr Abstand, lesbare Schrift, Links hervorheben, Fokus sichtbar, Bewegung stoppen (auch Videos), großer Mauszeiger, Lese-Lineal.
- Die Bedienhilfe liegt in einem abgeschirmten Bereich (Shadow DOM). Theme- oder Builder-CSS kann sie nicht mehr verändern.
- Gespeichert wird weiter nur im Browser des Besuchers (localStorage). Frühere Einstellungen der Besucher werden einmalig zurückgesetzt.
- WordPress: Im Editor von Divi 4/5, Elementor, Bricks, Beaver Builder, Oxygen, Breakdance, WPBakery und Brizy wird die Bedienhilfe automatisch ausgeblendet. Cache-Plugins (WP Rocket, LiteSpeed, Autoptimize, Perfmatters, SiteGround) verzögern das Skript nicht mehr.
- Getestet lokal mit Divi 5, Elementor (auch Canvas-Vorlage) und dem Block-Theme Twenty Twenty-Five.

## 1.0.4 – 2026-10-28

- Dialog lässt sich verlässlich über Schließen, Escape und Overlay ausblenden, auch bei konkurrierendem Theme-CSS.
- Fokusführung und lokale Bedienzustände robuster gestaltet; Dialog auf kleinen Bildschirmen scrollbar.
- Live-Vorschau im Backend repariert; aktive Theme- und Builder-Erkennung ergänzt.
- Theme-Testmatrix für Divi, Elementor und weitere WordPress-Themes hinzugefügt (keine Testzertifizierung).

## 1.0.3 – 2026-10-27

- Icons und Hintergründe der Karten unter „Weitere Plugins" kommen jetzt aus theme.michael-gahn.de. Sie werden vom Server einmal geholt und lokal gespeichert, der Browser lädt nichts extern. Ohne Bild bleibt das mitgelieferte Motiv.
- Versionen werden ohne führendes „v" angezeigt.

## 1.0.2 – 2026-10-26

- Die gemeinsame Plugin-Kollektion zeigt sieben WordPress-Plugins mit lokalen Icons und passenden Hintergrundbildern, Suche, Filtern und Detailansicht.
- Der Katalog bleibt auch dann vollständig, wenn im zentralen Feed keine Bilder gepflegt sind oder die Quelle vorübergehend nicht erreichbar ist.
- Einheitliche Katalogklasse V4 verhindert doppelte Empfehlungsseiten beim gemeinsamen Betrieb mehrerer aktueller MGD-Plugins.
- Release-Paket und Versionsangaben werden vor der Veröffentlichung gemeinsam geprüft.

## 1.0.1 – 2026-10-23

- Separate manuelle Update-Prüfung und Hersteller-/Dokumentationslinks in der Pluginliste.
- Ergänzte lokale Plugin-Details und Verwaltungsanleitung.

## 1.0.0 – 2026-10-23

- Erste öffentliche Version mit lokalem Bedienpanel, anpassbarem Design und Tastaturbedienung.
- Erzeugt eine als Entwurf gespeicherte Erklärung zur Barrierefreiheit aus den hinterlegten Angaben.
- Enthält einen sicheren GitHub-Release-Check für WordPress-Updates.
- Liefert deutsche Dokumentation, Sicherheitsrichtlinie und Wiki-Quellen mit.
