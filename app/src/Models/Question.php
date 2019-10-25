<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    /**
     * @return array $data
     */
    public static function getAllQuestions()
    {
        $questions = Question::get();

        $data = [];

        foreach ($questions as $question) {
            $data['questions'][$question->id] = $question->question;
        }

        return $data;
    }

    /**
     * @param string $date
     * @return array $data
     */
    public static function getQuestions($date)
    {
        $questions = Image::raw('question_id, question')
                    ->join('question', 'question.id', '=', 'images.question_id')
                    ->where('image_added', '=', $date)
                    ->get();

        $data = [];

        foreach ($questions as $question) {
            $data['question'][$question->id] = $question->question;
        }

        return $data;
    }
}
