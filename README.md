# facebook-lead-ads

Depois de diversas tentativas de obter os leads via API do Face, me deparei com um erro que nem os caras do Face conseguiram me ajudar. Eu segui o tutorial deles exatamente como solicitado na documentação deles.

Buscando outras formas de retornar os retornar os valores dos campos, encontrei uma solução paleativa fazendo a busca com CURL, requisitando o graph.facebook.

Vamos lá !

### Configuração

```php
//Essa primeira linha retorna em `string` todo o arquivo contido na URL setada | Analisa a string codificada JSON e converte em uma variável
$inputurl = json_decode(file_get_contents('php://input'), true);
//Percorre o json até chegar ao id do Lead
$leadgen_id = $inputurl["entry"][0]["changes"][0]["value"]["leadgen_id"];

//Inicia o cURL acessando uma URL | O Token de acesso é obtido no app que você criou
$ch = curl_init('https://graph.facebook.com/'.$leadgen_id.'?access_token=<TOKEN_DE_ACESSO>');
// Define a opção que diz que você quer receber o resultado encontrado
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Esta opção determina se curl verificará a autenticidade do certificado. Os valores podem ser TRUE ou FALSE e/ou 1 para TRUE e 0 para FALSE
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Verifica se o HOST e o SSL são verdadeiros ou se existem em comum
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// Executa a consulta, conectando-se ao site e salvando o resultado na variável $response
$response = curl_exec($ch);

//Convertendo valor em JSON para a variável $output em PHP
$output = json_decode($response);
```

#### Valor do OUTPUT ( retorno )
> Para exibir o valor exatamente igual a seguir, insira o seguinte código

```php
echo '<pre>'; print_r($output); echo '</pre>';
```
#### O retorno será o seguinte

```php
stdClass Object
(
	[created_time] => 2016-11-21T12:32:12+0000
	[id] => 546546545465465
	[field_data] => Array
		(
			[0] => stdClass Object
				(
					[name] => full_name
					[values] => Array
					(
						[0] => Marcolino da Silva
					)
				)
			[1] => stdClass Object
				(
					[name] => email
					[values] => Array
						(
							[0] => marcolino.silva@gmail.com
						)
				)
			[2] => stdClass Object
				(
					[name] => work_phone_number
					[values] => Array
						(
							[0] => +5511999999999
						)
				)
		)
)
```

#### Percorrendo o Objeto
Agora vamos guardar os valores que nos interessa em variáveis. ( Nome, Email e Telefone )

>É necessário observar que o objeto contém arrays e para isso devemos percorrer dessa forma:

```php
$output //Objeto mãe
field_data[0] //Acessando o índice 0 do array field_data sendo que [0] é um objeto
values[0] //Acessando o índice 0 do array values sendo que nesse caso [0] é um array
```

As variáveis ficarão dessa forma


```php
$nome 	= $output->field_data[0]->values[0];
$email 	= $output->field_data[1]->values[0];
$phone 	= $output->field_data[2]->values[0];
```