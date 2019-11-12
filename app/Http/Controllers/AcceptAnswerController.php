<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer) {

      // update lai column best_answers_id (question)
      $answer->question->updateBestAnswer($answer);
      return back();
    }
}
