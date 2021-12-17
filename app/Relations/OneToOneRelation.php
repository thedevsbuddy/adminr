<?php

namespace App\Relations;


class OneToOneRelation
{
    protected $relations;

    public function __construct()
    {
        $this->relations = collect();//AdminrRelations::where('type', 'one-to-one')->get();
//        $this->relations->filter(function ($relation) {
//            return $relation->type == 'oneToOne';
//        });
    }

    public function render(): void
    {
        if (count($this->relations)) {
            foreach ($this->relations as $relation) {
                ${$relation->model}::resolveRelationUsing($relation->with, function ($model) use ($relation) {
                    return $model->hasOne($relation->related);
                });

                ${$relation->related}::resolveRelationUsing($relation->via, function ($model) use ($relation) {
                    return $model->belongsTo($relation->model);
                });
            }
        }
    }
}
