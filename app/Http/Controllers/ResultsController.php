<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Providers\AppServiceProvider;

use Input;
use Validator;
use Session;
use Hash;
use Auth;
use DB;

use App\Results;
use App\Comments;
use App\Evaluations;
use App\Teachers;
use App\Subjects;

class ResultsController extends Controller
{
    //
    public function __construct(){
        $this->query_fields = ['id','name', 'email', 'created_at', 'updated_at'];

        $this->fields['text_replace'] = ['school_id' => 'School ID', 'id' => 'User ID'];


        return parent::__construct();
    }

    public function index(){


        $evaluations = DB::select("SELECT * FROM evaluations e INNER JOIN teachers t ON t.teacher_id = e.teacher_id INNER JOIN subjects s ON e.subject_id = s.subject_id ORDER BY e.created_at DESC");

        $evaluations = json_decode(json_encode($evaluations), true);

        $this->columns = ['evaluation_id', 'name', 'subject_code', 'subject_time','semester','evaluation_year','created_at'];
        
        $this->primary_key = 'evaluation_id';

        return view('admin/results/index')
            ->with('data', $evaluations)
            ->with('columns', $this->columns)
            ->with('fields', $this->fields)
            ->with('column_values', $this->column_values)
            ->with('primary_key', $this->primary_key);
    }

    public function show($id){

        $question_data = DB::select("SELECT q.question, AVG(score) AS total_score FROM results r INNER JOIN questions q ON q.question_id = r.question_id WHERE r.evaluation_id = $id GROUP BY q.question_id ORDER BY total_score DESC");

        $evaluation = DB::select("SELECT * FROM evaluations e INNER JOIN teachers t ON t.teacher_id = e.teacher_id INNER JOIN subjects s ON e.subject_id = s.subject_id WHERE e.evaluation_id = $id ORDER BY e.created_at DESC");

        if (!$evaluation) {
            Session::flash('message', 'Evaluation not found!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return back();
        }

        $get_teachers = Teachers::all();
        $teacher_ids = [];

        foreach ($get_teachers as $key => $value) {
           $teacher_ids[] = $value->school_id;
        }

        $teachers  = implode(',',$teacher_ids);
    
        $student_data = DB::select("SELECT r.score, COUNT(*) 
            AS total_count, AVG(r.score) 
            AS total_score 
            FROM results r 
            INNER JOIN questions q 
            ON q.question_id = r.question_id 
            WHERE r.evaluation_id = $id 
            AND school_id NOT IN($teachers)
            GROUP BY r.score");

        $teacher_data = DB::select("SELECT r.score, COUNT(*) 
            AS total_count, AVG(r.score) 
            AS total_score 
            FROM results r 
            INNER JOIN questions q 
            ON q.question_id = r.question_id 
            WHERE r.evaluation_id = $id 
            AND school_id IN($teachers)
            GROUP BY r.score");

        $get_teacher_to_teacher = DB::select("SELECT DISTINCT(r.school_id), t.name
            FROM evaluations e 
            INNER JOIN results r
            ON r.evaluation_id = e.evaluation_id
            INNER JOIN teachers t 
            ON 
            r.school_id = t.school_id
            WHERE e.evaluation_id = $id
            AND r.school_id IN ($teachers)
            ");

        $comments = Comments::where(['evaluation_id' => $id])->get();

        $student_bar_data = [0, 0, 0, 0];

        foreach ($student_data as $key => $value) {
            $student_bar_data[$value->score-1] = $value->total_count;

        }

        $teacher_bar_data =  [0, 0, 0, 0];

        foreach ($teacher_data as $key => $value) {
            $teacher_bar_data[$value->score-1] = $value->total_count;
        }

        $scales_data = [
            'scale_labels' => [],
            'scale_score' => []
        ];

        foreach ($question_data as $key => $value) {
            $scales_data['scale_labels'][] = $value->question;
            $scales_data['scale_score'][] = $value->total_score;
        }

        return view('admin/results/show')
        ->with('teachers', $get_teacher_to_teacher)
        ->with('comments', $comments)
        ->with('question_data', $question_data)
        ->with('scales_data', $scales_data)
        ->with('data', $student_data)
        ->with('student_bar_data', $student_bar_data)
        ->with('teacher_bar_data', $teacher_bar_data)
        ->with('evaluation', $evaluation[0]);

    }

    public function calculateEvaluation(Request $request){
        
        $data = Input::all();

        if (!$data) {
            Session::flash('message', 'No data found!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return back();
        }

        if (!$request->session()->has('evaluation_session')) {
            Session::flash('message', 'A teacher is required!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect('/');
        }

        $data['evaluation_id'] = $request->session()->get('evaluation_session')['evaluation_id'];
        $data['school_id'] = $request->session()->get('evaluation_session')['school_id'];

        // if (!$data['school_id']) {
        //     $data['school_id'] = str_shuffle(date('YmdHis'));
        // }

        $entries = [];

        foreach ($data['question'] as $key => $value) {
        	$entries[] = [
        		'evaluation_id' => $data['evaluation_id'],
        		'school_id' => $data['school_id'],
        		'question_id' => $key,
        		'score' => $value,
        		'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        		'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        	];
        }

        $create = Results::insert($entries);

        if ($create) {
        	// $request->session()->flush();
            $request->session()->forget('evaluation_session');

            if ( (isset($data['strengths']) || isset($data['weaknesses'])) ) {

                if (strlen($data['strengths']) > 0) {
                   $strength = [
                        'evaluation_id' => $data['evaluation_id'],
                        'comment' => $data['strengths'],
                        'comment_category' => 'Strength',
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ];

                    Comments::insert($strength);
                }

                if (strlen($data['weaknesses']) > 0) {
                   $weakness = [
                        'evaluation_id' => $data['evaluation_id'],
                        'comment' => $data['weaknesses'],
                        'comment_category' => 'Weakness',
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ];

                    Comments::insert($weakness);
                }
                
            }


        	Session::flash('message', 'Thank you for your evaluation!'); 
            Session::flash('alert-class', 'alert-success'); 

        	return redirect('/');
        }else{
        	Session::flash('message', 'An error occured!'); 
            Session::flash('alert-class', 'alert-danger'); 
        	return back()->withInput();
        }

    }

    

}
