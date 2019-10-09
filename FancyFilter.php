<?php
class FancyFilter {
	private static $filters = [], $escape_function, $cookie_prefix = 'ffilter_';

	public static function get($name){
		if(!isset(self::$filters[$name])){
			self::$filters[$name] = new self($name);
		}
		return self::$filters[$name];
	}

	public static function set_escape_function($func){
		if(is_callable($func)){
			self::$escape_function = $func;
		}
	}

	public static function set_cookie_prefix($prefix){
		if(is_string($prefix)){
			self::$cookie_prefix = $prefix;
		}
	}

	private $name, $defaults = [], $values = null;

	private function __construct($name){
		$this->name = $name;
	}

	public function defaults($defaults){
		if(!is_array($defaults)) return;
		$this->defaults = $defaults;
	}

	private function cookiename(){
		return self::$cookie_prefix.$this->name;
	}

	private function load(){
		if(!isset($this->values)){
			$name = $this->$cookiename();
			if(!isset($_COOKIE[$name])){
				$this->values = [];
			} else {
				$this->values = json_decode($_COOKIE[$name]);
			}
		}
	}

	public function __get($key){
		$this->load();
		if(isset($this->values[$key])){
			$value = $this->values[$key];
		} elseif(isset($this->defaults[$key])){
			$value = $this->defaults[$key];
		} else {
			$value = null;
		}
		if(isset($value) && isset(self::$escape_function)){
			$value = self::$escape_function($value);
		}
		return $value;
	}

	public function __isset($key){
		$this->load();
		return isset($this->values[$key]) || isset($this->defaults[$key]);
	}
}

?>