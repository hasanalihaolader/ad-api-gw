<?php

namespace App\Repositories;

abstract class Repository
{
    /**
     * Define relevant Model.
     *
     * @return Model | Builder;
     */
    abstract public static function model();

    /**
     * Define relevant Model.
     *
     * @return Builder;
     */
    public static function query()
    {
        return static::model()::query();
    }

    /**
     * @return Collection;
     */
    public static function getAll()
    {
        return static::model()::all();
    }

    /**
     * @return first limit 1 Collection;
     */
    public static function first()
    {
        return static::model()::first();
    }

    /**
     * @param $primary_key
     * @return Collection;
     */
    public static function find($primary_key)
    {
        return static::model()::find($primary_key);
    }

    /**
     * @param $primary_key
     * @return bool;
     */
    public static function delete($primary_key)
    {
        return static::model()::destroy($primary_key);
    }

    /**
     * @param $data
     * @return bool;
     */
    public static function create(array $data)
    {
        return static::model()::create($data);
    }

    /**
     * @param $model, $data
     * @return bool;
     */
    public static function update($instance, array $data)
    {
        return $instance->update($data);
    }
}
