<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Input;
use Validator;
use Illuminate\Support\Facades\Auth;
class QuestionController extends Controller
{

    public function create(){
        $categories = Categories::all();

        return view('question.create',compact('categories'));
    }

    public function store(){
        $user = Auth::user();
        $input = Input::all();
        $rules = [
            'title' => 'required',
            'description' => '',
            'sub_category' => ''
        ];
        $messages = [
            'title.required' => 'Question Title field is required',
            'sub_category.required' => 'SubCategory Field is required'
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $question = new Question;
            $question->title = $input['title'];
            $question->description = $input['description'];
            $question->sub_cat_id = $input['sub_cat_id'];
            $question->user_id = $user->id;
            $question->save();

            return Redirect::to('question/'.$question->id);
        }
    }

    public function show($id){
        $question = Question::find($id);
        $categories = Categories::all();

        return view('question.show',compact('question','categories'));

    }
//    public function vote_answer(){
//        $data = Input::all();
//\\
//        INsert answerws table vote + 1
//        //question_id
//    }

}