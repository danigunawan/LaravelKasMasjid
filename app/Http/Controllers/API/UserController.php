<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Roles;
use App\Transactions;
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
            $success['role'] = $user->roles;
            $success['access_token'] = $user->createToken('MyApp')->accessToken;
            return response()->json($success, 200);
        }
        else
        {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function putById(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if($user->save())
        {
            event(new AppEvent('UPDATE_USER', ['data' => [0 => $user]]));
            return response()->json(['message' => ''], 200);
        }
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required'
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()], 401);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        event(new AppEvent('ADD_USER', ['data' => $user]));
        return response()->json(['message' => ''], 200);
    }

    public function delete($id)
    {
        User::find($id)->delete();
        event(new AppEvent('DELETE_USER', ['id' => (int)$id]));
        $trans = Transactions::where('users_id', $id);
        event(new AppEvent('UPDATE_TRANS', ['data' => $trans]));
        return response()->json(['message' => ''], 200);
    }

    public function getAll()
    {
        $user = User::all();
        return response()->json($user, 200);
    }
}
