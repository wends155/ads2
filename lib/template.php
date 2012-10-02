<?php
	require_once 'Twig/Autoloader.php';
	class Template{
		
		public static $environment = null;
		public static $loader = null;
		
		public static function getTwig(){
			if(self::$loader && self::$environment){
				
				return self::$environment;
			
			}
			
			require_once 'Twig/Autoloader.php';
			Twig_Autoloader::register();
				
			self::$loader = new Twig_Loader_Filesystem('../templates');
			self::$environment = new Twig_Environment(self::$loader);
			
			$lexer = new Twig_Lexer(self::$environment, array(
					'tag_comment'  => array('<%#', '%>'),
					'tag_block'    => array('<%', '%>'),
					'tag_variable' => array('<%=', '%>'),
				));
			self::$environment->setLexer($lexer);
			
			return self::$environment;
		}
		
		public static function load($file){
			if ($file){
				$env = self::getTwig();
				return $env->loadTemplate($file);
			}
			throw new Exception('No template file called');
		}
		
	}


?>
