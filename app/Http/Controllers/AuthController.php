<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClearanceController;
use Illuminate\Http\Request;
use Validator;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends Controller
{
    public function index()
    {

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if ($validator->fails()) {
            return array(
                'status' => 'error',
                'error' => $validator->errors()
            );
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $clearance = ClearanceController::getClearance($user->clearance);
            $user->title = $clearance->title;
            $user->permission = $clearance->permission;
            $user->code = $clearance->code;
            $user->clearance = $clearance->id;
            return array(
                'status' => 'success',
                'user' => $user
            );
        }else{
            return array(
                'status' => 'error',
                'error' => 'Email or password is incorrect'
            );
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'clearance' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();
        $added = User::addUser($data);

        return $added;
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $deleted = User::where('email', $data['email'])->delete();

            if($deleted){
                return 'User deleted';
            }else{
                return 'No users found';
            }
        }else{
            return 'Email or password is incorrect';
        }

    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'new_password' => 'required|min:6',
            
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $updated = User::where('email', $data['email'])->update(['password' => Hash::make($data['new_password']), 'updated_at' => now()]);

            if($updated){
                return 'Password updated';
            }else{
                return 'No users found';
            }
        }else{
            return 'Email or password is incorrect';
        }
        
    }

    // update user name
    public function updateName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'new_name' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $updated = User::where('email', $data['email'])->update(['name' => $data['new_name'], 'updated_at' => now()]);

            if($updated){
                return 'Name updated';
            }else{
                return 'No users found';
            }
        }else{
            return 'Email or password is incorrect';
        }
        
    }

    // update user clearance
    public function updateClearance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'new_clearance' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $updated = User::where('email', $data['email'])->update(['clearance' => $data['new_clearance'], 'updated_at' => now()]);

            if($updated){
                return 'Clearance updated';
            }else{
                return 'No users found';
            }
        }else{
            return 'Email or password is incorrect';
        }
        
    }

    //Get users by clearance

    public function getUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'clearance_code' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(str_contains($data['clearance_code'], 'A')){
                //get users by clearance code with inner join
                $users = User::select('*')
                ->join('clearances', 'users.clearance', '=', 'clearances.id')
                ->select('users.*', 'clearances.title', 'clearances.permission', 'clearances.code')
                ->get();
            }else{
                //get users by clearance code with inner join
                $users = User::select('*')
                ->join('clearances', 'users.clearance', '=', 'clearances.id')
                ->select('users.*', 'clearances.title', 'clearances.permission', 'clearances.code')
                ->where('clearances.code', 'like', substr($data['clearance_code'], 0, 1).'%')
                ->get();
                
            }
            if($users){
                return $users;
            }else{
                return 'No users found';
            }
        }else{
            return 'Email or password is incorrect';
        }
        
    }
}
