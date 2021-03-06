<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *Class BlogCategory
 *
 * @package App\Models
 *
 * @property-read BlogCategory $parentCategory
 * @property-read string $parentTitle
 */
class BlogCategory extends Model
{
	use HasFactory;
	use SoftDeletes;

	/**
	 * id корня
	 */
	const ROOT = 1;

	protected $fillable
		= [
			'title',
			'slug',
			'parent_id',
			'description',
		];

	/**
	 * Получить родительскую категорию
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 * @return BlogCategory
	 *
	 */

	public function parentCategory()
	{
		return $this->belongsTo( BlogCategory::class, 'parent_id', 'id' );
	}

	/**
	 * Пример аксесуара (Accessor)
	 *
	 * @url https://laravel.com/docs/8.x/eloquent-mutators
	 *
	 * @return string
	 *
	 */

	public function getParentTitleAttribute()
	{
		$title = $this->parentCategory->title
			?? ($this->isRoot()
				? 'Корень'
				: '???'); // выаодить ошибки

		return $title;
	}

	/**
	 *
	 * является ли текущий объект корневым
	 *
	 * @return bool
	 *
	 */

	public function isRoot()
	{
		return $this->id === BlogCategory::ROOT;
	}

	/**
	 *
	 * Пример аксессора
	 *
	 * @param $valueFromObject
	 * @return bool|mixed|null|string|string[]
	 */
	public function getTitleAttribute($valueFromObject)
	{
		return mb_strtoupper( $valueFromObject );
	}

	/**
	 *
	 * Пример мутатора
	 *
	 * @param  string $incomingValue
	 *
	 */

	public function setTitleAttribute($incomingValue)
	{
		$this->attributes['title'] = mb_strtolower( $incomingValue );
	}

}
