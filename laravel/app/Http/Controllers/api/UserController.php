<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function uploadFile (Request $request) {
        if($request->file()) {
            $fileName = time().'_'.$request->file->hashName();
            $filePath = Storage::putFile('public/products/', $request->file('file'));
            $storageName = basename($filePath);
        }

        return $storageName;
    }

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
            'type' => 'required|in:C,EC,ED,EM', 
            'name' => 'required|string|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:3|confirmed',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,bmp',
        ]);

        if($request->file()) {
            $storageName = $this->uploadFile($request);
        }

        $user = new User([
            "name"=>$request->get('name'),
            "type"=>$request->get('type'),
            "email"=>$request->get('email'), 
            "photo_url"=>$storageName,
		]);

        
        $user->password = Hash::make($request->get('password'));
        $user->save();       

        return response()->json(['message' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:C,EC,ED,EM', 
            'name' => 'required|string|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email',
            'password' => 'nullable|min:3|confirmed',
            'photo_url' => 'nullable|string|max:255',
         ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->type = $request->input('type');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->get('password'));

        $requestPhotoUrl = $request->input('photo_url');
        $currentUserPhotoUrl = $user->photo_url;

        if ($requestPhotoUrl != $currentUserPhotoUrl) {
            if($request->file()) {
                $request->validate([
                    'file' => 'required|mimes:jpg,jpeg,png|max:2048',
                ]);
                $storageName = $this->uploadFile($request);
                $product->photo_url = $storageName;
            }
        }
        else {
            $user->photo_url = $request->input('photo_url');
        }

        
        $user->save();
    }

    public function update_password(Request $request, $id)
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
