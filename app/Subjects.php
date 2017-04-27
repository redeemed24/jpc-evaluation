<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    //
    protected $fillable = ['subject_code', 'subject_desc'];

    protected $guarded = [];

    protected $primaryKey = 'subject_id';

   	public static $rules  = [
   		'subject_code' => 'required|min:2',
    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }
}
