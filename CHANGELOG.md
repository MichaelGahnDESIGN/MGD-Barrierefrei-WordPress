# Changelog

## [2.1.3] - 2026-11-26

- MGD Tools: Plugins an- und abschalten, Lizenz je Plugin.

## [2.1.1] - 2026-11-25

- Gemeinsame Verwaltung unter MGD Tools, einheitliche Darstellung, Icons.

- **MGD Tools:** Die Einstellungen stehen jetzt unter dem gemeinsamen Menüpunkt **MGD Tools → Barrierefrei**. Dort liegen auch Übersicht und Updates, Lizenz und Weitere Plugins. Das eigene Menü „MGD Barrierefrei“ gibt es nicht mehr. Die Seiten-Kennung bleibt, alte Links gehen weiter.
- Icons und genormter Plugin-Kopf für die Plugin-Liste.
- Das Farbfeld nutzt den gemeinsamen MGD Farbwähler.
- Der alte Update-Code und die alte Plugin-Liste sind gelöscht.

## 1.6.1 – 2026-11-21

- **Neue Ansicht „Weitere Plugins“** auf der Seite „Info und Updates“: im Design der früheren „MGD Plugin-Kollektion“, mit Bildern, Kategorien, Suche, Filtern und einem Fenster „Details“.
- **Installieren mit einem Klick:** Kostenlose Plugins kannst du direkt installieren. Vorher werden Herkunft (GitHub), Größe und Prüfsumme geprüft. Das Plugin wird nie automatisch aktiviert.
- Bilder lädt deine Website einmal selbst von theme.michael-gahn.de. Der Browser lädt keine Bilder von fremden Seiten.
- Die alte Seite „MGD Plugin-Kollektion“ ist ganz entfernt (Dateien und Code).
- Technik: Baukasten neu erzeugt (Pro-Repo ab 1187f5e).

## 1.6.0 – 2026-11-21

Diese Version ist eine Brückenversion. Deine Einstellungen bleiben genau so, wie sie sind.

- **Updates:** WordPress zeigt neue Versionen jetzt über theme.michael-gahn.de an. Vor der Installation wird geprüft, ob die Datei vollständig und unverändert ist (Größe und Prüfsumme). Der alte Update-Weg über GitHub ist abgeschaltet.
- **Automatische Updates** bleiben aus, bis du sie selbst unter „Plugins“ einschaltest.
- **Neue Seite „Info und Updates“:** Unter „MGD Barrierefrei“ findest du jetzt eine Seite mit Version, Update-Stand, weiteren Plugins und dem Schalter „Installation melden“. Die weiteren Plugins erscheinen als einfache Karten. Antwortet der Server nicht, siehst du eine mitgelieferte Liste.
- **Installation melden:** Der Schalter ist von der Einstellungsseite auf „Info und Updates“ umgezogen. Deine bisherige Wahl (an oder aus) bleibt.
- **Löschen:** Löschst du das Plugin, wird die Installation bei theme.michael-gahn.de abgemeldet. Deine Einstellungen zur Bedienhilfe bleiben in der Datenbank.
- Technik: gemeinsamer Plugin-Baukasten aus dem Pro-Repo unter `includes/Kit`. Der alte Install-Client unter `includes/Install` ist raus.

## 1.5.1 – 2026-11-18

- Die Anmeldung nutzt jetzt den eigenen Produktnamen **mgd-barrierefrei-wordpress**. So zählt theme.michael-gahn.de WordPress-Installationen getrennt von JTL und Shopware. Wer 1.5.0 hatte, wird einmal neu angemeldet.
- Das Release enthält zusätzlich `mgd-barrierefrei-wordpress-1.5.1.zip` (gleicher Inhalt, Version im Namen) für die Update-Datei auf theme.michael-gahn.de. `mgd-barrierefrei-wordpress.zip` bleibt, damit bestehende Installationen Updates weiter finden.

## 1.5.0 – 2026-11-18

- **Neu: Anmeldung der Installation (Free-Lizenz).** Das Plugin meldet sich einmal bei theme.michael-gahn.de an und danach höchstens einmal am Tag. Gesendet werden nur: Plugin-Name, Version, Shopsystem, die Domain der Website und eine zufällige Installations-ID. Keine Besucher-, Kunden- oder Bestelldaten.
- Gemeldet wird nur im Admin, nie für Besucher. Nach dem Aktivieren erscheint einmal ein Hinweis mit Link zum Schalter.
- Ab Werk eingeschaltet. Abschalten unten auf der Seite **MGD Barrierefrei**. Dann wird der Eintrag auf der Plattform gelöscht. Das Plugin funktioniert genauso weiter.

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
