<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Events\AppEvent;

class CategoryController extends Controller
{
    public function putById(Request $request, $id)
    {
        Category::where('id', $id)->update(
					[
						'name' => $request->name,
						'type' => $request->type
					]
				);
				$datas = Category::where('id', $id)->first();
				event(new AppEvent('UPDATE_CATEGORY', ['data' => $datas]));
        return response()->json($datas, 200);
    }
		
    public function post(Request $request)
    {
        $cat = new Category();
        $cat->name = $request->name;
        $cat->type = $request->type;
        if($cat->save())
				{
					$datas = Category::where('id', $cat->id)->first();
					event(new AppEvent('ADD_CATEGORY', ['data' => $datas]));
					return response()->json(['message' => ''], 200);
				}
    }
		
    public function getAll()
	{
		$datas = Category::all();
		return response()->json($datas, 200);
	}
}
