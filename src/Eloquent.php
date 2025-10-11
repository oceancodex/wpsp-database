<?php

namespace WPSPCORE\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use WPSPCORE\Base\BaseInstances;

class Eloquent extends BaseInstances {

	/** @var Capsule|null */
	public $capsule    = null;
	public $connection = 'mysql';

	/*
	 *
	 */

	public function afterConstruct() {
		if (!$this->capsule) {
			$this->capsule = new Capsule();

			if (class_exists('\WPSPCORE\MongoDB\Connection')) {
				$this->capsule->getDatabaseManager()->extend('mongodb', function($config, $name) {
					$config['name'] = $name;
					return new \WPSPCORE\MongoDB\Connection($config);
				});
			}

			global $wpspDatabaseConnections;
			$wpspDatabaseConnections = array_merge(
				$wpspDatabaseConnections ?? [],
				$this->funcs->_config('database.connections')
			);

			$defaultConnectionName   = $this->funcs->_getAppShortName() . '_' . $this->funcs->_config('database.default');
			$defaultConnectionConfig = $wpspDatabaseConnections[$defaultConnectionName];
			$this->capsule->addConnection($defaultConnectionConfig);

			foreach ($wpspDatabaseConnections as $connectionName => $connectionConfig) {
				$this->capsule->addConnection($connectionConfig, $connectionName);
			}

			$this->capsule->setAsGlobal();
			$this->capsule->bootEloquent();
		}
	}

	/*
	 *
	 */

	public function global() {
		$globalEloquent = $this->funcs->_getAppShortName();
		$globalEloquent = $globalEloquent . '_eloquent';
		global ${$globalEloquent};
		${$globalEloquent} = $this;
	}

	/*
	 *
	 */


	/**
	 * @return Capsule|null
	 */
	public function getCapsule() {
		return $this->capsule;
	}

	/*
	 *
	 */

	public function dropDatabaseTable($tableName) {
		$this->funcs->_getAppEloquent()->getCapsule()->getDatabaseManager()->getSchemaBuilder()->withoutForeignKeyConstraints(function() use ($tableName) {
			$this->getCapsule()->getDatabaseManager()->getSchemaBuilder()->dropIfExists($tableName);
		});
		return $tableName;
	}

	public function dropAllDatabaseTables() {
		$definedDatabaseTables = $this->funcs->_getAppMigration()->getDefinedDatabaseTables();
		$definedDatabaseTables = array_merge($definedDatabaseTables, ['migration_versions']);
		foreach ($definedDatabaseTables as $definedDatabaseTable) {
			$tableDropped = $this->dropDatabaseTable($definedDatabaseTable);
		}
		return ['success' => true, 'data' => $definedDatabaseTables, 'message' => 'Drop all database tables successfully!', 'code' => 200];
	}

}