<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Type;
use App\Models\DishType;

class GameController extends Controller
{
    public function startGame()
    {
        session()->flush();
        session()->put('typeIdsYes', []);
        session()->put('typeIdsNo', []);

        return $this->composeTypeQuestion(1);
    }

    public function answer(Request $request)
    {
        $typeId = trim($request->get('type_id'));
        $dishId = trim($request->get('dish_id'));
        $answer = trim($request->get('answer'));

        if (!empty($typeId)) {
            
            return $this->getNewQuestion($typeId, $answer);
            
        } elseif (!empty($dishId)) {
            
            return $this->composeResultGuess($dishId, $answer);

        }
    }

    protected function getNewQuestion($typeId, $answer)
    {
        if ($answer == 'yes') {
            session()->push('typeIdsYes', (int) $typeId);
        } else {
            session()->push('typeIdsNo', (int) $typeId);
        }

        $typeIdsYes = session('typeIdsYes', []);
        $typeIdsNo = session('typeIdsNo', []);

        $dishTypeModel = new DishType();
        $nextType = $dishTypeModel->getNextTypeQuestion($typeIdsYes, $typeIdsNo);

        if ($nextType) {
            return $this->composeTypeQuestion($nextType->type_id);
        } else {
            $dishModel = new Dish();
            $dishGuess = $dishModel->getGuess($typeIdsYes, $typeIdsNo);
            return $this->composeGuess($dishGuess);
        }
    }

    public function newDish(Request $request)
    {
        $dishModel = new Dish();
        $typeModel = new Type();
        $dishTypeModel = new DishType();
        $dish = $type = '';
        $typeIdsYes = [];

        $newNameDish = trim($request->get('new_dish'));
        if($newNameDish) {
            $dish = $dishModel->where('name', $newNameDish)->first();
            if(!$dish){
                $dish = $dishModel->create(['name' => $newNameDish, 'defeats' => 1, 'qty_played' => 1]);
            } else {
                $dish->increment('qty_played');
                $dish->increment('defeats');
            }
        }

        $newNameType = trim($request->get('difference'));
        if ($newNameType) {
            $type = $typeModel->where('name', $newNameType)->first();
            if (!$type) {
                $type = $typeModel->create(['name' => $newNameType]);
            }
        }

        session()->push('typeIdsYes', $type->id);
        $typeIdsYes = array_unique( session('typeIdsYes', []) );

        foreach ($typeIdsYes as $typeId) {
            $dishTypeModel->create([
                'dish_id' => $dish->id,
                'type_id' => $typeId,
            ]);
        }

        return ['ids' => $typeIdsYes, 'finished' => 'yes'];
    }

    protected function writeResponse($name, $typeId, $dishId = "", $dishName = "")
    {
        return [
            'message' => 'O prato que você pensou é ' . $name . '?',
            'typeId' => $typeId,
            'dishId' => $dishId,
            'dishName' => $dishName,
            'answered' => session('typeIdsYes', [])
        ];
    }

    protected function composeGuess($dishObj)
    {
        return $this->writeResponse($dishObj->name, "", $dishObj->id, $dishObj->name);
    }

    protected function composeTypeQuestion($typeId)
    {
        $typeModel = new Type();
        $type = $typeModel->findOrFail($typeId);

        return $this->writeResponse($type->name, $type->id, "");
    }

    protected function composeResultGuess($dishId, $answer)
    {
        $dishModel = new Dish();
        $dish = $dishModel->findOrFail($dishId);
        $dish->increment('qty_played');

        if ($answer == 'yes') {
            $dish->increment('victories');
            return [
                'gameResult' => 'win',
                'dishName' => $dish->name,
                'qtyPlayed' => $dish->qty_played,
                'answered' => session('typeIdsYes', [])
            ];
        } else {
            $dish->increment('defeats');
            return [
                'gameResult' => 'lose',
                'dishName' => $dish->name,
                'qtyPlayed' => $dish->qty_played,
                'answered' => session('typeIdsYes', [])
            ];
        }
    }
}
