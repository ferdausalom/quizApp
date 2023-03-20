<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuestionsApiController extends Controller
{
    public function index()
    {
        $questions = DB::table('trivia_questions')->get();

        $questions = $questions->map(function ($question) {
            return [
                'category' => $question->category,
                'question' => $question->question,
                'type' => $question->type,
                'correct_answer' => $question->correct_answer,
                'incorrect_answers' => json_decode($question->incorrect_answers),
                'difficulty' => $question->difficulty,
            ];
        });

        return response()->json($questions);

        // return response()->json($questions);
    }
}
