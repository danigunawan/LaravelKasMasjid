<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Transactions;
use Carbon\Carbon;
use App\Events\AppEvent;

class TransactionsController extends Controller
{
    public function post(Request $request)
    {
        $trans = new Transactions();
        $trans->description = $request->description;
        $trans->value = $request->value;
        $trans->date = $request->date;
        $trans->categories_id = $request->categories_id;
        $trans->users_id = Auth::user()->id;
        if($trans->save())
        {
            event(new AppEvent('ADD_TRANS', ['data' => $trans]));
            return response()->json(['message' => ''], 200);
        }
    }

    public function delete($id)
    {
        Transactions::find($id)->delete();
        event(new AppEvent('DELETE_TRANS', ['id' => (int)$id]));
        return response()->json(['message' => ''], 200);
    }

    public function putById(Request $request, $id)
    {
        $trans = Transactions::find($id);
        $trans->description = $request->description;
        $trans->value = $request->value;
        $trans->date = $request->date;
        $trans->categories_id = $request->categories_id;
        if($trans->save())
        {
            event(new AppEvent('UPDATE_TRANS', ['data' => [0 => $trans]]));
            return response()->json(['message' => ''], 200);
        }
    }

    public function getAll()
    {
        $trans = Transactions::orderBy('date', 'DESC')->get();
        return response()->json($trans, 200);
    }
}
