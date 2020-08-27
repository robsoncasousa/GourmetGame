<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use SoftDeletes;
    
    protected $fillable = [ 'name', 'qty_played' ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function types()
    {
        return $this->belongsToMany('App\Models\Type');
    }

    public function getGuess($typeIdsYes, $typeIdsNo)
    {
        $query = $this->select('*');

        if (count($typeIdsYes)) {
            $query->whereIn('id', function ($queryIn) use ($typeIdsYes) {
                $queryIn->select('dish_id')
                ->from('dish_types')
                ->whereIn('type_id', $typeIdsYes)
                    ->groupBy('dish_id')
                    ->havingRaw('COUNT(dish_id) = ?', [count($typeIdsYes)]);
            });
        }
        if (count($typeIdsNo)) {
            $query->whereNotIn('id', function ($queryIn) use ($typeIdsNo) {
                $queryIn->select('dishes.id')
                ->from('dishes')
                ->join('dish_types', 'dishes.id', '=', 'dish_types.dish_id')
                ->whereIn('dish_types.type_id', $typeIdsNo)
                    ->groupBy('dishes.id');
            });
        }
        return $query->first();
    }

}
