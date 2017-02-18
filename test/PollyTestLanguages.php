<?php

class PollyTestLanguages extends PHPUnit_Framework_TestCase
{

	public function testEnglish(){

		require dirname(__DIR__).'/vendor/autoload.php';
		
		$credentials=__DIR__.'/credentials.json';
		if(!file_exists($credentials)){
			throw new Exception('Put your AWS credentials in: '.$credentials.' ie: {}');
		}

		$file = (new nickolanack\Polly(
		            array(
		                'region'  => 'us-west-2',
		                'version' => 'latest',
		                'credentials'=>get_object_vars(json_decode(file_get_contents($credentials)))
		            )
		        ))->setVoice('Brian')->textToSpeach('Hello World');


		//This works on MacOs
		shell_exec('afplay '.escapeshellarg($file).' &');


	}


	public function testRussian(){

		require dirname(__DIR__).'/vendor/autoload.php';
		
		$credentials=__DIR__.'/credentials.json';
		if(!file_exists($credentials)){
			throw new Exception('Put your AWS credentials in: '.$credentials.' ie: {}');
		}

		$file = (new nickolanack\Polly(
		            array(
		                'region'  => 'us-west-2',
		                'version' => 'latest',
		                'credentials'=>get_object_vars(json_decode(file_get_contents($credentials)))
		            )
		        ))->setVoice('Maxim')->textToSpeach('Привет мир');;


		//This works on MacOs
		shell_exec('afplay '.escapeshellarg($file).' &');


	}




}