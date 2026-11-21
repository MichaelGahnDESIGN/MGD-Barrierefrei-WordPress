# Sicherheitsrichtlinie

## Melden einer Schwachstelle

Bitte veröffentliche Sicherheitslücken nicht als öffentliches GitHub-Issue. Melde sie vertraulich über <https://michael-gahn.de> mit Version, reproduzierbaren Schritten und möglicher Auswirkung.

## Sicherheitsgrenzen

- Das Plugin speichert keine Zugangsdaten oder Tokens.
- Einstellungsänderungen erfordern `manage_options` und einen WordPress-Nonce.
- Der erzeugte Seitentext wird über die WordPress-API als Entwurf angelegt.
- Das Frontend lädt keine externen Ressourcen.
- Updates (ab 1.6.0) kommen über die Update-Datei auf theme.michael-gahn.de. Die ZIP-Adresse muss ein GitHub-Release von MichaelGahnDESIGN sein. Größe und SHA-256 werden vor der Installation geprüft. Automatische Updates bleiben aus.
