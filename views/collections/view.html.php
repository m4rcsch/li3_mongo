<?php

use lithium\data\entity\Document;

$list = function($data, $topLevel = false) use (&$list, $h) {
	echo "<ul>";
	foreach ($data as $key => $value) {
		echo '<li' . ($topLevel ? ' class="document"' : '') . '>';
		echo '<div class="key' . ($key === '_id' ? ' id' : '') . '">' . $h($key) . '</div>: ';
		echo '<div class="value">';

		switch (true) {
			case (is_bool($value)):
				echo $value ? 'true' : 'false';
			break;
			case (is_scalar($value) || (is_object($value)) && !$value instanceof Document):
				echo $h((string) $value);
			break;
			case ($value === null):
				echo 'null';
			break;
			default:
				$list($value instanceof Document ? $value->data() : $value, false);
			break;
		}
		echo '</div></li>';
	}
	echo "</ul>";
};
$list($data, true);

?>