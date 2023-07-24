<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EnrolledUser;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $username = '+923001234567';
        $data['courses'] = DB::table('enrolled_users')
            ->join('batches', function ($join) {
                $today = date('Y-m-d');
                $join->on('enrolled_users.batch_id', '=', 'batches.id')
                    ->where('batches.end_date', '>', $today);
            })
            ->where('enrolled_users.username', '=', $username)
            ->get();
        return view('user.dashboard', $data);
    }
}
