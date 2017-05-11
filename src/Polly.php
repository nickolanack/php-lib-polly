<?php

namespace nickolanack;

class Polly{


	protected $polly;
	protected $voice='Emma';
	protected $mp3Path='/tmp';

	protected $validNames=array(

		'Nicole', 'Enrique', 'Tatyana', 'Carmen', 'Lotte', 'Russell', 'Geraint', 'Mads', 'Penelope', 'Joanna', 'Brian', 'Maxim', 'Ricardo', 'Ruben', 'Giorgio', 'Carla', 'Naja', 'Astrid', 'Maja', 'Ivy', 'Chantal', 'Kimberly', 'Amy', 'Marlene', 'Ewa', 'Conchita', 'Karl', 'Mathieu', 'Miguel', 'Justin', 'Jacek', 'Ines', 'Cristiano', 'Gwyneth', 'Mizuki', 'Celine', 'Jan', 'Liv', 'Joey', 'Filiz', 'Dora', 'Raveena', 'Salli', 'Vitoria', 'Emma', 'Hans', 'Kendra'

	);

	public function __construct($config){


	
		#require 'vendor/autoload.php';

		$sdk = new \Aws\Sdk($config);
		$polly=$sdk->createPolly();
		$this->polly=$polly;


	}

	public function textToSpeach($text){


		$text=trim($text);
		
		$folder = $this->mp3Path . '/Polly_' .strtolower($this->voice);
		if(!file_exists($folder)){
			mkdir($folder);
		}

		$file=$folder.'/'.md5($text).'.mp3';

		if(file_exists($file)){
			return $file;
		}

	
		$result=$this->polly->synthesizeSpeech(array(

		    'OutputFormat' => 'mp3', // REQUIRED

		    'Text' => $text, // REQUIRED
		    'TextType' => 'text',
		    'VoiceId' => $this->voice, // REQUIRED

		));

		file_put_contents($file, $result['AudioStream']->getContents());

		return $file;
	}

	public function setVoice($name){
		if(!in_array($name, $this->validNames)){
			throw new Exception('Voice: '.$name.', is not one of ['.implode(', ',$this->validNames).']');
		}
		$this->voice=$name;
		return $this;
	}

	public function setMp3Folder($path) {
		if ($path) {
			$this->mp3Path = $path; // Defaults to /tmp
		}
		return $this;
	}


}

class Voice{

	protected $languageEncoder;
	public function __construct($languageEncoder){

		$this->languageEncoder=$languageEncoder;


	}

	public function say($text){

		$path=$this->languageEncoder->textToSpeach($text);

		echo $path."\n";
		shell_exec('afplay '.escapeshellarg($path).' &');

		return $this;
	}


}


class Conversation{

	protected $voice;
	protected $replacements=array();

	public function __construct($voice){

		$this->voice=$voice;
	}

	public function say($text){

		foreach($this->replacements as $replace=>$value){
			$text=str_replace($replace, $value, $text);
		}

		$this->voice->say($text);
		return $this;

	}

	public function wait($s){
		sleep($s);
		return $this;
	}


	public function set($key, $value){

		$this->replacements['{'.$key.'}']=$value;
		return $this;

	}

}
