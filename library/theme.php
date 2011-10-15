<?php

namespace Evolution\Kernel;

/**
 * Visual theme for fatal errors and installation
 */
class Theme {
	
	public static function header($title = 'EvolutionSDK') {
		
	echo <<<EOF
<!doctype html>

<!-- Evolution\Kernel\View -->
<html>
	<head>
		<title>$title</title>
		<style>
			body {
				font-size: 16px;
				font-family: Tahoma, Sans, Lucida Grande, sans-serif;
				padding: 0 0 30px;
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
				font-size: 15px;	
				padding: 0 30px;
			}
			.section .section {
				border-left: 30px solid #eee;
			}
			h1 {
				font-size: 120%;
				margin: 30px 0 14px;
			}
			code, .trace, h4, .key {
				padding: 2px 4px;
				margin: 0 2px;
				border-radius: 4px;
			}
			h4 code {
				margin: 0 -4px;
			}
			code {
				background: #fe8;
				text-shadow: 1px 1px 1px #ffa;
				font-family: Consolas, monospace;
			}
			code.alt {
				background:#237;	
				text-shadow: 1px 1px 1px #124;
				color: #fff;
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
				margin-bottom: 20px;
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
			.object {	color: darkred;	}
			.class {	color: darkred;		}
			
			.selected {
				color: white;
				padding: 2px 4px;
				border-radius: 4px;
				text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
			}
			.class.selected {
				background: darkred;
			}
			
			/* Dump Styles */
			table.dump {
				border-collapse: collapse;
				width: 100%;
			}
			table.dump td {
				padding: 4px 0;	
			}
			table.dump td.dump-array {
				background: #f8f8f8;
				padding: 8px;
				border: 1px solid #ccc;
			}
			table.dump td.dump-array td.dump-array {
				background: #fcfcfc;
			}
			table.dump td.dump-array td.dump-array td.dump-array {
				background: #eee;
			}
			table.dump td.dump-array td.dump-array td.dump-array td.dump-array {
				background: #f8f8f8;
			}
			
			table.dump td.dump-key {
				padding: 4px 2px;
			}
			.key { background: #e0e0e0; color: black;
				font-size: 12px;
				text-shadow: 1px 1px 1px #fff; margin: 0 6px 0 0;
				padding: 1px 4px;}
		</style>
	</head>
	<body>
EOF;
	}
	
	public static function footer() {
		
	echo <<<EOF
	</body>
</html>
EOF;
	}
	
}