<?php

namespace App\Http\Controllers;

use App\Home;
use App\Book;
use App\Magazin;
use Auth;
use App\User;
use App\Purchase;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
    	if(Auth::check() == true)//or true
    	{
    		$user_id = \Auth::user()->id;//see only admin
    		$books = Book::where('user_id', $user_id)->get();
    		$magazins = Magazin::where('user_id', $user_id)->get();
	        $users = User::all();
	        $purchases = Purchase::all();
    	} else
    		{
    			$users = User::all();
		        $books = Book::paginate(10);
		        $magazins = Magazin::paginate(10);
		        $purchases = Purchase::all();
		        
    		}

        return view('homes.index')->with('books', $books)->with('magazins', $magazins)->with('purchases', $purchases)->with('users', $users);
    }

    //public function top5

}
