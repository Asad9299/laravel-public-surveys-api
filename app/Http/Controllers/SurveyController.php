<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyQuestionAnswer;
use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();
        return SurveyResource::collection(Survey::list($user->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurveyRequest $request): SurveyResource
    {

        $data     = $request->validated();

        if (!empty($data['image'])) {
            $imagePath = $this->getImagePath($data['image']);
            $data['image'] = $imagePath;
        }

        $survey   = new Survey();
        $response = $survey->add($data);

        // Save Questions if they are not empty
        if (!empty($data['questions'])) {
            $this->saveQuestions($response->id, $data['questions']);
        }
        return new SurveyResource($response);
    }

    private function saveQuestions(int $surveyId, array $questions): void
    {
        foreach ($questions as $question) {
            $surveyQuestion = new SurveyQuestion();
            $surveyQuestion->add($surveyId, $question);
        }
    }

    private function getImagePath($image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);

            // Get file extension
            $type = strtolower($type[1]);

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);
        return $relativePath;
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        return new SurveyResource($survey);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        $data     = $request->validated();

        if ($survey->slug) {
            $data['slug'] = $survey->slug;
        } else {
            $data['slug']   = Str::slug($data['title']);
        }

        if (!empty($data['image'])) {
            $imagePath = $this->getImagePath($data['image']);
            $data['image'] = $imagePath;

            // If there is an old image, delete it
            if ($survey->image) {
                $absolutePath = public_path($survey->image);
                File::delete($absolutePath);
            }
        }

        $survey->edit($data);

        $existingQuestions = $survey->questions->toArray();

        $existingQuestionIds = array_column($existingQuestions, 'id');

        $questionsToDelete = array_diff($existingQuestionIds, array_column($data['questions'], 'id'));


        // To Delete the Question(s)
        if (!empty($questionsToDelete)) {
            SurveyQuestion::remove($questionsToDelete);
        }

        // To Insert or Update the Question(s)
        foreach ($data['questions']  as $question) {
            if (in_array($question['id'], $existingQuestionIds)) {
                // update
                SurveyQuestion::edit($question);
            } else {
                // insert
                $surveyQuestion = new SurveyQuestion();
                $surveyQuestion->add($survey->id, $question);
            }
        }
        $survey->load('questions');
        return new SurveyResource($survey);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Survey $survey)
    {
        $user = $request->user();
        if ($user->id !== $survey->user_id) {
            return abort(403, 'Unauthorized action.');
        }

        if ($survey->remove()) {
            return response('', 204);
        }
        return response('Something went wrong', 400);
    }

    public function getSurveyBySlug(Survey $survey)
    {
        return new SurveyResource($survey);
    }

    public function saveAnswers(StoreSurveyQuestionAnswer $request, Survey $survey)
    {
        $answers = $request->validated()['answers'];

        $surveyAnswer = SurveyAnswer::add($survey->id);

        foreach ($answers as $questionId => $answer) {
            SurveyQuestionAnswer::add([
                'survey_question_id' => $questionId,
                'survey_answer_id'   => $surveyAnswer->id,
                'answer'             => is_array($answer) ? json_encode($answer) : $answer
            ]);
        }
        return response('Answers recorded successfully', 201);
    }
}
