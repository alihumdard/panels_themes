<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use DiUtil\Utilities\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;



class CourseController extends Controller
{
    public function __construct()
    {
//        $this->middleware('loginAuth');
    }

    private $select_columns = ['id', 'country_name as name', 'country_full_name as full_name', 'dialing_code as dial_code', 'short_code', 'is_enable as activate'];

    public function add_course()
    {
        return view('admin.add_course');
    }

    public function store(Request $request)
    {
        dd($request->course_title);
        $request->validate([
            'course_title' => 'required',
        ]);

//        Add course
        $course             = new Course();
        $course->title      = $request->course_title;
        $course->created_by = Session::get('user_id');
        $course->save();
        $course_id = $course->id;

//        Add course video links
        foreach ($request->video_title as $key => $val) {
            $course_content = new CourseContent();
            if($val && $request->video_link[$key]){
                // $request->validate([
                //     'video_link' => 'required',
                //     'video_link.*' => 'required',
                // ]);

                $course_content->course_id  = $course_id;
                $course_content->title      = $val;
                $course_content->link       = $request->video_link[$key];
                $course_content->created_by = Session::get('user_id');
                $course_content->save();
            }
        }

//        Add course files
        if($request->hasFile('course_files')){
            $files = $request->file('course_files');
            foreach ($files as $file) {

                $id = uniqid();
                $file_name_original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension     = last(explode('.', $file->getClientOriginalName()));
                $file_name_hash     = md5($file_name_original);
                $file_name          = $file_name_hash.'-'.$id.'.'.$file_extension;

                $file->storeAs('files', $file_name);

                $course_content = new CourseContent();
                $course_content->course_id  = $course_id;
                $course_content->title      = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $course_content->link       = $file_name;
                $course_content->created_by = Session::get('user_id');
                $course_content->save();
            }
        }

        Session::flash('success', 'Course added successfully!');
//        return redirect('batch_list')->with('success', 'Question added successfully!');
        return redirect('course_list');
    }

    public function course_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    return status_button($row->id, $row->is_enable);
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('admin.course_list');
    }

    public function content_list(Request $request)
    {
        if ($request->ajax()) {
            $data = CourseContent::with(['course' => function($query) {
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
        return view('admin.content_list');
    }

    /**
     * Add Country.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCourse(Request $request)
    {
        $mdlCourse = new Course();

        $this->validate($request, $mdlCourse->rules($request), $mdlCourse->messages($request));
        $request->requested_by = 1;
        Utilities::defaultAddAttributes($request);
        $mdlCourse->filterColumns($request);

        $obj = Course::create($request->all());

        $data = ['id' => $obj->id];

        $response = Utilities::buildSuccessResponse(1056, "Course successfully created.", $data);

        return response()->json($response, 201);
    }

    /**
     * Fetch list of Country by searching with optional filters..
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCourse(Request $request)
    {
        $mdlCourse = new Course();

        $this->validate($request, $mdlCourse->rules($request, Constant::RequestType['GET_ALL']), $mdlCourse->messages($request, Constant::RequestType['GET_ALL']));

        $pageSize = $request->limit ?? ProjectConstant::PageSize;
        if ($pageSize > ProjectConstant::MaxPageSize) {
            $pageSize = ProjectConstant::PageSize;
        }
        $page = $request->page ?? ProjectConstant::Page;
        $skip = ($page - 1) * $pageSize;

        $select = $this->select_columns;

        $mdlCourse->filterColumns($request);

        if ($request->fields) {
            $select = $request->fields;
        }
        $whereData = array();

        if ($request->name) {
            $whereData[] = ['country_name', 'LIKE', "%{$request->name}%"];
        }
        if ($request->full_name) {
            $whereData[] = ['country_full_name', 'LIKE', "%{$request->full_name}%"];
        }
        if ($request->dial_code) {
            $whereData[] = ['dialing_code', 'LIKE', "%{$request->dial_code}%"];
        }
        if ($request->short_code) {
            $whereData[] = ['short_code', 'LIKE', "%{$request->short_code}%"];
        }
        if ($request->activate != null) {
            $whereData[] = ['is_enable', $request->activate];
        }
        $countriesCount = DB::table('countries')->where($whereData)->count();
//        $countriesCount = Country::where($whereData)->active()->get()->count();

        $orderBy =  $mdlCountry->getOrderColumn($request->order_by);
        $orderType = $request->order_type ?? ProjectConstant::OrderType;

        $countries = DB::table('countries')
            ->where($whereData)
            ->orderBy($orderBy, $orderType)
            ->offset($skip)
            ->limit($pageSize)
            ->get($select)->toArray();

//        $countries = Country::where($whereData)
//            ->active()
//            ->orderBy($orderBy, $orderType)
//            ->offset($skip)
//            ->limit($pageSize)
//            ->get($select);
        $status = 200;
        $data_result = new CountryResponse();
        $data_result->setCountries(json_decode(json_encode($countries), true));
        $data_result->setTotalCountries($countriesCount);
        $response = Utilities::buildSuccessResponse(1062, "Country list.", $data_result);
        return response()->json($response, $status);
    }
}
