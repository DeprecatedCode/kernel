<?php

namespace Evolution\Kernel;

/**
 * Evolution Configure
 * Configure sets basic options for any bundle
 * @author Nate Ferrero
 */
class Configure {
	
	private static $configuration = array();
	
	public static function set($name, $value) {
		self::$configuration[$name] = $value;
	}
	
	public static function add($name, $value) {
		if(isset(self::$configuration[$name]) && 
			is_array(self::$configuration[$name]))
			self::$configuration[$name][] = $value;
		else if(!isset(self::$configuration[$name]))
			self::$configuration[$name] = array($value);
		else
			self::$configuration[$name] = array(self::$configuration[$name], $value);
	}
	
	public static function get($name) {
		return isset(self::$configuration[$name]) ? self::$configuration[$name] : null;
	}
	
	public static function getArray($name) {
		$x = self::get($name);
		if(is_array($x))
			return $x;
		if(is_null($x))
			return array();
		return array($x);
	}
	
}