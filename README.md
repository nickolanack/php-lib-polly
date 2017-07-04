# php-lib-polly
AWS Polly class to help query and cache text to speech


Usage
```
composer install 
```


```php

require __DIR__.'/vendor/autoload.php';

$file = (new nickolanack\Polly(
			array(
			    'region'  => 'us-west-2',
			    'version' => 'latest',
			    'credentials'=>array(
			    	'key'=>'XXXXXXXXXXXXX',
			    	'secret'=>'XXXXXXXXXXXXXXXXXXXXX'
			    )
			)
		))->setVoice('Brian')->textToSpeach('Hello World');


//This works on MacOs
shell_exec('afplay '.escapeshellarg($file).' &');


```

Using ssml: 

```
require __DIR__.'/vendor/autoload.php';

$file = (new nickolanack\Polly(
			array(
			    'region'  => 'us-west-2',
			    'version' => 'latest',
			    'credentials'=>array(
			    	'key'=>'XXXXXXXXXXXXX',
			    	'secret'=>'XXXXXXXXXXXXXXXXXXXXX'
			    ),
			    'textType'=>'ssml' //set text type, default is 'text'
			)
		))->setVoice('Brian')->textToSpeach('<speak>Hello <amazon:effect name="whispered">World</amazon:effect></speak>');


//This works on MacOs
shell_exec('afplay '.escapeshellarg($file).' &');

```
