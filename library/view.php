<?php

namespace Evolution\Kernel;

/**
 * Visual theme for system views
 */
class View {
	
	public function __construct($data) {
	echo <<<EOF
<!doctype html>

<!-- Evolution\Kernel\View -->
<html>
	<head>
		<title>$data->title</title>
		<style>
			body {
				font-size: 16px;
				font-family: Tahoma, Sans, Lucida Grande, sans-serif;
				padding: 0;
				margin: 0;
			}
			body > h1 {
				margin: 0;
				font-size: 18px;
				color: white;
				border-bottom: 2px solid #000;
				background: #333;
				text-shadow: 2px 2px 1px #000;
				padding: 30px;
			}
			body > h1 > a {
				float: right;
				color: #fff;
				text-decoration: none;
				border: 2px solid transparent;
				border-radius: 4px;
				padding: 4px;
				margin: -4px;
			}
			body > h1 > a:hover {
				background: #555;
				box-shadow: 0 0 3px #000;
				text-shadow: none;
			}
			body > h1 > a:active {
				background: #555;
				box-shadow: inset 0 0 3px #000;
				text-shadow: none;
			}
			a {
				color: #666;	
			}
			.section {
				font-size: 90%;	
				padding: 0 30px 30px;
			}
			.section .section {
				border-left: 2px solid #888;
				font-size: 15px;
			}
			h1 {
				font-size: 120%;
				margin: 30px 0 14px;
			}
			code, .trace, h4 {
				padding: 2px 4px;
				margin: 0 2px;
				border-radius: 4px;
			}
			code {
				background: #fe8;
				text-shadow: 1px 1px 1px #ffa;
				font-family: Consolas, monospace;
			}
			h4 {
				float: left;
				padding: 6px 10px;
				position: relative;
				top: 4px;
				font-size: 13px;
				box-shadow: inset 0 4px 10px #ccc;
				font-weight: bold;
			}
			.trace {
				clear: left;
				font-family: Consolas, monospace;
				box-shadow: inset 0 0 10px #ccc;
			}
			.trace, h4 {	
				text-shadow: 1px 1px 1px #fff;
				background: #eee;
			}
			.trace > .step {
				font-size: 80%;	
				margin: 8px;
			}
			.line, .func, .parens {
				font-weight: bold;
			}
			.line {		color: purple;		}
			.func {		color: darkblue;	}
			.array {	color: orange;		}
			.string {	color: green;		}
			.boolean {	color: orange;		}
			.number {	color: red;			}
			.object {	color: orange;		}
			.class {	color: darkred;		}
		</style>
	</head>
	
	<body>
		<h1>$data->titlePrefix$data->title</h1>
		$data->body
	</body>
</html>
EOF;
		exit;
	}
}