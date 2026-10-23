# Sicherheitsrichtlinie

## Melden einer Schwachstelle

Bitte veröffentliche Sicherheitslücken nicht als öffentliches GitHub-Issue. Melde sie vertraulich über <https://michael-gahn.de> mit Version, reproduzierbaren Schritten und möglicher Auswirkung.

## Sicherheitsgrenzen

- Das Plugin speichert keine Zugangsdaten oder Tokens.
- Einstellungsänderungen erfordern `manage_options` und einen WordPress-Nonce.
- Der erzeugte Seitentext wird über die WordPress-API als Entwurf angelegt.
- Das Frontend lädt keine externen Ressourcen.
- Der GitHub-Updater akzeptiert nur ein festes öffentliches Repository, semantische stabile Versionen und ein fest benanntes Release-Asset.
