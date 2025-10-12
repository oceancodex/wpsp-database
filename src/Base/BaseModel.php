<?php

namespace WPSPCORE\Database\Base;

use Illuminate\Database\Eloquent\Model;
use WPSPCORE\Traits\BaseInstancesTrait;

class BaseModel extends Model {

	use BaseInstancesTrait;

	public function __construct($attributes = []) {
		$this->beforeBaseInstanceConstruct();
		$this->connection = $this->funcs->_getAppShortName() . '_' . $this->connection;
		$this->customPrefix();
		parent::__construct($attributes);
	}

	/*
	 *
	 */

	protected function customPrefix() {
		if (!empty($this->prefix)) {
			$this->getConnection()->setTablePrefix($this->prefix);
		}
	}

	/*
	 *
	 */

	protected function beforeConstruct() {}

	protected function beforeInstanceConstruct() {}

	protected function afterConstruct() {}

	protected function afterInstanceConstruct() {}

}