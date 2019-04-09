<?php

namespace App\Http\Controllers\Admin;

use App\Magazin;
use App\Http\MagazinRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MagazinsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Magazin::class, 'magazin');
    }



    public function toggleSubPrice($id)
    {
        $magazin = Purchase::find($id);
        $magazin->toggleStatusSubPrice();
    }

    public function toggleDiscontGlM($id)
    {
        $magazin = Magazin::find($id);
        $magazin->toggleVisibleGlM();//dd($user->status_discont_id);

        return redirect()->back();
    }    

    public function toggleDiscontGlMAll(Request $request)
    {
        $magazin = Magazin::find($id);
        $magazin->toggleVisibleGlMAll();//dd($user->status_discont_id);

        return redirect()->back();
    }
       //admin on/off global discont 
    public function toggleVisibleGlMAll()
    {
        $user_id = \Auth::user()->id;
        $magazins = Magazin::where('user_id', $user_id)->get();
        foreach($magazins as $magazin)
            {
                $magazin->toggleVisibleGlM();

        } 
       return redirect()->back();
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = \Auth::user()->id;
        $magazins = Magazin::where('user_id', $user_id)->get();
        return view('admin.magazins.index', ['magazins'=>$magazins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.magazins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' =>'required',
        //     'autor'   =>  'required',
        //     'number_per_year' =>  'required',
        //     'year' =>  'required',
        //     'number' =>  'required',
        //     'size' =>  'required',
        //     'price' =>  'required',
        //     'sub_price' =>  'required',
        //     'old_price' =>  'required',
        //     'img' =>  'nullable|image',
            
        // ]);

        $magazin = Magazin::add($request->all());
        $magazin->uploadImage($request->file('img'));
        //$magazin->toggleDiscontGLM($request->get('discont_privat'));
        return redirect()->route('magazins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $magazin = Magazin::find($id);
        return view('admin.magazins.show', compact('magazin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $magazin = Magazin::find($id);
        
        return view('admin.magazins.edit', compact('magazin'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $magazin = Magazin::find($id);
        $magazin->edit($request->all());
        $magazin->uploadImage($request->file('img'));
        $magazin->toggleStatus($request->get('status'));

        return redirect()->route('magazins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Magazin::find($id)->remove();
        return redirect()->route('magazins.index');
    }
}
