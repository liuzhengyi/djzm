<?php
$test['test'] =  ' blank blank line lll  ';
$test['blanks'] = '    ';
$test['blank_line'] = '


';

function trim_value(&$value) {
	$value = trim($value);
}
echo "\nvar_dump(\$test)\n";
var_dump($test);

echo "\n\n";
array_walk($test, 'trim_value');
var_dump($test);
	
?>
