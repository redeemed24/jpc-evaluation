<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    //
    protected $fillable = ['school_id', 'department_id','name', 'status', 'gender', 'address', 'contact', 'email'];

    protected $guarded = [];

    protected $primaryKey = 'teacher_id';

   	public static $rules  = [
   		'school_id' => 'required|min:5',
    	'name' => 'required|min:5',
    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }
}
