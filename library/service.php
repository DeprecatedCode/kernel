<?php

namespace Evolution\Kernel;

/**
 * Kernel Service, binds agents to tasks. 
 *
 * To offer: 		Service::bind($this, 'members:logout');
 *
 * To run a task: 	Service::run('members:logout', 'arg1', ...);
 *
 * To need a task:	Service::complete('members:logout', 'arg1', ...);
 */
class Service {
	
	// Bound service providers
	private static $services = array();
	
	// Exceptions encountered
	private static $exceptions = array();
	
	// Mode
	private static $mode = 'run';
	
	// Bind a provider to offer one or many services
	public static function bind() {
		
		// What services to bind
		$services = func_get_args();
		
		// First argument is what to bind to
		$agent = array_shift($services);
		
		// Check for agent
		if(is_null($agent))
			throw new \InvalidArgumentException("An agent must be passed to the `Service::bind` call as the first argument.");
			
		// Check for services
		if(!count($services))
			throw new \InvalidArgumentException("Bound service(s) must be passed to the `Service::bind` call after the agent.");
		
		// Bind all services
		foreach($services as $service) {
			
			// Setup service array
			if(!isset(self::$services[$service]))
				self::$services[$service] = array();
				
			// Add service
			self::$services[$service][] = $agent;
		}
	}
	
	// Run a service, no exceptions will be thrown
	public static function run() {
		
		// What arguments to pass
		$args = func_get_args();
		
		// Clear current exceptions
		self::$exceptions = array();
		
		// Check for task name
		if(!isset($args[0]) || !is_string($args[0]))
			throw new \Exception("No task name provided");
		
		// First argument is the task name
		$name = array_shift($args);
		
		// Run the task
		return self::runService('each', $name, $args);
	}
	
	// Internal service engine
	private static function runService($type, $name, $args) {
	
		// Prepare result
		$result = array();
		
		// If no bindings
		if(!isset(self::$services[$name]))
			return $result;
		
		// Loop throuch bound providers
		foreach(self::$services[$name] as $provider) {
			
			// Try so we can handle exceptions properly
			try {
				
				// Save the result
				$result[] = call_user_func_array($provider, $args);
			} catch(Completion $c) {
				
				// If running as complete, throw again
				if($type == 'complete')
					throw $c;
				
				// If running as each, save the value
				if($type == 'each')
					$result[] = $c->value;
				
			}
		}
		
		// Return result
		return $result;
	}
	
	// Return all exceptions
	public static function lastExceptions() {
		return self::$exceptions;	
	}
	
	// Require exactly one completion of a service
	public static function complete() {
		
		// What arguments to pass
		$args = func_get_args();
		
		// Check for task name
		if(!isset($args[0]) || !is_string($args[0]))
			throw new \Exception("No task name provided");
		
		// Get name
		$name = array_shift($args);
		
		// Run the task
		self::runService('complete', $name, $args);
		
		// Throw incomplete exception if no Completion was caught
		throw new IncompleteException("Task `$name` was not completed by any agents,
			either catch this exception or have an agent provide this service.");
	}
	
}

/**
 * Thrown when no completion was thrown
 */
class IncompleteException extends \Exception {}

/**
 * Throw a Completion to complete a task and return a value
 */
class Completion extends \Exception {
	
	public $value;
	
	public function __construct($value = null) {
		$this->value = $value;
	}
}