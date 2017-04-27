<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Results extends Model
{
    //
    protected $fillable = ['evaluation_id', 'school_id', 'score', 'question_id'];

    protected $guarded = [];

    protected $primaryKey = 'result_id';

   	public static $rules  = [
    	'evaluation_id' => 'required',
    	'score' => 'required',
    	'question_id' => 'required',
    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }
}
