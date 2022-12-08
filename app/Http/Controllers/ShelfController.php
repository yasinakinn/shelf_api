<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Shelf;
class ShelfController extends Controller
{
    // Get all shelves
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
            $shelves = Shelf::all();
            return response()->json($shelves, 200);
        }else{
            return 'No users found';
        }
    }

    // Add a shelf
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'type' => 'required',
            'number' => 'required|unique:shelves',
            'qty' => 'required'
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $shelf = Shelf::create($request);
            return response()->json($shelf, 201);
        }else{
            return 'No users found';
        }

    }

    // Update a shelf
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'number' => 'required',
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $shelf = Shelf::where('number', $request['number'])->first();
            $shelf->name = isset($request['name']) ? $request['name'] : $shelf->name;
            $shelf->type = isset($request['type']) ? $request['type'] : $shelf->type;
            $shelf->qty = isset($request['qty']) ? $request['qty'] : $shelf->qty;
            $shelf->save();
            return response()->json($shelf, 201);
        }else{
            return 'No users found';
        }
    }

    // Delete a shelf
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'number' => 'required',
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $shelf = Shelf::where('number', $request['number'])->first();
            $shelf->delete();
            return response()->json($shelf, 201);
        }else{
            return 'No users found';
        }
    }

    // Get a shelf
    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }
        $shelf = Shelf::where('number', $request['number'])->first();
        return response()->json($shelf, 201);
    }

    // Get a shelf by name like
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }
        $credentials = $request->only('email', 'password');
        $request = $request->except('email', 'password');
        if (Auth::attempt($credentials)) {
            $shelf = Shelf::where('name', 'like', '%'.$request['name'].'%')->get();
            return response()->json($shelf, 201);
        }else{
            return 'No users found';
        }
    }
}
