<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password','school_id','user_type', 
    ];

    protected $guarded = [];
    protected $table = 'users';

    protected $primaryKey = 'id';

    public static $user_type = [
        0 => 'Administrator',
        1 => 'Guidance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFillables(){
        return $this->fillable;
    }

    public function getPrimaryKey(){
        return $this->primaryKey;
    }
    
    
}
