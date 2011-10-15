<?php

namespace Evolution\Kernel;

/**
 * Visual theme for system views
 */
class View {
	
	public function __construct($data) {
		
		Theme::header($data->title);
		
		echo "
			<h1>$data->titlePrefix$data->title</h1>
			$data->body
		";
		exit;
	}
}