<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\BookRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
//use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }

    public function toggleDiscontGlB($id)
    {
        $book = Book::find($id);
        $book->toggleVisibleGlB();

        return redirect()->back();
    }    
    //admin on/off global discont 
    public function toggleVisibleGlBAll()
    {
        $user_id = \Auth::user()->id;
        $books = Book::where('user_id', $user_id)->get();
        foreach($books as $book)
            {
                $book->toggleVisibleGlB();

        } 
       return redirect()->back();
        
    }
    
    public function toggleHard($id)
    {
        $book = Book::find($id);
        $book->toggleHard();

        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if no check add error page
        $user_id = \Auth::user()->id;
        $books = Book::where('user_id', $user_id)->get();
        return view('admin.books.index', ['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.create');
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
        //     'author_name'   => 'required',
        //     'page' => 'required',
        //     'autor'   => 'required',
        //     'year' => 'required',
        //     'kindof' => 'required',
        //     'size'  => 'required',
        //     'price'   => 'required',
        //     'old_price' => '',
        //     'img' =>  'nullable|image',
        // ]);

        $book = Book::add($request->all());

        $book->uploadImage($request->file('img'));
        //$book->toggleStatus($request->get('status_draft'));//is draft
        $book->toggleDiscontGLB($request->get('discont_privat'));
        $book->toggleHard($request->get('is_hard_hard'));

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $book = Book::find($id);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        return view('admin.books.edit', compact(
            'book'
        ));

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
        $book = Book::find($id);
        $book->edit($request->all());
        $book->uploadImage($request->file('img'));
        //$book->toggleStatus($request->get('status_draft'));
        $book->toggleDiscontGLB($request->get('discont_privat'));
        $book->toggleHard($request->get('is_hard_hard'));
        //$book->toggleHit_book($request->get('hit_book'));

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::find($id)->remove();
        return redirect()->route('books.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Book  $book
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Book $book)
    // {
    //     $book->delete();

    //     return redirect()->route('books.index');
    // }
}
