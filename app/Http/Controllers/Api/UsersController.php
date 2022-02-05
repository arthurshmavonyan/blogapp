<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Library\Image as Img;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function me() {
        $user = Auth::user();
        $user->load('image');

        return Auth::user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Img $imgHelp)
    {
        $data = $request->all();

        if($request->file('file')) {
            if($user->image) {
                $imgHelp->deleteImage($user->image->src);
                $user->image()->delete();
            }
            $avatar = new Image;
            $avatar->src = $imgHelp->storeUserImage($request->file('file'));
            $avatar->imageable_id = $user->id;
            $avatar->imageable_type = 'App\User';
            $avatar->save();
        }
        $user->save();
    }

    public function deleteAvatar (User $user, Img $imgHelp) {
        $imgHelp->deleteImage($user->image->src);
        $user->image()->delete();
    }
}
