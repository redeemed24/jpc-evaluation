<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class QuestionCategoriesController extends Controller
{
    //
    public function __construct(){
      
        $this->fields['textareas'] = ['description', 'recommendation'];
        $this->fields['text_replace'] = ['description' => 'Category Description'];

        return parent::__construct();
    }
}
