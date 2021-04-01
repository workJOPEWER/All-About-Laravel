<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Carbon;

class BlogPostObserver
{
	/**
	 *  обработка ПЕРЕД созданием записи
	 *
	 * @param  \App\Models\BlogPost $blogPost
	 * @return void
	 */
	public function creating(BlogPost $blogPost)
	{
		$this->setPublishedAt( $blogPost );

		$this->setSlug( $blogPost );

		$this->setHtml( $blogPost );

		$this->setUser( $blogPost );
	}

	/**
	 * Обработка ПЕРЕД обновлением записи
	 *
	 * @param  \App\Models\BlogPost $blogPost
	 * @return void
	 */
	public function updating(BlogPost $blogPost)
	{
		/*$test[] = $blogPost->isDirty(); //isDirty -тру/фолс
		$test[] = $blogPost->isDirty( 'is_published' ); //
		$test[] = $blogPost->isDirty( 'user_id' ); //
		$test[] = $blogPost->isDirty();
		$test[] = $blogPost->getAttribute( 'is_published' );
		$test[] = $blogPost->is_published;
		$test[] = $blogPost->getOriginal( 'is_published' );//узнаем что было до ..
		dd( $test );*/

		$this->setPublishedAt( $blogPost );

		$this->setSlug( $blogPost );
	}

	/**
	 * Если дата публикации не установлена и происходит установка флага -Опубликовано,
	 * то устанавливаем дату на текущий момент.
	 *
	 * @param BlogPost $blogPost
	 */

	protected function setPublishedAt(BlogPost $blogPost)
	{
		$needSetPublished = empty( $blogPost->published_at ) && $blogPost->is_published;

		if ($needSetPublished) {
			$blogPost->published_at = Carbon::now();
		}
	}

	/**
	 * если поле пустое, то заполняем его конвертацией заговка
	 * @param BlogPost $blogPost
	 */

	protected function setSlug(BlogPost $blogPost)
	{
		if (empty( $blogPost->slug )) {
			$blogPost->slug = \Str::slug( $blogPost->title );
		}
	}


	/**
	 * Установка значения полю content_html относительно поля content_raw
	 *
	 * @param BlogPost $blogPost
	 */
	protected function setHtml(BlogPost $blogPost)
	{
		if ($blogPost->isDirty( 'content_raw' )) {
			//TODO: тут должна быть генирация markdown -> html
			$blogPost->content_html = $blogPost->content_raw;
		}
	}


	/**
	 * Если не указан user_id, то устанавливаем пользователя по-умолчания
	 *
	 * @param BlogPost $blogPost
	 */
	protected function setUser(BlogPost $blogPost)
	{
		$blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
	}

	/**
	 * Handle the BlogPost "deleted" event.
	 *
	 * @param  \App\Models\BlogPost $blogPost
	 * @return void
	 */
	public function deleting(BlogPost $blogPost)
	{
		//
	}

	/**
	 * Handle the BlogPost "deleted" event.
	 *
	 * @param  \App\Models\BlogPost $blogPost
	 * @return void
	 */
	public function deleted(BlogPost $blogPost)
	{
		//
	}

	/**
	 * Handle the BlogPost "restored" event.
	 *
	 * @param  \App\Models\BlogPost $blogPost
	 * @return void
	 */
	public function restored(BlogPost $blogPost)
	{
		//
	}

	/**
	 * Handle the BlogPost "force deleted" event.
	 *
	 * @param  \App\Models\BlogPost $blogPost
	 * @return void
	 */
	public function forceDeleted(BlogPost $blogPost)
	{
		//
	}
}
