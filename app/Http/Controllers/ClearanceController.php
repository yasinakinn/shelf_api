<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clearance;

use Validator;
use Illuminate\Support\Facades\Auth;

class ClearanceController extends Controller
{
    // Get all clearances
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $clearances = Clearance::all();
            return response()->json($clearances, 200);
        }else{
            return 'No users found';
        }
    }

    // Add a clearance
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'code' => 'required',
            'title' => 'required',
            'permission' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $clearance = Clearance::create($request);
            return response()->json($clearance, 201);
        }else{
            return 'No users found';
        }

    }

    // Update a clearance
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $clearance = Clearance::where('id', $request['id'])->first();
            $clearance->title = isset($request['title']) ? $request['title'] : $clearance->title;
            $clearance->code = isset($request['code']) ? $request['code'] : $clearance->code;
            $clearance->permission = isset($request['permission']) ? $request['permission'] : $clearance->permission;
            $clearance->save();
            return response()->json($clearance, 200);
        }else{
            return 'No users found';
        }
    }

    // Delete a clearance
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $clearance = Clearance::where('id', $request['id'])->first();
            $clearance->delete();
            return response()->json($clearance, 200);
        }else{
            return 'No users found';
        }
    }

    // Get a clearance
    public static function getClearance($id)
    {
        $clearance = Clearance::where('id', $id)->first();
        return $clearance;
    }
}
