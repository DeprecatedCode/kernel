<?php

namespace Evolution\Kernel;

/**
 * Kernel Service, binds agents to tasks. 
 *
 * To offer: 		Services::bind($this, 'members:logout');
 *
 * To do a task: 	Services::do('members:logout', 'arg1', ...);
 *
 * To need: 		Services::require('members:logout', 'arg1', ...);
 */
class Services {
	
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
	
}

class Completion extends \Exception {
	
	public $value;
	
	public function __construct($value) {
		$this->value = 
	}
}