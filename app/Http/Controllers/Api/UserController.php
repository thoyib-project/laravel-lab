<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User::orderBy('created_at','desc')->paginate(10);
            return response()->json(["status" => 200, "data" => ($data)]);
        } catch (\Throwable $th) {
            return response()->json(["status" => $th->getCode(), "data" => $th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $req)
    {
        try {
            $data = User::create($req->all());
            return response()->json(["status" => 200, "data" => ($data)]);
        } catch (\Throwable $th) {
            return response()->json(["status" => $th->getCode(), "data" => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = User::where('id',$id)->get();
            return response()->json(["status" => 200, "data" => ($data)]);
        } catch (\Throwable $th) {
            return response()->json(["status" => $th->getCode(), "data" => $th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $req, string $id)
    {
        try {
            // dd($user);
            $data = User::find($id);
            $data->update($req->all());
            return response()->json(["status" => 200, "data" => ($data)]);
        } catch (\Throwable $th) {
            return response()->json(["status" => $th->getCode(), "data" => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // dd('im here');
            User::where('id',$id)->delete();
            return response()->json(["status" => 200, "data" => "Data {$id} has been delete"]);
        } catch (\Throwable $th) {
            return response()->json(["status" => $th->getCode(), "data" => $th->getMessage()]);
        }
    }
}
