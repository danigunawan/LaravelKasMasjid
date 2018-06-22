<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Events\AppEvent;

class CategoriesController extends Controller
{
    public function putById(Request $request, $id)
    {
        $cat = Categories::find($id);
        $cat->name = $request->name;
        $cat->type = $request->type;
        if($cat->save())
        {
            event(new AppEvent('UPDATE_CATEGORY', ['id' => (int)$id, 'data' => $cat]));
            return response()->json($cat, 200);
        }
    }

    public function post(Request $request)
    {
        $cat = new Categories();
        $cat->name = $request->name;
        $cat->type = $request->type;
        if($cat->save())
        {
            event(new AppEvent('ADD_CATEGORY', ['data' => $cat]));
            return response()->json(['message' => ''], 200);
        }
    }

    public function getAll()
    {
        $cat = Categories::all();
        return response()->json($cat, 200);
    }
}
