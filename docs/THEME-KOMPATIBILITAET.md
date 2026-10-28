# Theme- und Page-Builder-Kompatibilität

Die MGD-Bedienhilfe wird über die WordPress-Hooks `wp_enqueue_scripts` und `wp_footer` eingebunden. Sie benötigt keine Theme-spezifischen Module und speichert Besucherpräferenzen nur lokal im Browser.

## Testmatrix (geplant, nicht als erfolgreich getestet markiert)

| Theme / Builder | Frontend | Editor | Mobil | Status |
| --- | --- | --- | --- | --- |
| Divi 4 / Divi 5 | Öffnen, Schließen, Kontrast, Schrift | Visual Builder | Hoch-/Querformat | Manuell prüfen |
| Elementor / Hello Elementor | Standard- und Popup-Seiten | Elementor Editor | Hoch-/Querformat | Manuell prüfen |
| Astra | Menüs und Templates | Block-Editor | Mobil | Manuell prüfen |
| GeneratePress | Menüs und Templates | Block-Editor | Mobil | Manuell prüfen |
| Kadence | Menüs und Templates | Block-Editor | Mobil | Manuell prüfen |
| Block-Themes (Twenty Twenty-*) | Site Editor Templates | Site Editor | Mobil | Manuell prüfen |
| OceanWP / Avada / Beaver Builder | Theme Header, Overlays | Builder UI | Mobil | Manuell prüfen |

Die Tabelle beschreibt Prüfziele, keine Zertifizierung oder bestätigte Kompatibilität.

## Manuelle Prüfschritte

1. Browser- und Plugin-Caches leeren und die Seite im privaten Fenster laden.
2. Schalter bedienen. Der Dialog muss sich per X, Escape und Klick auf den Hintergrund schließen lassen.
3. Nur mit der Tastatur testen: Tab, Shift+Tab, Enter, Leertaste; Fokus muss innerhalb des geöffneten Dialogs bleiben und nach Schließen zum Schalter zurückkehren.
4. Alle Optionen einzeln testen; prüfen, ob Navigation, Logo, Menüs, Formulare und Popups weiterhin benutzbar bleiben.
5. Einstellungen zurücksetzen und neu laden: Alle Anpassungen müssen entfernt sein.
6. Bei 320 px Breite, 200 % und 400 % Zoom sowie auf Mobilgeräten prüfen, ob der Dialog erreichbar und scrollbar ist.
7. Divi/Elementor-Editor öffnen und sicherstellen, dass die Plugin-Oberfläche dort die Bearbeitung nicht blockiert.
8. Browserkonsole auf JavaScript-Fehler prüfen; optional mit Tastatur und Screenreader nachtesten.

## Bekannte Grenzen

- Ein globaler Kontrast- oder Graustufenfilter ersetzt keine Prüfung echter Farbkontraste.
- Schriftgrößen, die das Theme in festen Pixelwerten definiert, reagieren unter Umständen nicht auf eine rem-basierte Skalierung.
- Die Implementierung setzt die üblichen WordPress-Hooks `wp_enqueue_scripts` und `wp_footer` voraus.
- Caching, Minifizierung, Consent-Manager und weitere Overlays können die Darstellung beeinflussen.
- Ein zugängliches Plugin macht die gesamte Website nicht automatisch WCAG-konform.

## Reproduzierbare Fehlermeldung

Bitte Theme/Builder-Version, WordPress- und PHP-Version, Browser, Gerät, betroffene URL, Schritte zur Reproduktion und eine Konsolenfehlermeldung dokumentieren. Zuerst auf einer Staging-Website testen.
