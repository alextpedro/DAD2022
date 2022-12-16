<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:c,ec,ed,em', 
            'name' => 'required|string|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:3|confirmed',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,bmp',
        ]);
        $user = new User();

        if($request->has('photo_url')) {
            $photo_name = Str::uuid() . '.' . $request->photo_url->getClientOriginalExtension();
            $targetDir = storage_path("app/public/fotos");
            $request->photo_url->move($targetDir, $photo_name);
            $user->photo_url = $photo_name;
        }

        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();       

        return response()->json(new UserResource($user), 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function update_password(UpdateUserPasswordRequest $request, User $user)
    {
        $user->password = bcrypt($request->validated()['password']);
        $user->save();
        return new UserResource($user);
    }

    public function show_me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
