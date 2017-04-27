<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCategories extends Model
{
    //
    protected $fillable = ['category', 'description', 'recommendation'];

    protected $guarded = [];

    protected $primaryKey = 'question_category_id';

   	public static $rules  = [
    	'category' => 'required|min:5',
    ];

    public function getFillables(){
    	return $this->fillable;
    }

    public function getPrimaryKey(){
    	return $this->primaryKey;
    }


}
