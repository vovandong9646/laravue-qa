<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $questions = Question::with('user')->latest()->paginate(5);
    return view('questions.index', compact('questions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $question = new Question();
    return view('questions.create', compact('question'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(AskQuestionRequest $request)
  {
    $request->user()->questions()->create($request->only('title', 'body'));
    return redirect()->route('questions.index')->with('success', 'Your Question has been created');
  }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
      // $question->views = $question->views + 1;
      // $question->save();
      $question->increment('views');
        return view('questions.show', compact('question'));
    }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Question $question
   * @return \Illuminate\Http\Response
   */
  public function edit(Question $question)
  {
//      $question = Question::findorFail(id);
    return view('questions.edit', compact('question'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Question $question
   * @return \Illuminate\Http\Response
   */
  public function update(AskQuestionRequest $request, Question $question)
  {
    $question->update($request->only('title', 'body'));
    return redirect()->route('questions.index')->with('success', 'Your Question has been updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Question $question
   * @return \Illuminate\Http\Response
   */
  public function destroy(Question $question)
  {
//    $question->destroy($question->id);
    $question->delete();
    return redirect()->route('questions.index')->with('success', 'Your Question has been removed');
  }
}
