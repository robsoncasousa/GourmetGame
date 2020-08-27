<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishType extends Model
{
    protected $fillable = ['type_id', 'dish_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function types()
    {
        return $this->hasMany('App\Models\Type');
    }

    public function dishes()
    {
        return $this->hasMany('App\Models\Dish');
    }

    public function getNextTypeQuestion($typeIdsYes, $typeIdsNo)
    {
        $query = $this->select('type_id');
        
        if(count($typeIdsYes))
        {
            $query->whereNotIn('type_id', $typeIdsYes)
            ->whereIn('dish_id', function($queryIn) use ($typeIdsYes){
                $queryIn->select('dish_id')
                    ->from('dish_types')
                    ->whereIn('type_id', $typeIdsYes)
                    ->groupBy('dish_id')
                    ->havingRaw('COUNT(dish_id) = ?', [count($typeIdsYes)]);
            });
        }
        if (count($typeIdsNo))
        {
            $query->whereNotIn('dish_id', function ($queryIn) use ($typeIdsNo) {
                    $queryIn->select('dishes.id')
                        ->from('dishes')
                        ->join('dish_types', 'dishes.id', '=', 'dish_types.dish_id')
                        ->whereIn('dish_types.type_id', $typeIdsNo)
                        ->groupBy('dishes.id');
                });
        }
        $query->groupBy('type_id');
        return $query->first();
        // return $query->toSql();
    }
}
