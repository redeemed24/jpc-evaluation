<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Departments;

use App\Providers\AppServiceProvider;

class TeachersController extends Controller
{

	public function __construct(){
		
		$this->fields['textareas'] = ['address'];
    	$this->fields['text_replace'] = ['teacher_id' => 'Teacher ID','school_id' => 'School ID', 'department_id' => 'Department'];

        $get_departments = Departments::all();
 
    	$this->fields['dropdowns'] = [
    		'gender' => ['' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female'],
            'department_id' => AppServiceProvider::generateDropdownValues($get_departments, 'department_id', 'name', '- Select Department -'),
    	];
    	

    	return parent::__construct();
	}
  
	public function index()
    {
    	$this->query_fields = ['teacher_id', 'school_id','name', 'gender','contact', 'email','created_at', 'updated_at'];
        
    	
    	return parent::index();
    }

}
