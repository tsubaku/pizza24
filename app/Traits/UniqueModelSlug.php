<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait UniqueModelSlug
 * @package App\Traits
 */
trait UniqueModelSlug
{
    private $slugMaxLength = 50;

    private $slugKeyName = 'slug';

    /**
     * @param string|Model $model
     * @param string $slug
     *
     * @return string
     */
    public function generateSlug($model, $slug)
    {
        $model = $model instanceof Model ? $model->where($model->getKeyName(), '!=', $model->getKey()) : new $model;
        $slug = Str::limit(Str::slug($slug), $this->slugMaxLength, '');

        // Если слаг не существует - возвращаем исходную строку
        if(!$model->where($this->slugKeyName, $slug)->exists()) {
            return $slug;
        }
dd($slug);
        // Удаляем число в начале строки
        $slug = preg_replace('/^(\d+)-(\w+)$/', '$2', $slug);

        // Ищем в базе совпадения
        $similarModels = $model->whereRaw("`$this->slugKeyName` REGEXP ?", '^[[:digit:]]+-'.Str::limit($slug, intval($this->slugMaxLength / 2)))->pluck($this->slugKeyName);

        // не находим - возвращаем слаг с номером 1
        // иначе - номер перед слагом + 1
        if($similarModels->isEmpty()) {
            return Str::limit("1-$slug", $this->slugMaxLength, '');
        }

        $lastSlugNumModel = 0;

        foreach($similarModels as $i) {
            $num = preg_replace('/^(\d+)-(.+)$/', '$1', $i);

            if($num > $lastSlugNumModel) {
                $lastSlugNumModel = $num;
            }
        }

        $lastSlugNum = $lastSlugNumModel + 1;

        return Str::limit("$lastSlugNum-$slug", $this->slugMaxLength, '');
    }

    /**
     * @param int $length
     * @return $this
     */
    public function setSlugMaxLength(int $length)
    {
        $this->slugMaxLength = $length;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setSlugKeyName(string $name)
    {
        $this->slugKeyName = $name;

        return $this;
    }
}
