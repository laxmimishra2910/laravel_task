<?php
namespace App\Relationships;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class HasOneThroughPivot extends Relation
{
    protected $pivotTable;
    protected $foreignPivotKey;
    protected $relatedPivotKey;

    public function __construct(Builder $query, Model $parent, $pivotTable, $foreignPivotKey, $relatedPivotKey)
    {
        $this->pivotTable = $pivotTable;
        $this->foreignPivotKey = $foreignPivotKey;
        $this->relatedPivotKey = $relatedPivotKey;

        parent::__construct($query, $parent);
    }

    public function addConstraints()
    {
        $this->query
            ->join($this->pivotTable, $this->pivotTable.'.'.$this->relatedPivotKey, '=', $this->related->getTable().'.id')
            ->where($this->pivotTable.'.'.$this->foreignPivotKey, '=', $this->parent->getKey());
    }

    public function addEagerConstraints(array $models)
    {
        $this->query->whereIn(
            $this->pivotTable.'.'.$this->foreignPivotKey,
            collect($models)->pluck($this->parent->getKeyName())
        );
    }

    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, null);
        }

        return $models;
    }

    public function match(array $models, Collection $results, $relation)
    {
        $dictionary = [];

        foreach ($results as $result) {
            $dictionary[$result->pivot->{$this->foreignPivotKey}] = $result;
        }

        foreach ($models as $model) {
            if (isset($dictionary[$model->getKey()])) {
                $model->setRelation($relation, $dictionary[$model->getKey()]);
            }
        }

        return $models;
    }

    public function getResults()
    {
        return $this->query->first();
    }
}