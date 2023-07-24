<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\EnrolledUser;
use App\Models\Question;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function change_status(Request $request)
    {
        $id         = $request->id;
        $is_enable  = $request->is_enable;
        $route      = $request->route;

        switch ($route){
            case 'course_list':
                $res = Course::where('id',$id)->update(['is_enable'=>$is_enable]);
                break;
            case 'content_list':
                $res = CourseContent::where('id',$id)->update(['is_enable'=>$is_enable]);
                break;
            case 'question_list':
                $res = Question::where('id',$id)->update(['is_enable'=>$is_enable]);
                break;
            case 'batch_list':
                $res = Batch::where('id',$id)->update(['is_enable'=>$is_enable]);
                break;
            case 'enrolled_user':
                $res = EnrolledUser::where('id',$id)->update(['is_approved'=>$is_enable]);
                if($is_enable == 1){
                    $mobile = "+923167346410";
//            send temporary password to user
                    $sms_host_url = env('SMS_HOST');
                    $sms_secret_key = env('SMS_SECRET_KEY');

//                    $send_sms = Http::post($sms_host_url, [
//                        'secret_token' => $sms_secret_key,
//                        'country_code' => '92',
//                        'mobile' => ltrim($mobile, '+'),
//                        'message' => "Enrolled",
//                    ]);
                }
                break;
        }

        return response()->json($res);
    }
}
