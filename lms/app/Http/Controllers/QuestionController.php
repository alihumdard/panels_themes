<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use App\Models\EnrolledUser;

class QuestionController extends Controller
{
    public function __construct()
    {
//        $this->middleware('loginAuth');
    }

    public function add_question()
    {
        $CONSTANTS = config('constants');

        $data['response_type']      = $CONSTANTS['response_types'];
        $data['difficulty_level']   = $CONSTANTS['difficulty_level'];
        $data['answers']            = $CONSTANTS['answers'];

        $courses = Course::select('id', 'title')->where('is_enable', 1)->get()->toArray();
        $data['course_list'] = array_column($courses, 'title', 'id');

        return view('admin.add_question', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_title'    => 'required',
            'course_id'         => 'required',
            'response_type'     => 'required',
            'difficulty_level'  => 'required',
            'answer'            => 'required',
        ]);

        $response_type = $request->response_type;

        if($response_type == config('constants')['TRUE_FALSE_ID']){
            $option_1 = config('constants')['TRUE'];
            $option_2 = config('constants')['FALSE'];
        }
        else{
            $option_1 = $request->option_1;
            $option_2 = $request->option_2;

            $request->validate([
                'option_1' => 'required',
                'option_2' => 'required',
                'option_3' => 'required',
            ]);
        }

        $question = new Question();

        $question->title            = $request->question_title;
        $question->course_id        = $request->course_id;
        $question->response_type    = $request->response_type;
        $question->difficulty_level = $request->difficulty_level;
        $question->answer           = $request->answer;
        $question->option_1         = $option_1;
        $question->option_2         = $option_2;
        $question->option_3         = $request->option_3 ?: NULL;
        $question->option_4         = $request->option_4 ?: NULL;
        $question->option_5         = $request->option_5 ?: NULL;
        $question->is_enable        = 1;
        $question->created_by       = Session::get('user_id');
        $question->save();

        if($question->id){
            Session::flash('success', 'Question added successfully!');
            Session::flash('alert-class', 'alert-success');
//            return redirect('batch_list')->with('success', 'Question added successfully!');
            return redirect('question_list');
        }
    }

    public function question_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Question::with(['course' => function($query) {
                $query->select([
                    'courses.id',
                    'title as course_title',
                ]);
            }])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return status_button($row->id, $row->is_enable);
                })
                ->make(true);
        }
        return view('admin.question_list');
    }

    public function test_paper(Request $request)
    {
        $username = '+' . $request->username;
        $batch_id = $request->batch_id;

        $attempt = DB::table('attempts')
            ->where(['username' => $username, 'batch_id' => $batch_id])
            ->orderByDesc('id')
            ->get();

        if(!$attempt->isEmpty()){
            if($attempt->count() == 3){
                return response()->json(['message' => 'You cannot attempt more than 3 times.'], 200);
            }
            else{
                $next_date = date('Y-m-d', strtotime($attempt->first()->created_at. ' + 3 days'));
                $current_date = date('Y-m-d');

                if($current_date < $next_date){
                    return response()->json(['message' => 'You can attempt after 3 days '.$next_date], 200);
                }
            }
        }

        $user_detail  = EnrolledUser::where('username', $username)->first();
        $batch_detail = Batch::find($batch_id);

        $course_id          = $batch_detail->course_id;
        $total_questions    = $batch_detail->total_questions;
        $total_marks        = $batch_detail->total_marks;
        $total_time         = $batch_detail->total_time;

        $mark_per_question = $total_marks / $total_questions;

        $ratio = explode(',', $batch_detail->ratio);

        $easy_questions = Question::where(['course_id' => $course_id, 'difficulty_level' => 1])
            ->inRandomOrder()
            ->limit($ratio[0])
            ->get();

        $normal_questions = Question::where(['course_id' => $course_id, 'difficulty_level' => 2])
            ->inRandomOrder()
            ->limit($ratio[1])
            ->get();

        $hard_questions = Question::where(['course_id' => $course_id, 'difficulty_level' => 3])
            ->inRandomOrder()
            ->limit($ratio[2])
            ->get();

        $questions = ($easy_questions->merge($normal_questions->merge($hard_questions)))->shuffle();

        return response()->json($questions, 200);
    }

    public function return_option(Request $request)
    {
        $type = $request->type;
        if ($type == config('constants')['TRUE_FALSE_ID']){
            $answers = config('constants')['answers_2'];
            $html = ' <option value="">Please select</option>';
            foreach ($answers as $key => $item) {
                $html .= "<option value=$key>$item</option>";
            }
        }
        else{
            $answers = config('constants')['answers'];
            $html = ' <option value="">Please select</option>';
            foreach ($answers as $key => $item) {
                $html .= "<option value=$key>$item</option>";
            }
        }

        return response()->json($html);
    }
}
