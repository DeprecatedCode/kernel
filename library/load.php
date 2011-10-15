<?php

namespace Evolution\Kernel;

/**
 * Kernel Class Loader
 */
class Load {
	
	// Load from dirs
	public static $from = array();
	
	// Load records
	private static $records = array();
	
	/**
	 * Record a successful load
	 */
	public static function record($dir, $file, $class) {
		
		// Prepare records for dir
		if(!isset(self::$records[$dir]))
			self::$records[$dir] = array();
			
		// Save load record
		self::$records[$dir][$file] = $class;
	}
	
	/**
	 * Get information about loaded bundles
	 */
	public static function loadedBundles() {
	
		$out = '';
		$out .= "<h4>Bundle Paths</h4>";
		$paths = '';
		foreach(self::$records as $dir => $classes) {
			$paths .= '<div class="step"><span class="file">' . $dir . '</span>';
			$classes = implode('</span> &bull; <span class="class">', $classes);
			if($classes !== '')
				$classes = ": <span class=\"class\">$classes</span>";
			$paths .= $classes . '</div>';
		}
		$out .= "<div class='trace'>$paths</div>";
		
		return $out;
	}
	
	/**
	 * Autoloader
	 */
	public static function auto($class) {
		
		// Get class path
		$path = explode('\\', $class);
		if($path[0] === '')
			array_shift($path);
		if($path[0] === 'Evolution')
			array_shift($path);
			
		// Make sure we still have something to find
		if(count($path) === 0)
			throw new \Exception("Invalid class name `$class`");
		
		// Build possible files
		$bundle = strtolower($path[0]);
		$name = array_pop($path);
		$files = array(
			implode('/', $path).'/'.$name,
			implode('/', $path).'/library/'.$name
		);
		
		// Check load paths
		foreach(Load::$from as $dir) {
			foreach($files as $file) {
			
				// Check file locations
				$file = $dir . '/' . strtolower($file) . '.php';
				if(is_file($file))
					require_once($file);
					
				// Stop if class is found
				if(class_exists($class)) {
					Load::record($dir, $file, $class);
					return true;
				}
			}
		}
		
		if(!class_exists($class))
			throw new \Exception("Class `$class` could not be located, check bundle paths or
				<a href='/+evolution/install:$bundle'>Install $bundle bundle</a>");
	}
}

// Register Autoload
spl_autoload_register(__NAMESPACE__.'\Load::auto');

// Add the main load path
Load::$from[] = dirname(dirname(__DIR__));

// Bind kernel information request to Load
Service::bind(__NAMESPACE__ . '\Load::loadedBundles', 'kernel:message:information');