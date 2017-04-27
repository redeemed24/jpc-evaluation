<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Teachers;
use App\Subjects;
use App\Evaluations;
use App\Results;
use App\Providers\AppServiceProvider;


use DB;
use Input;
use Excel;
use Session;
use Validator;

class EvaluationsController extends Controller
{
    //
    public function __construct(){

    	$this->fields['text_replace'] = ['teacher_id' => 'Teacher', 'subject_id' => 'Subject'];

        $teachers = Teachers::all();
        $subjects = Subjects::all();

        $semesters = ['' => 'Select Semester', '1st' => '1st', '2nd' => '2nd'];
        $years = ['' => 'Select Year'];
        for ($i=2016; $i < ((int)date('Y'))+5; $i++) { 
            $years += [$i => $i];
        }

        $this->fields['dropdowns'] = [
            'teacher_id' => AppServiceProvider::generateDropdownValues($teachers, 'teacher_id', 'name', '- Select Teacher -'),
            'subject_id' => AppServiceProvider::generateDropdownValues($subjects, 'subject_id', 'subject_code', '- Select Subject -'),
            'semester' => $semesters,
            'evaluation_year' => $years,
            'status' => [0 => 'Active', 1 => 'Closed'],
        ];

        $this->fields['times'] = ['subject_time'];

        $this->error_messages = [
            'school_id.required' => 'A teacher is needed',
            'subject_id.required' => 'A subject is needed',
        ];

        $this->column_values = [
            'status' => [0 => 'Active', 1 => 'Closed'],
        ];

        $this->primary_key = 'evaluation_id';


        return parent::__construct();
    }

    public function index(){

        $evaluations = DB::select("SELECT *, e.status AS evaluation_status FROM evaluations e INNER JOIN teachers t ON t.teacher_id = e.teacher_id INNER JOIN subjects s ON e.subject_id = s.subject_id ORDER BY e.created_at DESC");

        $evaluations = json_decode(json_encode($evaluations), true);

        $this->columns = ['evaluation_id', 'name', 'subject_code', 'evaluation_status','subject_time','semester','evaluation_year','created_at'];
        
       $this->column_values = [
            'evaluation_status' => [0 => 'Active', 1 => 'Closed'],
        ];
    
        return view('admin/default/index')
            ->with('data', $evaluations)
            ->with('columns', $this->columns)
            ->with('fields', $this->fields)
            ->with('column_values', $this->column_values)
            ->with('primary_key', $this->primary_key);
    }

    public function import(){

        $data = Input::all();

        if (!$data) {

            $evaluation = new Evaluations;

            $fillables = $evaluation->getFillables();

            unset($fillables[5]);

            $controller = 'evaluations';

            return view('admin/results/import')
            ->with('fillables', $fillables)
            ->with('controller', $controller)
            ->with('fields', $this->fields);

        }else{

            if(Input::hasFile('import_file')){

                $extension = Input::file('import_file')->getClientOriginalExtension();
                    
                $accepted_files = ['csv'];

                if (!in_array($extension, $accepted_files)) {
                    Session::flash('message', 'The file must be in .csv format!'); 
                    Session::flash('alert-class', 'alert-danger'); 
                    return back()->withInput();
                }

                $rules = Evaluations::$rules;

                $data['status'] = 1;

                $validate = Validator::make($data, $rules, $this->error_messages);

                if ($validate->fails()) {
                    return back()->withInput()->with('errors', $validate->messages());
                }else{

                    if ($evaluation = Evaluations::create($data)) {

                        $evaluation_id = $evaluation->evaluation_id;

                        $questions = DB::select('SELECT question_id, sort FROM questions q ORDER BY q.question_category_id, q.sort ASC');

                        $total_questions = count($questions);

                        $csv_data = [];

                        if (($handle = fopen( Input::file('import_file'), "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $csv_data[] = $data;
                            }
                            fclose($handle);
                        }
                        unset($csv_data[0]);
                        unset($csv_data[1]);

                        $created_at = \Carbon\Carbon::now()->toDateTimeString();
                        $updated_at = \Carbon\Carbon::now()->toDateTimeString();

                        $entries = [];
                
                        foreach ($csv_data as $key => $value) {

                            if ($value[1] = '' || $value[1] == null || strlen($value[1]) == 0) {
                                break;
                            }

                            for ($i=1; $i <= $total_questions; $i++) { 

                                if ($value[$i] != 0) {
                                    $entries[] = [
                                        'evaluation_id' => $evaluation_id,
                                        'school_id' => 0,
                                        'question_id' => $questions[$i-1]->question_id,
                                        'score' => $value[$i],
                                        'created_at' => $created_at,
                                        'updated_at' => $updated_at,
                                    ];
                                }
                            } 

                        }

                        $results = Results::insert($entries);
  
                        Session::flash('message', 'New evaluation successfuly added!'); 
                        Session::flash('alert-class', 'alert-success'); 
                        return redirect('results/'.$evaluation_id);
                    }

                }
            
            }else{
                Session::flash('message', 'An excel/csv file is required!'); 
                Session::flash('alert-class', 'alert-danger'); 
                return back();
            }
  
        }

    }


}
