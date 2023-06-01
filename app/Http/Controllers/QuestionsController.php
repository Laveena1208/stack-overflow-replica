<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{
    public function __construct() {
        $this->middleware(['auth'])->only(['create', 'store','edit','update']);
    }
    public function index()
    {
        $questions = Question::with('owner')->latest()->paginate(10);
        return view('questions.index', compact(['questions']));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(CreateQuestionRequest $request)
    {
        auth()->user()->questions()->create([
            'title'=>$request->title,
            'body'=>$request->body
        ]);

        session()->flash('success', 'Question has been added successfully!');
        return redirect(route('questions.index'));
    }

    //Gate Method
    // public function edit(Question $question)
    // {
    //     if(Gate::allows('update-question', $question)){
    //         return view('questions.edit', compact([
    //             'question'
    //         ]));
    //     }
    //     abort(403);

    // }

    public function edit(Question $question)
    {
        if($this->authorize('update', $question))
        {
            return view('questions.edit', compact([
                'question'
            ]));
        }
        abort(403);

    }

    // Gate Method:-
    // public function update(UpdateQuestionRequest $request, Question $question)
    // {
    //     if(Gate::allows('update-question', $question)){$question->update([
    //             'title'=>$request->title,
    //             'body'=>$request->body
    //         ]);
    //         session()->flash('success', 'Question has been updated successfully!');
    //         return redirect(route('questions.index'));
    //     }
    //     abort(403);

    // }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        if($this->authorize('update', $question)){
            $question->update([
                'title'=>$request->title,
                'body'=>$request->body
            ]);
            session()->flash('success', 'Question has been updated successfully!');
            return redirect(route('questions.index'));
        }
        abort(403);

    }

    // Gate method:-
    // public function destroy(Question $question)
    // {
    //     if(auth()->user()->can('delete-question',$question)){
    //         $question->delete();
    //         session()->flash('success', 'Question has been deleted successfully!');
    //         return redirect(route('questions.index'));
    //     }
    //     abort(403);
    // }


    public function destroy(Question $question)
    {
        if($this->authorize('delete',$question)){
            $question->delete();
            session()->flash('success', 'Question has been deleted successfully!');
            return redirect(route('questions.index'));
        }
        abort(403);
    }

    public function show(Question $question)
    {

        $question->increment('views_count');
        return view('questions.show', compact([
            'question'
        ]));
    }
}
