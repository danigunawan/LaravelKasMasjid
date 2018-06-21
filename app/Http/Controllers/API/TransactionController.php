<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;
use App\Events\AppEvent;

class TransactionController extends Controller
{
    public function getById($id)
    {
        $datas = Transaction::where('id', $id)->first();
        return response()->json($datas, 200);
    }
    
    public function post(Request $request)
    {
        $trans = new Transaction();
        $trans->description = $request->description;
        $trans->amount = $request->amount;
        $trans->date = $request->date;
				$trans->category_id = $request->category_id;
        if($trans->save())
				{
						$datas = Transaction::where('id', $trans->id)->first();
						event(new AppEvent('ADD_TRANS', ['data' => $datas]));
						return response()->json(['message' => ''], 200);
				}
    }
    
		public function delete($id)
		{
				Transaction::where('id', $id)->delete();
				event(new AppEvent('DELETE_TRANS', ['id' => (int)$id]));
				return response()->json(['message' => ''], 200);
		}
	
    public function putById(Request $request, $id)
    {
        Transaction::where('id', $id)->update(
					[
						'amount' => $request->amount,
						'description' => $request->description,
						'date' => $request->date,
						'category_id' => $request->category_id
					]
				);
				$datas = Transaction::where('id', $id)->first();
				event(new AppEvent('UPDATE_TRANS', ['id' => (int)$id, 'data' => $datas]));
        return response()->json(['message' => ''], 200);
    }
    
    public function getAll()
    {
        $datas = Transaction::orderBy('date', 'DESC')->get();
        return response()->json($datas, 200);
    }
}
