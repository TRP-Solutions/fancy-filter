<?php
/*
FancyFilter is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/fancy-filter/blob/master/LICENSE
*/
class FancyFilter {
	private static $filters = [], $escape_function, $cookie_prefix = 'ffilter_', $store_options = [];
	const UNSET_MISSING = 1;

	public static function get($name, $defaults = null, $values = null, $selected_keys = null, $options = 0){
		if(!isset(self::$filters[$name])){
			$filter = new self($name);
			self::$filters[$name] = $filter;
		}
		if(is_array($defaults)){
			self::$filters[$name]->defaults = array_filter($defaults,['self', 'filter_default'], ARRAY_FILTER_USE_KEY);
		}
		if(is_array($values)){
			self::$filters[$name]->set($values, $selected_keys, !($options & self::UNSET_MISSING));
		}
		return self::$filters[$name];
	}

	private static function filter_default($key){
		return !is_numeric($key);
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

	public static function set_store_options($options){
		self::$store_options = $options;
	}

	private $name, $defaults = [], $values = null;

	private function __construct($name){
		$this->name = self::$cookie_prefix.$name;
	}

	private function set($values, $selected_keys, $ignore_missing = true){
		if(!is_array($selected_keys)){
			$selected_keys = array_keys($values);
		}
		foreach($selected_keys as $key){
			if(!array_key_exists($key, $values) && $ignore_missing) continue;
			$this->load();
			if(!empty($values[$key])){
				$this->values[$key] = $values[$key];
			} else {
				unset($this->values[$key]);
			}
		}
		$this->store();
	}

	private function load(){
		if(!isset($this->values)){
			if(!isset($_COOKIE[$this->name])){
				$this->values = [];
			} else {
				$this->values = json_decode($_COOKIE[$this->name],true);
				if(!is_array($this->values)) $this->values = [];
			}
		}
	}

	private function store(){
		if(!isset($this->values)) return;
		$json = json_encode($this->values);
		if(!empty(self::$store_options)){
			if(PHP_VERSION_ID >= 70300){
				setcookie($this->name, $json, self::$store_options);
			} else {
				setcookie(
					$this->name,
					$json,
					isset(self::$store_options['expires']) ? self::$store_options['expires'] : 0,
					isset(self::$store_options['path']) ? self::$store_options['path'] : "",
					isset(self::$store_options['domain']) ? self::$store_options['domain'] : "",
					isset(self::$store_options['secure']) ? self::$store_options['secure'] : false,
					isset(self::$store_options['httponly']) ? self::$store_options['httponly'] : false
				);
			}
		} else {
			setcookie($this->name, $json);
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
			$value = (self::$escape_function)($value);
		}
		return $value;
	}

	public function __isset($key){
		$this->load();
		return isset($this->values[$key]) || isset($this->defaults[$key]);
	}
}
