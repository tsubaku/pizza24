<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * @param Category $category
     */
    public function creating(Category $category)
    {
        $this->setSlug($category);
    }

    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        //
    }


    /**
     * @param Category $category
     */
    public function updating(Category $category)
    {
        $this->setSlug($category);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }


    /**
     * If the slug field is empty, then fill it with header conversion
     *
     * @param Category $category
     */
    protected function setSlug(Category $category)
    {
        if (empty($category->slug)) {
            $category->slug = \Str::slug($category->title);
        }
    }

}
