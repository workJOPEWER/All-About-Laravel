<?php

namespace App\Observers;

use App\Models\BlogCategory;

class BlogCategoryObserver
{
    /**
     * Handle the BlogCategory "created" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function created(BlogCategory $blogCategory)
    {
        //запись создана
    }


	/**
	 * Handle the BlogCategory "created" event.
	 *
	 * @param  BlogCategory  $blogCategory
	 * @return void
	 */
	public function creating(BlogCategory $blogCategory)
	{
		$this->setSlug($blogCategory);
	}

	/**
	 * если поле пустое, то заполняем его конвертацией заговка
	 *
	 * @param  \App\Models\BlogCategory  $blogCategory
	 * @return void
	 */
	protected function setSlug(BlogCategory $blogCategory)
	{
		if(empty($blogCategory->slug)) {
			$blogCategory->slug = \Str::slug($blogCategory->title);
		}
	}

    /**
     * Handle the BlogCategory "updated" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function updated(BlogCategory $blogCategory)
    {
        //
    }

    /***
	 * @param BlogCategory$blogCategory
    */
    public function updating(BlogCategory $blogCategory)
    {
        $this->setSlug($blogCategory);
    }

    /**
     * Handle the BlogCategory "deleted" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function deleted(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Handle the BlogCategory "restored" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function restored(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Handle the BlogCategory "force deleted" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function forceDeleted(BlogCategory $blogCategory)
    {
        //
    }
}
