<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluations extends Model
{
    //
    protected $fillable = ['teacher_id', 'subject_id','subject_time', 'semester', 'evaluation_year','status'];

    protected $guarded = [];

    protected $primaryKey = 'evaluation_id';

   	public static $rules  = [
   		'teacher_id' => 'required',
    	'subject_id' => 'required',
    	'subject_time' => 'required',
    	'semester' => 'required',
    	'evaluation_year' => 'required',
    	'status' => 'required',
    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }
}
