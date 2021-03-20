<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository.
 *
 * @package App\Repositories
 *
 * репозиторий работы с сущностью.
 * может выдавать наборы данных.
 * не может создаввать/изменять сущности.
 *
 */
abstract class CoreRepository
{
	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * CoreRepository constructor
	 */

	public function __construct()
	{
		$this->model = app( $this->getModelClass() );
	}

	abstract protected function getModelClass();

	/**
	 * @return Model| \Illuminate\Foundation\Application|mixed
	 *
	 */

	protected function startConditions()
	{
		return clone $this->model;
	}
}
