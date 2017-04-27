<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\QuestionCategories;

use App\Providers\AppServiceProvider;

use DB;

class QuestionsController extends Controller
{
    //

    public function __construct(){
        $this->query_fields = ['question_id', 'question', 'created_at', 'updated_at'];

        $this->fields['textareas'] = ['question'];
        $this->fields['text_replace'] = ['question' => 'Evaluation Question', 'question_category_id' => 'Category'];
        $this->fields['text_replace'] = ['sort' => 'Order'];

        $get_departments = QuestionCategories::all();

        $this->fields['dropdowns'] = [
            'question_category_id' => AppServiceProvider::generateDropdownValues($get_departments, 'question_category_id', 'category', '- Select Category -'),
        ];

    
        return parent::__construct();
    }

}
