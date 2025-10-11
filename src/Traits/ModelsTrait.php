<?php

namespace WPSPCORE\Database\Traits;

use WPSPCORE\Funcs;

trait ModelsTrait {

	public $roleModel;
	public $permissionModel;
	public $funcs;

	public function __construct($attributes = []) {
		$this->funcs           = Funcs::getInstance();
		$this->roleModel       = Funcs::getInstance()->_config('permission.models.role');
		$this->permissionModel = Funcs::getInstance()->_config('permission.models.permission');
		$this->connection      = Funcs::getInstance()->_getAppShortName() . '_' . $this->connection;
		$this->customPrefix();
		parent::__construct($attributes);
	}

	protected function customPrefix() {
		if (!empty($this->prefix)) {
			$this->getConnection()->setTablePrefix($this->prefix);
		}
	}

}