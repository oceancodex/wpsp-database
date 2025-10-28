<?php
namespace WPSPCORE\Database\Base;

use MongoDB\Laravel\Eloquent\Model;
use WPSPCORE\Traits\BaseInstancesTrait;

class BaseMongoDBModel extends Model {

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

	public function customPrefix() {
		if (!empty($this->prefix)) {
			$this->getConnection()->setTablePrefix($this->prefix);
		}
	}

	/*
	 *
	 */

	public function beforeConstruct() {}

	public function beforeInstanceConstruct() {}

	public function afterConstruct() {}

	public function afterInstanceConstruct() {}

}