<?php

namespace Evolution\Kernel;
const Dump = true;

/**
 * Helper functions
 */
function dumpVars(&$out) {
	list($void, $file, $line) = $out;
	$code = file($file);
	$start = max(1, $line - 4);
	$vrx = '/(\\$)([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/';
	$out = '<div class="section"><p><span class="line">Lines '.$start.' &ndash; '.$line.'</span>
		of <code>'.$file.'</code></p>';
	$out .= '<h4>Source</h4><div class="trace">';
	$vars = array();
	for($i = $start; $i <= $line; $i++) {
		$src = $code[$i - 1];
		preg_match_all($vrx, $src, $matches);
		foreach($matches[2] as $mvar)
			$vars[$mvar] = 1;
		$src = htmlspecialchars($src);
		$src = preg_replace($vrx, '<code>$0</code>', $src);
		$src = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $src);
		$src = preg_replace('/eval\\(d\\)/', '<code class="alt">$0</code>', $src);
		$out .= '<div class="step"><span class="line">'.$i.'</span>&nbsp;'.$src.'</div>';
	}
	$out .= '</div></div><div class="section">';
	return array_keys($vars);
}
function dumpVar($var, $value, $depth = 0) {
	$out = "";
	if($depth === 0) {
		$xtra = '';
		if(is_object($value))
			$xtra = ' &nbsp; <span class="object">' . get_class($value) . '</span>';
		$out = "<h4><code>$$var</code>$xtra</h4><div class='trace'><div class='step'>";
	}
	
	if($value === array()) {
		$out .= '<span class="array">Empty Array</span>';
	}
	
	else if(is_array($value)) {
		$out .= '<div class="dump"><table class="dump">';
		foreach($value as $key => $sub) {
			if(is_array($sub) && count($sub) > 0)
				$type = 'array';
			else
				$type = 'value';
			$out .= '<tr><td align="right" width="1" class="dump-key"><span class="key">' . htmlspecialchars($key) . '</span></td>';
			$out .= '<td class="dump-'.$type.'">' . dumpVar(null, $sub, $depth + 1) . '</td>';
		}
		$out .= '</table></div>';
	}
	
	else if(is_string($value)) {
		$out .= '<span class="string">\'' . htmlspecialchars($value) . '\'</span>';
	}
	
	else if($value === true) {
		$out .= '<span class="boolean">true</span>';
	}
	
	else if($value === false) {
		$out .= '<span class="boolean">false</span>';
	}
	
	else if($value === null) {
		$out .= '<span class="boolean">null</span>';
	}
	
	else if(is_numeric($value)) {
		$out .= '<span class="number">' . htmlspecialchars($value) . '</span>';
	}
	
	else if(is_object($value)) {
		$out .= '{...}';
	}
	
	else {
		$out .= print_r($value, true);	
	}
	 
	if($depth === 0)
		$out .= '</div></div>';
	return $out;
}

/**
 * Get source and loop vars
 */
foreach(dumpVars($___DUMP) as $___VAR) {
	$___DUMP .= dumpVar($___VAR, isset(${$___VAR}) ? ${$___VAR} : null);
}

/**
 * View dump
 */
new View((object) array(
	'title' => 'EvolutionSDK &rarr; Debug Dump',
	'titlePrefix' => '<a href="">&#8635;</a>',
	'body' => $___DUMP . '</div>'
));