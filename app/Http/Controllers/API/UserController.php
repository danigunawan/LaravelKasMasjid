<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Controllers\Controller;
use App\Events\AppEvent;
use Validator;

class UserController extends Controller
{
    public function login(Request $request)
		{
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
				{ 
            $user = Auth::user();
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['access_token'] = $user->createToken('MyApp')->accessToken; 
            return response()->json($success, 200); 
        } 
        else
        { 
            return response()->json(['error' => 'Unauthorised'], 401); 
        } 
    }

    public function post(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|unique:Users,email|email',
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()], 401);
        
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $datas = User::create($input);
				
				event(new AppEvent('ADD_USER', ['data' => $datas]));
        return response()->json($datas, 200); 
    }
		
		public function delete($id)
		{
				User::where('id', $id)->delete();
				event(new AppEvent('DELETE_USER', ['id' => (int)$id]));
				return response()->json(['message' => ''], 200);
		}

		public function getAll()
		{
				$datas = User::all();
				return response()->json($datas, 200); 
		}
}
