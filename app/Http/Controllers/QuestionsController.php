<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
  }

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
   * 'update-question' được tạo ở app/providers/AuthServiceProvider.php
   *  method Gate::allows('update-question', $question) cho phép, còn denies là không cho phép
   */
  public function edit(Question $question)
  {
//      $question = Question::findorFail(id);
//    nếu không muốn sử dụng Gate để check thì ta có thể sử dụng policies => xem ở lesson11-b để biết cách sử dụng
    // cái Gate này sẽ mapping với cái gate định nghĩa trong AuthServiceProvider.php
    if(Gate::denies('update-question', $question)) {
      // nếu user đang login thì khi bấm vào edit button của nó mới hiển thị trang edit
      return abort(403, 'Access Denies');
    }
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
    if(Gate::denies('update-question', $question)) {
      // nếu user đang login thì khi bấm vào edit button của nó mới hiển thị trang edit
      return abort(403, 'Access Denies');
    }
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
    if(Gate::denies('delete-question', $question)) {
      // nếu user đang login thì khi bấm vào edit button của nó mới hiển thị trang edit
      return abort(403, 'Access Denies');
    }
//    $question->destroy($question->id);
    $question->delete();
    return redirect()->route('questions.index')->with('success', 'Your Question has been removed');
  }
}
