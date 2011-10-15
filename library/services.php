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
	
	private static $services = array();
	
	public static function bind() {
		
		// What services to bind
		$services = func_get_args();
		
		// First argument is what to bind to
		$agent = array_shift($services);
		
		// Bind all services
		foreach($services as $service) {
			
			// Setup service array
			if(!is_array($this->services[$service]))
				$this->services[$service] = array();
				
			// Add service
			$this->services[$service][] = $agent;
		}
	}
	
	public static function run() {
		
		// What arguments to pass
		$args = func_get_args();
		
		// Check for task name
		if(!isset($args[0]) || !is_string($args[0]))
			throw new \Exception("No task name provided");
		
		// First argument is the task name
		$name = array_shift($args);
		
	}
	
	public static function complete() {
		
		// What arguments to pass
		$args = func_get_args();
		
		// Check for task name
		if(!isset($args[0]) || !is_string($args[0]))
			throw new \Exception("No task name provided");
		
		// Store name
		$name = $args[0];
		
		// Run the task
		try {
			call_user_func_array(__NAMESPACE__ .'\Services::run', $args);
		}
		
		// If completed, return the completion value
		catch(Completion $c) {
			return $c->value;
		}
		
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