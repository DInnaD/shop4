<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;// Searchable, Owned; 

	const IS_DRAFT = 0;//chornovyk//db have no status_draft
	const IS_PUBLIC = 1;//published
    const IS_HARD = 0;
    const IS_NOHARD = 1;
    const IS_VISIBLE_DISCONT_GLB = 1;
    const IS_UNVISIBLE_DISCONT_GLB = 0;
    const IS_VISIBLE_DISCONT_PROMOB = 1;
    const IS_UNVISIBLE_DISCONT_PROMOB = 0;

	protected $fillable = ['user_id', 'slug', 'name', 'autor', 'page', 'year', 'is_hard', 'is_hard_hard', 'kindof', 'size', 'price', 'old_price', 'status', 'img', 'discont_global', ];


    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function author()//isAdmin
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatus()
    {
        return $this->purchases()->where('status', 1)->get();
    }

    public static function add($fields)
    {
    	$book = new static;
    	$book->fill($fields);
    	$book->user_id = \Auth::user()->id;
    	$book->save();

    	return $book;
    }    

    public function edit($fields)
    {
    	$this->fill($fields);
    	$this->save();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

        public function removeImage()
    {
        if($this->img != null)
        {
            Storage::delete('uploads/' . $this->img);
        }
    }

    public function uploadImage($img)
    {
        if($img == null) { return; }

        $this->removeImage();
        $filename = str_random(10) . '.' . $img->extension();
        $img->storeAs('uploads', $filename);
        $this->img = $filename;
        $this->save();
    }

    public function getImage()
    {
        if($this->img == null)
        {
            return '/img/no-image.png';
        }

        return '/uploads/' . $this->img;

    }


    public function setDraft()//chernovik
    {
    	$this->status_draft = Book::IS_DRAFT;
    	$this->save();
    }

    public function setPublic()
    {
    	$this->status_draft = Book::IS_PUBLIC;//status_draft db absent
    	$this->save();
    }

    public function toggleStatus()
    {
    	if($this->status_draft != 1)
        {
            return $this->setPublic();
        }

        return $this->setDraft();
    }

    public function setHard()//chernovik
    {
        $this->is_hard_hard = Book::IS_HARD;
        $this->save();
    }

    public function setNoHard()
    {
        $this->is_hard_hard = Book::IS_NOHARD;
        $this->save();
    }

    public function toggleHard()
    {
        if($this->is_hard_hard != 1)
        {
            return $this->setNoHard();
        }

        return $this->setHard();
    }

    public function makeVisibleDiscontGlB()
    {
        $this->discont_privat = Book::IS_VISIBLE_DISCONT_GLB;
        $this->save();
    }

    public function makeUnVisibleDiscontGlB()
    {
        $this->discont_privat = Book::IS_UNVISIBLE_DISCONT_GLB;
        $this->save();
    }

    public function toggleVisibleGlB()
    {
        if($this->discont_privat != 1)//!= null default i nullable is the same?
        {
            return $this->makeVisibleDiscontGlB();
        }

        return $this->makeUnVisibleDiscontGlB();
    }

    public function makeVisibleDiscontPROMOB()
    {
        $this->discont_id_promocode = Book::IS_VISIBLE_DISCONT_PROMOB;
        $this->save();
    }

    public function makeUnVisibleDiscontPROMOB()
    {
        $this->discont_id_promocode = Book::IS_UNVISIBLE_DISCONT_PROMOB;
        $this->save();
    }

    public function toggleVisiblePROMOB()
    {
        if($this->discont_id_promocode != 1)//!= null default i nullable is the same?
        {
            return $this->makeVisibleDiscontPROMOB();
        }

        return $this->makeUnVisibleDiscontPROMOB();
    }  
    
    // public function getCategoryID()
    // {
    //     return $this->category != null ? $this->category->id : null;
    // }

    // public function hasPrevious()
    // {
    //     return self::where('id', '<', $this->id)->max('id');
    // }

    // public function getPrevious()
    // {
    //     $postID = $this->hasPrevious(); //ID
    //     return self::find($postID);
    // }

    // public function hasNext()
    // {
    //     return self::where('id', '>', $this->id)->min('id');
    // }

    // public function getNext()
    // {
    //     $postID = $this->hasNext();
    //     return self::find($postID);
    // }

    // public function related()
    // {
    //     return self::all()->except($this->id);
    // }

    // public static function getPopularBooks()
    // {
    //     return self::orderBy('hit_book','desc')->take(5)->get();
    // }
}
