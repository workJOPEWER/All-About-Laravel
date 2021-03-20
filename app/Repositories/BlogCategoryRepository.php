<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Support\Collection;

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
		return $this->startConditions()->all();
	}

}
