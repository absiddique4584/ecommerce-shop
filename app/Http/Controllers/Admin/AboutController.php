<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Profile;
use Exception;
class AboutController extends Controller
{




    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $abouts =  About::latest()->get();
        $profiles = Profile::get();

        return view('admin.about.manage',compact('abouts','profiles'));
    }






    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $profiles = Profile::get();
        return view('admin.about.create',compact('profiles'));
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
            'long_desc'=>'required'
        ]);
        $abouts =null;
        try {
            About::create([
                'long_desc' =>$request->long_desc,

            ]);
            $abouts = true;
        }catch (Exception $exception){
            $abouts = false;
        }
        if ($abouts == true){
            setMessage('success','About Save Success !');
        }else{
            setMessage('danger','Something Wrong !');
        }
        return redirect()->back();
    }




    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $id = base64_decode($id);
        $abouts = About::find($id);
        $profiles = Profile::get();
        return view('admin.about.edit',compact('abouts','profiles'));
    }




    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $abouts = About::find($id);

        $request->validate([
            'long_desc'=>'required'
        ]);

        $success =null;
        try {
            $abouts->update([
                'long_desc' =>$request->long_desc
            ]);
            $success = true;
        }catch (Exception $exception){
            $success = false;
        }
        if ($success == true){
            setMessage('success','About updated Successfully !');
        }else{
            setMessage('danger','Something Wrong !');
        }
        return redirect()->back();
    }







    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        $id = base64_decode($id);
        $abouts = About::find($id);
        $abouts->delete();
        setMessage('success','About has been Successfully Deleted !');
        return redirect()->back();
    }
}
