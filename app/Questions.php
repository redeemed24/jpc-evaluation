<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    //
    protected $fillable = ['question_category_id','question', 'sort'];

    protected $guarded = [];

    protected $primaryKey = 'question_id';

   	public static $rules  = [
    	'question' => 'required|min:5',

    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }

}
