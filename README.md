# Ewebovky/ARES

API konektor pro Administrativní registr ekonomických subjektů (ARES)

## Autor
Václav Pavlů - Ewebovky, s.r.o. | pavlu@ewebovky.cz | https://www.ewebovky.cz

## Instalace

```bash
composer require ewebovky/ares
```

Registrace služby v Symfony
```php
# config/services.yaml

services:
    Ewebovky\Ares\Ares:
    ...
```
## Použití

```php
use Ewebovky\Ares\Ares;

$ares = new Ares;

// Hledání podle IČ nebo názvu firmy
$ico_nebo_nazev_firmy = 71409891;
$ico_nebo_nazev_firmy = '71409891';
$ico_nebo_nazev_firmy = 'Václv Pavlů'
$ico_nebo_nazev_firmy = 'ewebovky'
$firmy = $ares->searchSubjects($ico_nebo_nazev_firmy);

// Hledání podle IČ
$ico = 71409891;
$ico = '71409891';
$firma = $ares->vratEkonomickySubjekt($ico);

// Hledání podle názvu firmy
$nazev_firmy = 'vaclav pavlu';
$nazev_firmy = 'ewebovky';
$firmy = $ares->vyhledejEkonomickeSubjekty($nazev_firmy);

// Validace IČ
$ico = 71409891;
$ico = '71409891';
$valid_ic = $ares->verifyIC($ico);

// Načtení zveřejněných bankovních účtu a ověření nespolehlivosti plátce u MFČR
$dic= 'CZ8512090895';
$data = $ares->overitDIC($dic)
```

