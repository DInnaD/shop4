<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Magazin;
use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
	public function index()
	{
	
	    $purchase->book = Purchase::where('qty')->orderBy('qty','desc')->take(5)->get();
	    $purchase->magazin = Purchase::where('qty_m')->orderBy('qty_m','desc')->take(5)->get();
	    //$currentData === $purchase->create_at;
	        return view('admin.statistics.index')with('purchases', $purchases)->with('books', $books)->with('magazins', $magazins);
	}

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('purchases.show', compact('purchase'));
    }
}
