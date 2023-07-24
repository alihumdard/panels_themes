<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\EnrolledUser;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EnrolledUserController extends Controller
{
    public function enrolled_user_list(Request $request)
    {
        if ($request->ajax()) {
            $data = EnrolledUser::with(['batch' => function($query) {
                $query->select([
                    'batches.id',
                    'title as batch_title',
                ]);
            }])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return status_button($row->id, $row->is_approved);
                })
                ->make(true);
        }
        return view('admin.enrolled_user_list');
    }

    public function enrollment(Request $request)
    {
        $today = date('Y-m-d');
        $course_detail = Batch::where('id', $request->batch_id)->first();
        if($today > $course_detail->registration_date){
            return response()->json(['response' => 201, 'message' => 'Course not availabale']);
        }
        else{
            $exist_user = EnrolledUser::where(['username' => $request->phone, 'batch_id' => $request->batch_id])->first();

            if($exist_user){
                return response()->json(['response' => 201, 'message' => 'Already Registered. Plz wait for SMS']);
            }
            else{
                $user = new EnrolledUser();
                $user->username    = $request->phone;
                $user->name        = $request->name;
                $user->f_name      = $request->f_name;
                $user->phone       = $request->phone;
                $user->batch_id    = $request->batch_id;
                $user->is_approved = 0;
                $user->save();
//            return response()->json(['message' => 'Successfully Applied. We will send you confirmation message on your mobile number']);
                return response()->json(['response' => 200, 'message' => 'Successfully Applied. We will send you confirmation message on your mobile number']);
            }
        }
    }

    public function temp(Request $request)
    {
        DB::table('attempts')->insert([
            'username' => '+923049304526',
            'batch_id' => 1
        ]);
    }
}
