<?php

namespace app\models;

class Collections extends \lithium\data\Model {

	public static function __init(array $options = array()) {
		parent::__init($options = array());

		static::applyFilter('find', function($self, $params, $chain) {
			if (isset($params['options']['source'])) {
				$self::meta('source', $params['options']['source']);
			}
			return $chain->next($self, $params, $chain);
		});
	}
}

?>