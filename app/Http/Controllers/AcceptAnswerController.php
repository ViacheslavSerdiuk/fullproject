<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{

   public function store(Answer $answer)
   {
       $this->authorize('accept',$answer);

       $answer->question->acceptBestAnswer($answer);

       return back();
   }

   public function destroy(Answer $answer)
   {

       $this->authorize('accept',$answer);

       $answer->question->removeBestAnswer($answer);

       return back();
   }

}
