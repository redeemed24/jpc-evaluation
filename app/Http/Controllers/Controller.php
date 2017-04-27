<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use App\Http\Requests;

use Session;
use View;
use Input;
use Validator;
use Auth;


abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $controller = '';

    public $query = null;

    public $error_messages = [];

    public $query_fields = ['*'];

    public $primary_key = null;

    public $response = [
      'success' => false,
      'data' => null,
      'errors' => []
    ];

    public $fields = [
      'textareas' => [], 
      'dropdowns' => [], 
      'checkboxes' => [], 
      'dates' => [], 
      'text_replace' => [],
      'excludes' => [],
      'hiddens' => [],
      'times' => [],
    ];

    public $column_values = [];

    public function __construct()
    {

      $regex = preg_match('/([a-z\_]+)\./', \Request::route()->getName(), $matches);

      if ($regex) {

        $this->controller = $matches[1];
        return view()->share('controller', $this->controller);

      }

    }

    public function index()
    {
        $controller = $this->controller;

        $namespace_model = self::getModel($this->controller);

        $model = new $namespace_model;

        if (!$this->query) {
          $this->query = $namespace_model::orderBy('created_at', 'DESC')->get($this->query_fields);
        }
        
        $this->columns = \Schema::getColumnListing(strtolower($controller));

        if ($this->query_fields[0] != '*') {

          $this->columns = array_intersect($this->query_fields, $this->columns);

        }

        $this->primary_key = $model->getPrimaryKey();

        if ($this->query) {

          return view('admin/default/index')
          ->with('data', $this->query)
          ->with('columns', $this->columns)
          ->with('column_values', $this->column_values)
          ->with('primary_key', $this->primary_key)
          ->with('fields', $this->fields);

        }else{

          Session::flash('message', 'An error occured');
          Session::flash('alert-class', 'alert-success'); 

          return back();
        }

    }

    public function create()
    {
        $controller = $this->controller;

        $namespace_model = self::getModel($this->controller);

        $model = new $namespace_model;

        $fillables = $model->getFillables();

        return view('admin/default/create')
        ->with('fillables', $fillables)
        ->with('fields', $this->fields);
    }

    public function store(Request $request)
    {
        $controller = $this->controller;

        $namespace_model = self::getModel($this->controller);
        $rules = $namespace_model::$rules;

        $data = Input::all();

        $validate = Validator::make($data, $rules, $this->error_messages);

        if ($validate->fails()) {
          return redirect($controller.'/create')->withInput()->with('errors', $validate->messages());
          
        }else{
          if ($namespace_model::create($data)) {

            Session::flash('message', 'New item successfuly added!'); 
            Session::flash('alert-class', 'alert-success'); 
            return redirect($controller);
          }
        }

    }

    public function edit($id)
    {

        $controller = $this->controller;

        $namespace_model = self::getModel($this->controller);

        $this->query = $namespace_model::find($id);

        if ($this->query) {
          $model = new $namespace_model;

          $fillables = $model->getFillables();
          $this->primary_key = $model->getPrimaryKey();


          return view('admin/default/edit')
          ->with('data', $this->query)
          ->with('fillables', $fillables)
          ->with('fields', $this->fields)
          ->with('primary_key', $this->primary_key);
        }else{

          Session::flash('message', 'An error occured: Data is missing');
          Session::flash('alert-class', 'alert-danger'); 
          return redirect($controller);

        }

    }

    public function update(Request $request, $id)
    {
        $controller = $this->controller;

        $namespace_model = self::getModel($this->controller);
        
        $this->query = $namespace_model::find($id);

        $this->query->fill(Input::all());

        if ($this->query) {
          $rules = $namespace_model::$rules;

          $validate = Validator::make(Input::all(), $rules);

            if ($validate->fails()) {
              return redirect($controller.'/'.$id.'/edit')->with('errors', $validate->messages())->withInput();
            }else{
              if ($this->query->save()) {
                Session::flash('message', ucfirst(trim($controller,'s')).' updated!');
                Session::flash('alert-class', 'alert-success'); 
                return back();
              }
            }

        }else{

          Session::flash('message', 'An error occured: Data is missing');
          Session::flash('alert-class', 'alert-danger'); 
          return back();

        }

    }

    public function destroy($id){

      $controller = $this->controller;

      $namespace_model = self::getModel($this->controller);
      $namespace_model::destroy($id);

      if (count($namespace_model::destroy($id))) {
        Session::flash('message', 'Item successfully deleted!');
        Session::flash('alert-class', 'alert-success'); 
      }else{
        Session::flash('message', 'An error occured');
        Session::flash('alert-class', 'alert-danger'); 
      }

      return back();

    }

    // Breaks controller name into pieces.
    // Example: teacher_question_table becomes TeacherQuestionTable
    public static function getModelName($controller){

      $new_controller = '';
      $parts = explode('_', $controller);
      foreach ($parts as $key => $value) {
        $new_controller .= ucfirst($value);
      }

      return $new_controller;
    }

    public static function getModel($controller){

      return 'App\\' . self::getModelName($controller);

    }



}
