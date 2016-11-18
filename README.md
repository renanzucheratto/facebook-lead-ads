# facebook-lead-ads

#### Instalação

```php
require_once __DIR__ . '/vendor/autoload.php';
use FacebookAds\Api;
use FacebookAds\Object\Lead; 

Api::init(<ID_DO_APP>, <CHAVE_SECRETA_DO_APP>, <TOKEN_DE_ACESSO>);

$forms = new Lead($ldid);
$forms->read();
```