<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class BlogCategoryRepository.
 */
class BlogCategoryRepository extends CoreRepository
{
	/**
	 * @return string
	 */
	protected function getModelClass()
	{
		return Model::class;
	}

	/**
	 *
	 * получить модель для редактирования в админке.
	 *
	 * @param int $id
	 * @return Model
	 *
	 */

	public function getEdit($id)
	{
		return $this->startConditions()->find( $id );
	}

	/**
	 *
	 * получить список категорий для выводы в выпадающем списке.
	 *
	 * @return Collection
	 *
	 */
	public function getForComboBox()
	{
		//формируем title func.CONCAT -соединение строк
		$fields = implode( ',', [
			'id',
			'CONCAT (id, ".", title) AS id_title',
		] );

		$result = $this
			->startConditions()
			->selectRaw( $fields )
			->toBase()
			->get();

		return $result;
	}

	public function getAllWithPaginate($perPage = null)
	{
		//нужные поля
		$columns = ['id', 'title', 'parent_id'];

		$result = $this
			->startConditions()
			->select( $columns )
			->paginate( $perPage );

		return $result;
	}

}
