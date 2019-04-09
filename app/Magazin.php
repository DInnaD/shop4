<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magazin extends Model
{
   use SoftDeletes;//, Owned;

	const IS_DRAFT = 0;
	const IS_PUBLIC = 1;
    const IS_VISIBLE_DISCONT_GLM = 1;
    const IS_UNVISIBLE_DISCONT_GLM = 0;
    const IS_VISIBLE_DISCONT_PROMOB = 1;
    const IS_UNVISIBLE_DISCONT_PROMOB = 0;

	protected $fillable = ['user_id', 'category_id', 'slug', 'name', 'autor', 'number_per_year', 'year', 'number', 'size', 'price', 'sub_price', 'old_price', 'status', 'img', 'hit_magazin', 'discont_global',];



    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ]; 
    }

    public function getStatus()
    {
        return $this->purchases()->where('status', 0)->get();
    }


    public static function add($fields)
    {
    	$magazin = new static;
    	$magazin->fill($fields);
    	$magazin->user_id = \Auth::user()->id;
    	$magazin->save();

    	return $magazin;
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
    

    //*******************
    public function setDraft()
    {
    	$this->status_draft = Magazin::IS_DRAFT;//status_draft db absent
    	$this->save();
    }

    public function setPublic()
    {
    	$this->status_draft = Magazin::IS_PUBLIC;
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

    public function subscribe()
    {
        
        $this->status_sub_price = 1;
        $this->save();
        
    }

    public function disSubscribe()
    {
        $this->status_sub_price = 0;
        $this->save();
    }

    public function toggleStatusSubPrice()
    {
        if($this->status_sub_price == 0)
        {
            return $this->subscribe();
        }

        return $this->disSubscribe();
    }

    public function makeVisibleDiscontGlM()
    {
        $this->discont_privat = Magazin::IS_VISIBLE_DISCONT_GLM;
        $this->save();
    }

    public function makeUnVisibleDiscontGlM()
    {
        $this->discont_privat = Magazin::IS_UNVISIBLE_DISCONT_GLM;
        $this->save();
    }

    public function toggleVisibleGlM()
    {
        if($this->discont_privat != 1)//!= null default i nullable is the same?
        {
            return $this->makeVisibleDiscontGlM();
        }

        return $this->makeUnVisibleDiscontGlM();
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
        

    // public function getCategoryTitle()
    // {
    //     return ($this->category != null) 
    //             ?   $this->category->title
    //             :   'Нет категории';
    // }

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

    // public static function getPopularMagazins()
    // {
    //     return self::orderBy('hit_magazin','desc')->take(5)->get();
    // }

    
}
