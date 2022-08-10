<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function users(){
        // $all_users = User::where('id','!=', Auth::id())->get();
        $all_users = User::paginate(3);
        $total_user = user::count();
        return view('admin.users.index', compact('all_users','total_user'));
    }
    function delete($user_id){
        user::find($user_id)->delete();
        return back();
    }
    function profile(){
        return view('admin.users.profile');
    }
    function profile_update(Request $request){
        $profile_photo = $request->photo;
        if(Auth::user()->photo != null){
            $prev_photo = public_path('uploads/user/profile/'.Auth::user()->photo);
            unlink($prev_photo);

            $extension = $profile_photo->getClientOriginalExtension();
            $file_name = Auth::id().'.'.$extension;

            Image::make($profile_photo)->resize(300,250)->save(public_path('uploads/user/profile/'.$file_name));

            User::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back();
        }
        else{
            $extension = $profile_photo->getClientOriginalExtension();
            $file_name = Auth::id() . '.' . $extension;

            Image::make($profile_photo)->resize(300, 250)->save(public_path('uploads/user/profile/' . $file_name));

            User::find(Auth::id())->update([
                'photo' => $file_name,
            ]);
            return back();
        }
    }
}
