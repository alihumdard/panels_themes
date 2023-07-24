<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Batch;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BatchController extends Controller
{
    public function __construct()
    {
//        $this->middleware('loginAuth');
    }

    public function add_batch()
    {
        $courses = Course::select('id', 'title')->where('is_enable', 1)->get()->toArray();
        $data['course_list'] = array_column($courses, 'title', 'id');

        return view('admin.add_batch', $data);
    }

    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'batch_title'       => 'required',
            'course_id'         => 'required',
            'total_questions'   => 'required',
            'total_marks'       => 'required',
            'total_time'        => 'required',
            'easy_question'     => 'required',
            'normal_question'   => 'required',
            'hard_question'     => 'required',
            'ym_index'          => 'required',
            'registration_date' => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
        ]);


        $total_question = $request->total_questions;
        $sum = $request->easy_question + $request->normal_question + $request->hard_question;

        if($sum <> $total_question){
            return redirect('add_batch')
                ->withInput()
                ->withErrors(['error' => 'Sum of Normal, Easy and Hard Question should be equal to Total Question']);
        }

        $year  = explode('-', $request->ym_index)[0];
        $month = explode('-', $request->ym_index)[1];
        $ym_index = $year.$month;

        $ratio = implode(',', array($request->easy_question, $request->normal_question, $request->hard_question));

        $batch = new Batch();

        $batch->title               = $request->batch_title;
        $batch->course_id           = $request->course_id;
        $batch->total_questions     = $request->total_questions;
        $batch->total_marks         = $request->total_marks;
        $batch->total_time          = $request->total_time;
        $batch->ratio               = $ratio;
        $batch->month               = $month;
        $batch->year                = $year;
        $batch->ym_index            = $ym_index;
        $batch->registration_date   = $request->registration_date;
        $batch->start_date          = $request->start_date;
        $batch->end_date            = $request->end_date;
        $batch->is_enable           = 1;
        $batch->created_by          = Session::get('user_id');

        $batch->save();

        if($batch->id){
            Session::flash('success', 'Batch added successfully!');
            Session::flash('alert-class', 'alert-success');
//            return redirect('batch_list')->with('success', 'Question added successfully!');
            return redirect('batch_list');
        }
    }

    public function batch_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Batch::with(['course' => function($query) {
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
        return view('admin.batch_list');
    }

    public function batches_api()
    {
        $date = date('Y-m-d');
        $data = Batch::where('registration_date', '>=', $date)->get();
        return response()->json($data, 200);
    }
}
