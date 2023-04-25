<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\DetailUser;
use Illuminate\Http\Request;
use App\Models\ExperienceUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\File;
use App\Http\Requests\Dashbaord\Profile\UpdateProfileRequest;
use App\Http\Requests\Dashbaord\Profile\UpdateDetailUserRequest;
use Illuminate\Filesystem\Filesystem;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::where('id', Auth::user()->id )->first();
        $experienceUser = ExperienceUser::where('detail_user_id', $user->detail_user->id)->orderBy('id', 'asc')->get();

        return view('pages.Dashboard.profile', compact('user', 'experienceUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $reqest_profile, UpdateDetailUserRequest $request_detail_user)
    {
        $data_profile = $reqest_profile->all();
        $data_detail_user = $request_detail_user->all();

        // get photo user
        $get_photo = DetailUser::where('users_id', Auth::user()->id)->first();

        //delete old file from storage
        if(isset($data_detail_user['photo'])){
            $filesystem = new Filesystem;
            $data = 'storage/'.$get_photo->photo;
            if($filesystem->exists($data)){
                $filesystem->delete($data);   
            }else{
                $filesystem->delete('storage/app/public'.$get_photo->photo);
            }
        }   

        //store file to storage
        if(isset($data_detail_user['photo'])){
            $data_detail_user['photo'] = $request_detail_user->file('photo')->store(
                'assets/photo', 'public'
            );
        }

        $user = User::find(Auth::user()->id);
        $user->update($data_profile);

        $detail_user = DetailUser::find($user->detail_user->id);
        $detail_user->update($data_detail_user);

        //save to experience
        $experience_user_id = ExperienceUser::where('detail_user_id', $detail_user['id'])->first();
        if(isset($experience_user_id)){
            foreach ($data_profile['experience'] as $key => $value){
                $experience_user = ExperienceUser::find($key);
                $experience_user->detail_user_id = $detail_user['id'];
                $experience_user->experience = $value;
                $experience_user->save();
            }
        }else{
            foreach ($data_profile['experience'] as $key => $value){
                $experience_user = new ExperienceUser;
                $experience_user->detail_user_id = $detail_user['id'];
                $experience_user->experience = $value;
                $experience_user->save();
            }
        }

        toast()->success('Updated has been success');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }

    public function delete(){
        //get user
        $get_user_photo = DetailUser::where('users_id', Auth::user()->id)->first();
        $path_photo = $get_user_photo['photo'];

        //update value to null
        $data = DetailUser::find($get_user_photo['id']);
        $data->photo = NULL;
        $data->save();

        //detele file photo
        $filesystem = new Filesystem;
        $data = 'storage/'.$path_photo;
        if($filesystem->exists($data)){
            $filesystem->delete($data);
        }else{
            $filesystem->delete('storage/app/public'.$path_photo);
        }

        toast()->success('Delete has been success');
        return back();

    }
}
