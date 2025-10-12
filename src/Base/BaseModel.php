<?php
namespace WPSPCORE\Database\Base;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

	public $roleModel;
	public $permissionModel;
	public $funcs;

	public function __construct($attributes = []) {
		$this->beforeConstruct();
		$this->beforeInstanceConstruct();
		$this->funcs           = Funcs::getInstance();
		$this->roleModel       = Funcs::getInstance()->_config('permission.models.role');
		$this->permissionModel = Funcs::getInstance()->_config('permission.models.permission');
		$this->connection      = Funcs::getInstance()->_getAppShortName() . '_' . $this->connection;
		$this->customPrefix();
		parent::__construct($attributes);
		$this->afterConstruct();
		$this->afterInstanceConstruct();
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