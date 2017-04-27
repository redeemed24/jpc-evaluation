<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Providers\FileStorageProvider;

use Input;
use Validator;
use Session;
use Hash;
use Auth;
use DB;
use Mail;
use Storage;

use App\Evaluations;
use App\Teachers;
use App\Subjects;
use App\Departments;
use App\Questions;
use App\Results;
use App\Users;


class UsersController extends Controller
{
    //
    public function __construct(){
        $this->query_fields = ['id','username','name', 'email', 'created_at', 'updated_at'];

        $this->fields['text_replace'] = ['school_id' => 'School ID', 'id' => 'User ID'];

        $this->fields['dropdowns'] = ['user_type' => Users::$user_type];

        return parent::__construct();
    }

    public function edit($id){
        $this->fields['excludes'] = ['password'];
        return parent::edit($id);
    }

    public function postLogin()
    {

        $data = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
            );


        $rules = array(
            'username' => 'required',
            'password' => 'required'
            );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) 
        {
            Session::flash('message', 'Invalid School ID / Password!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect('admin');
        }


        if(Auth::attempt(['username' => Input::get('username'), 'password' => Input::get('password') ]))
        {

            return redirect('home');
           
        }
        else
        {
            Session::flash('message', 'Invalid Username / Password!'); 
            Session::flash('alert-class', 'alert-danger'); 
        
            return redirect('admin');
           
        }

    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('admin');
    }

    public function home(){

        $data['teachers'] = Teachers::all();
        $data['subjects'] = Subjects::all();
        $data['departments'] = Departments::all();
        $data['questions'] = Questions::all();

        $admin_settings = $this->getAdminSettings();

        $get_results = DB::select("SELECT r.score, COUNT(*) AS total_count, AVG(r.score) AS total_score 
            FROM results r 
            INNER JOIN questions q 
            ON q.question_id = r.question_id 
            INNER JOIN evaluations e
            ON e.evaluation_id = r.evaluation_id
            WHERE 
            e.evaluation_year = '".$admin_settings['year']."'
            AND
            e.semester = '".$admin_settings['semester']."'
            GROUP BY r.score");

        $donut_data = [];
        $labels = ['', 'Unsatisfactory', 'Satisfactory', 'Very Good', 'Excellent'];
        foreach ($get_results as $key => $value) {
            $donut_data[] = ['label' => $labels[$value->score], 'value'=> $value->total_count];

        }

        $get_departments = DB::select("SELECT d.name, COUNT(t.teacher_id) AS teacher_count 
            FROM departments d 
            INNER JOIN teachers t ON t.department_id = d.department_id 
            GROUP BY d.department_id 
            ORDER BY d.name ASC");

        $ongoing_evaluations = DB::select("SELECT * 
            FROM evaluations e 
            INNER JOIN teachers t ON t.teacher_id = e.teacher_id 
            INNER JOIN subjects s ON e.subject_id = s.subject_id  
            WHERE e.status = '0' 
            ORDER BY e.created_at DESC");

        $top_teachers = DB::select("SELECT t.name AS teacher, AVG(r.score) AS total_score
            FROM results r 
            INNER JOIN evaluations e ON e.evaluation_id = r.evaluation_id 
            INNER JOIN teachers t ON t.teacher_id = e.teacher_id 
            WHERE 
            e.evaluation_year = '".$admin_settings['year']."'
            AND
            e.semester = '".$admin_settings['semester']."'
            GROUP BY t.teacher_id 
            ORDER BY total_score ASC LIMIT 10");


        $scale_scores = DB::select("SELECT qc.category, AVG(r.score) AS avg_score, qc.recommendation 
            FROM questions q
            INNER JOIN results r 
            ON r.question_id = q.question_id
            LEFT JOIN question_categories qc
            ON
            qc.question_category_id = q.question_category_id
            INNER JOIN evaluations e
            ON
            e.evaluation_id = r.evaluation_id
            WHERE
            e.evaluation_year = '".$admin_settings['year']."'
            AND
            e.semester = '".$admin_settings['semester']."'
            GROUP BY qc.category
            ORDER BY avg_score DESC 
            ");

        $getTeachersResults = DB::select("SELECT t.name,AVG(r.score) as total_score FROM results r 
            INNER JOIN evaluations e 
            ON r.evaluation_id = e.evaluation_id 
            INNER JOIN teachers t 
            ON t.teacher_id = e.teacher_id 
            WHERE e.evaluation_year = '".$admin_settings['year']."'
            AND
            e.semester = '".$admin_settings['semester']."'
            GROUP BY t.teacher_id
            ORDER BY total_score DESC");

        // 1~2.5 uns..
        // 2.5~3 sat..
        // 3~3.5 vg..
        // 3.5~4 exc..
        $scale_teacher_results = [
            'Excellent' => [],
            'Very Good' => [],
            'Satisfactory' => [],
            'Unsatisfactory' => [],
        ];

        foreach ($getTeachersResults as $key => $value) {
            $eq = '';

            if ($value->total_score >= 3.5) {
               $eq = 'Excellent';
            }elseif($value->total_score > 3.0 && $value->total_score < 3.5){
                $eq = 'Very Good';
            }elseif ($value->total_score >= 2.5 && $value->total_score < 3.0) {
                $eq = 'Satisfactory';
            }else{
                $eq = 'Unsatisfactory';
            }

            if (isset($scale_teacher_results[$eq])) {
                $scale_teacher_results[$eq][] = [
                    'name' => $value->name,
                    'score' => $value->total_score,
                    'equivalent' => $eq

                ];
            }
        }

        $category_data = [];
        foreach ($scale_scores as $key => $value) {
            $get_name = preg_match('/([A-Z]\.\s)(.+)/', $value->category, $match);
            if ($get_name) {
                $category_data[] = ['label' => $match[2], 'score' => $value->avg_score, 'recommendation' => ($value->avg_score < 2.5) ? $value->recommendation : '' ];
            }
        }


    	return view('admin/home')
        ->with('top_teachers', $top_teachers)
        ->with('ongoing_evaluations', $ongoing_evaluations)
        ->with('data', $data)
        ->with('donut_data', $donut_data)
        ->with('departments', $get_departments)
        ->with('category_data', $category_data)
        ->with('admin_settings', $admin_settings)
        ->with('scale_teacher_results', $scale_teacher_results);
    }

    public function createAccount(){

    	$data = [
    		'school_id' => '1111',
    		'name' => 'Admin',
    		'password' => Hash::make('12345'),
    		'user_type' => '1',
    		'email' => 'chesster423@gmail.com',
    	];

    	$save =  User::create($data);

    	if ($save) {
    		var_dump($save);die;
    	}
    }

    public function evaluationLogin(){

        $data = DB::select("SELECT e.evaluation_id, t.name, s.subject_code, e.subject_time, e.semester, e.evaluation_year
            FROM teachers t INNER JOIN evaluations e ON e.teacher_id = t.teacher_id
            INNER JOIN subjects s ON s.subject_id = e.subject_id
            WHERE e.status = 0
            ");

        return view('index')->with('data', $data);
    }
    
    public function startEvaluation(Request $request){

        $data = Input::all();

        if (!$data['evaluation_id']) {
           Session::flash('message', 'A teacher is required!'); 
           Session::flash('alert-class', 'alert-danger'); 

            return back();
        }else{
            $request->session()->put('evaluation_session', $data);

            if ($request->session()->has('evaluation_session')) {
      
                return redirect('evaluate');
            }

        }
    }

    public function evaluate(Request $request){

        if (!$request->session()->has('evaluation_session')) {
            Session::flash('message', 'A teacher is required!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return back();
        }else{

            $data = DB::select("SELECT * FROM questions q INNER JOIN question_categories qc ON
                q.question_category_id = qc.question_category_id ORDER BY qc.category, q.sort ASC
            ");

            $questions = [];

            foreach ($data as $key => $value) {
         
                $questions[$value->category][] = [
                    'question_id' => $value->question_id,
                    'question' => $value->question
                ];
                
            }

            return view('evaluation')->with('questions', $questions);

        }
       
    }

    public function mail(){
        $data = Input::all();

        if (!$data['teacher_id']) {
            Session::flash('message', 'An error occure: A teacher is required!'); 
            Session::flash('alert-class', 'alert-danger'); 

            return back();
        }else{

            $teacher = Teachers::find($data['teacher_id']);

            if (!$teacher->email) {
                Session::flash('message', 'Teacher has no email'); 
                Session::flash('alert-class', 'alert-danger'); 

                return back();
            }else{
                
                // $send = Mail::send( 'admin.default.mail', ['title' => $data['subject'], 'message' => $data['message']], function ($message)
                //  {
                //     $data = Input::all();
                //     $teacher = Teachers::find($data['teacher_id']);
                //     $message->from('stjohnpaulcollege@gmail.com');
                //     $message->to($teacher->email);
                // });

                $headers = "From: chesster423@yahoo.com";
                // $send = mail($teacher->email, $data['subject'] ,$data['message'], $headers);
                $send = true;

                if ($send) {
                    Session::flash('message', 'Your message has been sent successfuly!'); 
                    Session::flash('alert-class', 'alert-success'); 

                    return back();
                }else{
                    Session::flash('message', 'Teacher has no email'); 
                    Session::flash('alert-class', 'alert-danger'); 

                    return back();
                }
            }

            
        }

    }

    public function saveDashboardConfig(){

        $data = Input::all();

        if (!$data) {
            Session::flash('message',  'Failed to save settings!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return back();
        }


        if (!is_numeric($data['year'])) {
            Session::flash('message',  'Points should be numeric'); 
            Session::flash('alert-class', 'alert-warning'); 
            return back();
        }

        $store = FileStorageProvider::generatePointsSettingsFile($data);

        if ($store) {
            Session::flash('message', 'Settings saved successfuly'); 
            Session::flash('alert-class', 'alert-success'); 
            return back();
        }else{
            Session::flash('message',  'Failed to save settings!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return back();
        }
    }

    public function settings()
    {
        //
        $controller = 'Settings';

        $admin_settings = $this->getAdminSettings();

        $years = [];
        for ($i=2016; $i < ((int)date('Y'))+5; $i++) { 
            $years += [$i => $i];
        }


        $data = compact('controller', 'admin_settings', 'years');

        return view("admin/settings/edit", $data);
    }

    public function getAdminSettings(){

        $admin_settings_file = Storage::disk('local')->exists('settings/admin_settings.txt');

        if (!$admin_settings_file) {
            FileStorageProvider::generatePointsSettingsFile([]);
        }

        $admin_settings_file = Storage::disk('local')->get('settings/admin_settings.txt');

        $admin_settings = json_decode($admin_settings_file, true);

        return $admin_settings;

    }



}
