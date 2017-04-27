<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    //
    protected $fillable = ['name'];

    protected $guarded = [];

    protected $primaryKey = 'department_id';

   	public static $rules  = [
    	'name' => 'required|min:5',

    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }
}
