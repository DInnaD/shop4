<?php

namespace App;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{

    use SoftDeletes, Notifiable;

    const IS_ADMIN = 1;
    const IS_USER = 0;
    const IS_BANNED = 1;
    const IS_ACTIVE = 0;
    const IS_VISIBLE_DISCONT_ID = 1;
    const IS_UNVISIBLE_DISCONT_ID = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function magazins()
    {//est one data for curr table
        return $this->hasMany(Magazin::class);
    }

    public function books()
    {//est one data for curr table
        return $this->hasMany(Book::class);
    }

    public function homes()
    {//est one data for curr table
        return $this->hasMany(Home::class);
    }

    public function purchases()
    {//est one data for curr table
        return $this->hasMany(Purchase::class);
    }

    public function ordersAll()
    {//est one data for curr table
        return $this->hasMany(OrdersAll::class);
    }

    public function orders()
    {//est one data for curr table
        return $this->hasMany(Order::class);
    }
//with html & text "Info about status_privat == 1 visible global discont"
       //and     
  //   $user = User::findOrFail($id);

  //   Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
  //     $m->from('hello@app.com', 'Your Application');

  //     $m->to($user->email, $user->name)->subject('Your Reminder!');
  //   });


    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        //$user->email = $email;
        $user->password = Hash::make($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields); //name,email
        $this->password = Hash::make($fields['password']);
        //if($this->is_admin == 1){
            //$this->discont_id = $fields['discont_id'];
        //}
       
        $this->save();
    }

    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = Hash::make($password);
            $this->save();
        }
    }

    public function remove()
    {
        //$this->removeAvatar();
        $this->delete();
    }

  
//add migration image
    // public function uploadAvatar($image)
    // {
    //     if($image == null) { return; }

    //     $this->removeAvatar();

    //     $filename = str_random(10) . '.' . $image->extension();
    //     $image->storeAs('uploads', $filename);
    //     $this->avatar = $filename;
    //     $this->save();
    // }

    // public function removeAvatar()
    // {
    //     if($this->avatar != null)
    //     {
    //         Storage::delete('uploads/' . $this->avatar);
    //     }
    // }

    // public function getImage()
    // {
    //     if($this->avatar == null)
    //     {
    //         return '/img/no-image.png';
    //     }

    //     return '/uploads/' . $this->avatar;
    // }

    public function makeAdmin()
    {
        $this->is_admin = User::IS_ADMIN;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = User::IS_USER;
        $this->save();
    }

    public function toggleAdmin()
    {
        if($this->is_admin == 0)
        {
            return $this->makeAdmin();
        }

        return $this->makeNormal();
    }

    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toggleBan()
    {
        if($this->status == 0)
        {
            return $this->unban();
        }

        return $this->ban();
    }

    public function makeVisibleDiscontId()
    {
        $this->status_discont_id = User::IS_VISIBLE_DISCONT_ID;
        $this->save();
    }

    public function makeUnVisibleDiscontId()
    {
        $this->status_discont_id = User::IS_UNVISIBLE_DISCONT_ID;
        $this->save();
    }

    public function toggleVisibleId()
    {
        if($this->status_discont_id != 1)
        {
            return $this->makeVisibleDiscontId();
        }

        return $this->makeUnVisibleDiscontId();
    }
    
}
