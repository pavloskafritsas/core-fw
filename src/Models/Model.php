<?php

namespace Pk\Core\Models;

use Pk\Core\Helpers\QueryBuilder;
use Pk\Core\InvalidCastTypeException\InvalidCastTypeException;

class Model
{
    protected static string $table;

    protected static string $key = 'id';

    public array $attributes = [];

    protected array $casts = [];

    public function __construct(?array $attributes = null)
    {
        if ($attributes) {
            $this->attributes = $attributes;
        }
    }

    /** 
     *Επιστροφή primary key του model
     * 
     * @return null|int|string
     */
    public function getKey()
    {
        return $this->attributes[static::$key];
    }

    /** 
     * Δημιουργία object query builder με συγκεκριμένες παραμέτρους
     * 
     * @return QueryBuilder
     */
    public static function query(): QueryBuilder
    {
        return new QueryBuilder(static::$table, static::class);
    }

    /**
     * Προσθήκη WHERE statement στον query builder του model
     */
    public static function where(string $column, string $operator, string $value)
    {
        return self::query()->where($column, $operator, $value);
    }

    /**
     * Προσθήκη WHERE statement στον query builder του model με operator "="
     * 
     * @param string $column
     * @param null|string $value
     * 
     * @return QueryBuilder
     */
    public static function whereEqual($column, $value): QueryBuilder
    {
        return self::query()->whereEqual($column, $value);
    }

    /**
     * ανεύρεση Model με συγκεκριμενο id
     * 
     * @param null|int|string $id
     */
    public static function find($id)
    {
        return self::query()->whereEqual(static::$key, $id)->first();
    }

    /**
     * Επιστροφή όλων των μοντέλων απο τη ΒΔ 
     */
    public static function all(array $columns = ['*']): array
    {
        return self::query()->get($columns);
    }

    /**
     * Αποθήκευση attributes στο model
     */
    public function fill(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Δημιουργία μοντέλου στη ΒΔ και επιστροφή
     * 
     * @return static
     */
    public static function create(array $attributes)
    {
        return self::find(
            self::query()->insert($attributes)
        );
    }

    /**
     * Διαγραφή μοντέλου με συγκεκριμένο id απο τη ΒΔ
     * 
     * @return bool
     */
    public function delete()
    {
        return self::query()->whereEqual('id', $this->id)->delete();
    }

    /**
     * Προβολή μοντέλου σε μορφή array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Υλοποιηση μαγικής μεθόδου __get
     */
    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Υλοποιηση μαγικής μεθόδου __set
     */
    public function __set($name, $value)
    {
        $cast = $this->casts[$name] ?? null;

        if ($cast) {
            if (
                in_array(
                    $cast,
                    [
                        'array',
                        'bool',
                        'boolean',
                        'float',
                        'int',
                        'integer',
                        'null',
                        'object',
                        'string',
                    ],
                    true
                )
            ) {
                settype($value, $cast);
            } else if (class_exists($cast)) {
                $value = new $cast($value);
            } else {
                throw new InvalidCastTypeException($cast);
            }
        }

        $this->attributes[$name] = $value;
    }

    /**
     * Δήλωση συσχέτισης μεταξύ 2 μοντέλων (ένα προς πολλά)
     *  
     * @return null|object
     */
    protected function hasOne(string $model, string $localId)
    {
        return (new $model)->whereEqual($localId, $this->getKey())->first();
    }

    /**
     * Δήλωση συσχέτισης μεταξύ 2 μοντέλων (πολλά προς πολλά)
     * 
     * @param string $model
     * @param string $localId
     * 
     * @return array<null|object>
     */
    protected function hasMany(string $model, string $localId)
    {
        return (new $model)->whereEqual($localId, $this->getKey())->get();
    }

    /**
     * Δήλωση συσχέτισης μεταξύ 2 μοντέλων (το μοντέλο ανήκει σε άλλο μοντέλο)
     * 
     * @param string $model
     * @param string $localId
     * 
     * @return null|object
     */
    protected function belongsTo($model, $relationId)
    {
        return (new $model)->find($this->attributes[$relationId]);
    }
}
