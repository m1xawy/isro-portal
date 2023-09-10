<?php

namespace Laravel\Nova\Fields\Repeater;

use Illuminate\Support\Collection;

class RepeatableCollection extends Collection
{
    /**
     * Find a Repeatable class by its key.
     *
     * @param  string  $key
     * @return \Laravel\Nova\Fields\Repeater\Repeatable
     */
    public function findByKey($key)
    {
        return $this->first(function ($item) use ($key) {
            return $item->key() === $key;
        });
    }

    /**
     * Return a new instance of a Repeatable by its key.
     *
     * @param  string  $key
     * @param  array  $data
     * @return \Laravel\Nova\Fields\Repeater\Repeatable
     */
    public function newRepeatableByKey($key, $data = [])
    {
        $block = $this->findByKey($key);

        return new $block($data);
    }

    /**
     * Return the first Repeatable by its model class.
     *
     * @param  class-string  $class
     * @return \Closure|mixed|null
     */
    public function findByModelClass($class)
    {
        return $this->first(function ($item) use ($class) {
            return $item::$model === $class;
        });
    }

    /**
     * Return a new instance of a Repeatable by its model class.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Laravel\Nova\Fields\Repeater\Repeatable
     */
    public function newRepeatableByModel($model)
    {
        $repeatable = $this->findByModelClass(get_class($model));

        return new $repeatable($model->toArray());
    }
}
