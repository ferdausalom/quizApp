<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportTriviaQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:trivia-questions';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Import trivia questions from the Open Trivia Database API into the MySQL database.';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function trimMyString($value)
    {
        $value = str_replace('3A', ': ', $value); // replace 20 with spaces
        $value = str_replace('20', '', $value); // replace 20 with spaces
        $value = str_replace('22', '', $value); // replace 22 with spaces
        $value = str_replace('/', ' ', $value); // replace slashes with spaces
        $value = str_replace('%', ' ', $value); // replace percentage signs with spaces
        $value = trim(preg_replace('/\s+/', ' ', $value)); // remove extra spaces and trim

        return $value;
    }

    public function handle()
    {
        try {
            // // Create the trivia_questions table if it does not exist
            if (!Schema::hasTable('trivia_questions')) {
                Schema::create('trivia_questions', function (Blueprint $table) {
                    $table->id();
                    $table->string('category');
                    $table->string('type');
                    $table->string('difficulty');
                    $table->text('question');
                    $table->text('correct_answer');
                    $table->text('incorrect_answers');
                    $table->timestamps();
                });
            }

            // Disable SSL verification for the cURL request
            $responseMultiple = Http::withOptions(['verify' => false])->get('https://opentdb.com/api.php', [
                'amount' => 5, // number of questions to fetch
                'type' => 'multiple', // types of questions to fetch
                'difficulty' => 'easy',
                'encode' => 'url3986', // URL encoding format
            ]);

            // Convert the response to JSON
            $multipleData = $responseMultiple->json();

            // dd($data);

            // Insert the questions and answers into the database
            foreach ($multipleData['results'] as $question) {
                DB::table('trivia_questions')->insert([
                    'category' => $this->trimMyString($question['category']) ?? '',
                    'type' => $question['type'] ?? '',
                    'difficulty' => $question['difficulty'] ?? '',
                    'question' => $this->trimMyString($question['question']) ?? '',
                    'correct_answer' => $this->trimMyString($question['correct_answer']) ?? '',
                    'incorrect_answers' => $this->trimMyString(json_encode($question['incorrect_answers']) ?? []),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Disable SSL verification for the cURL request
            $responseBoolean = Http::withOptions(['verify' => false])->get('https://opentdb.com/api.php', [
                'amount' => 5, // number of questions to fetch
                'type' => 'boolean', // types of questions to fetch
                'difficulty' => 'easy',
                'encode' => 'url3986', // URL encoding format
            ]);

            // Convert the response to JSON
            $booleanData = $responseBoolean->json();

            // Insert the questions and answers into the database
            foreach ($booleanData['results'] as $question) {
                DB::table('trivia_questions')->insert([
                    'category' => $this->trimMyString($question['category']) ?? '',
                    'type' => $question['type'] ?? '',
                    'difficulty' => $question['difficulty'] ?? '',
                    'question' => $this->trimMyString($question['question']) ?? '',
                    'correct_answer' => $this->trimMyString($question['correct_answer']) ?? '',
                    'incorrect_answers' => $this->trimMyString(json_encode($question['incorrect_answers']) ?? []),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->info('Trivia questions imported successfully!');
        } catch (Exception $e) {
            $this->error('Error importing trivia questions: ' . $e->getMessage());
            Log::error('Error importing trivia questions: ' . $e->getMessage());
        }
    }
}
