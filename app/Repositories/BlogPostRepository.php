<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;

/**
 * Class BlogPostRepository.
 *
 * @package App\Repositories
 */
class BlogPostRepository extends CoreRepository
{
	/**
	 * @return string
	 *  Return the model
	 */
	protected function getModelClass()
	{
		return Model::class;
	}


	/**
	 * Получить список статей для вывода в списке
	 * (Админка)
	 * @return LengthAwarePaginator
	 *
	 */
	public function getAllWithPaginate()
	{
		$columns = [
			'id',
			'title',
			'slug',
			'is_published',
			'published_at',
			'user_id',
			'category_id',
		];

		$result = $this->startConditions()
						->select( $columns )
						->orderBy('id', 'DESC')
						->paginate( 25 );

		return $result;
	}
}
