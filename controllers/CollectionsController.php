<?php

namespace app\controllers;

use app\models\Collection;
use lithium\data\Connections;

class CollectionsController extends \lithium\action\Controller {

	/**
	 * This method is called when the controller is initialized. It checks to see if the request
	 * has been made by jQuery, and if so, disables the layout.
	 *
	 * @return void
	 */
	protected function _init() {
		parent::_init();

		if ($this->request->is('ajax')) {
			$this->_render['layout'] = false;
		}
	}

	public function index() {
		$collections = Connections::get('default')->entities();

		if ($this->request->is('ajax')) {
			$this->render(array(
				'template' => '../elements/collections', 'data' => compact('collections')
			));
			return;
		}
		return compact('collections');
	}

	public function view() {
		$data = Collections::all(array('source' => $this->request->params['id']));
		return compact('data');
	}

	public function edit() {
		$path = $this->request->params['args'];
		$_id = array_shift($path);

		$this->request->data['old'] = $this->_coerceType($this->request->data['old']);
		$this->request->data['data'] = $this->_coerceType($this->request->data['data']);

		$item = $document = Collections::first(array(
			'source' => $this->request->params['id'],
			'conditions' => compact('_id')
		));

		if (!$item) {
			$this->render(array('text' => $this->request->data['old']));
			return;
		}

		foreach (array_slice($path, 0, -1) as $key) {
			if (is_array($item)) {
				$item =& $item[$key];
			} else {
				$item =& $item->{$key};
			}
		}
		$key = end($this->request->params['args']);
		$success = false;

		if (is_array($item) && $item[$key] == $this->request->data['old']) {
			$item[$key] = $this->request->data['data'];
			$success = true;
		}

		if (!is_array($item) && $item->{$key} == $this->request->data['old']) {
			$item->{$key} = $this->request->data['data'];
			$success = true;
		}

		if ($success) {
			$document->save();
			$this->render(array('text' => $this->request->data['data']));
			return;
		}
		$this->render(array('text' => $this->request->data['old']));
	}

	protected function _coerceType($data) {
		switch ($data) {
			case 'null':
				return null;
			case 'true':
				return true;
			case 'false':
				return false;
		}
		return is_numeric($data) ? floatval($data) : $data;
	}
}

?>
