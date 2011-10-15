<?php

namespace Evolution\Kernel;

/**
 * Evolution Kernel Message
 * Prints exceptions to the screen.
 */
class Message {

	public function __construct($object) {
		
		// Load info from service
		$info = Service::run('kernel:message:information');
		
		// If any info was sent, add a header
		if(count($info))
			array_unshift($info, "<h1>System Information</h1>");
			
		// Check for exception
		if($object instanceof \Exception)
			$ex = $this->displayException($object);
		else
			$ex = '';
		
		// Use the standard page
		$page = new View((object) array(
			'title' => 'EvolutionSDK &rarr; System Message',
			'titlePrefix' => '<a href="">&#8635;</a>',
			'body' => $ex . implode('', $info)
		));
	}
	
	/**
	 * Display each exception
	 */
	private function displayException(&$exception) {
		
		// Get message
		$message = $exception->getMessage();
		$message = preg_replace('/`([^`]*)`/x', '<code>$1</code>', $message);
		
		$out = "<div class='section'><h1>Uncaught ".get_class($exception)."</h1>";
		
		// Show message
		if(strlen($message) > 1)
			$out .= "<p>$message</p>";
		
		// Show stack trace
		$out .= '<h4>Stack Trace</h4><div class="trace">';
		$trace = (array) $exception->getTrace();
		foreach($trace as $step) {
			$class = isset($step['class']) 		? "<span class='class'>$step[class]</span>$step[type]" : '';
			$args = isset($step['args']) 		? implode(', ', $this->filter($step['args'])) : '';
			$func = isset($step['function']) 	? "<span class='func'>$step[function]</span><span class='parens'>(</span>$args<span class='parens'>)</span>" : '';
			$file = isset($step['file']) 		? "<span class='file'>in $step[file]</span>" : '';
			$line = isset($step['line']) 		? "on <span class='line'>line $step[line]</span>" : '';
			
			$out .= "<div class='step'>$class$func $file $line</div>";
		}
		$out .= '</div>';
		
		// Check for previous exception
		$prev = $exception->getPrevious();
		if(is_object($prev))
			$out .= $this->displayException($prev);
			
		// Return output
		return $out;
	}
	
	/**
	 * Filter an array by PHP type
	 */
	private function filter(&$array) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				$array[$key] = "<span class='array'>Array [".count($value)."]</span>";
			} else if(is_string($value)) {
				$array[$key] = "<span class='string'>&apos;$value&apos;</span>";
			} else if($value === null) {
				$array[$key] = "<span class='boolean'>null</span>";
			} else if($value === false) {
				$array[$key] = "<span class='boolean'>false</span>";
			} else if($value === true) {
				$array[$key] = "<span class='boolean'>true</span>";
			} else if(is_numeric($value)) {
				$array[$key] = "<span class='number'>$value</span>";
			} else if(is_object($value)) {
				$array[$key] = "<span class='object'>Object ".get_class($value)."</span>";
			}
		}
		return $array;
	}
}