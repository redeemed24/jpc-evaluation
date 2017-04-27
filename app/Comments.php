<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $fillable = ['evaluation_id', 'comment', 'comment_category'];

    protected $guarded = [];

    protected $primaryKey = 'comment_id';

   	public static $rules  = [
   		'evaluation_id' => 'required|min:5',
    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }
}
