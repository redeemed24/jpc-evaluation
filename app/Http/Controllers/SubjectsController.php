<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SubjectsController extends Controller
{
    //
	public function __construct(){
		$this->fields['textareas'] = ['subject_desc'];
    	$this->fields['text_replace'] = [
    		'subject_id' => 'Subject ID',
    		'subject_desc' => 'Description',
    	];

    	return parent::__construct();
	}

}
