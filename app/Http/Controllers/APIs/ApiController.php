<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

use App\Models\User;

class ApiController extends Controller
{
    //Check Email
    public function checkEmail(Request $request){
        $status = false;

        $email = $request->input('email');
        $existingEmail = User::where('email', $email)->first();

        if (!$existingEmail) {
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function checkUsername(Request $request){
        $status = false;

        $username = $request->input('username');
        $existingUser = User::where('username', $username)->first();

        if (!$existingUser) {
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function getdataGoogleAnalytics(Request $request)
    {
        $period = Period::days(7);
        $count = 5;
        if ($request->startDate != null || $request->endDate != null) {
            $stdate = Carbon::createFromFormat('d/m/Y', $request->startDate)->format('Y-m-d H:i:s');
            $edate =  Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Y-m-d H:i:s');
            $startDate = new carbon($stdate);
            $endDate = new carbon($edate);

            $period = Period::create($startDate, $endDate);
        }

        $visitors = Analytics::fetchTotalVisitorsAndPageViews($period)->pluck('activeUsers')->toArray();
        $pageviews= Analytics::fetchTotalVisitorsAndPageViews($period)->pluck('screenPageViews')->toArray();
        $datevisit = Analytics::fetchTotalVisitorsAndPageViews($period)->pluck('date')->toArray();
        $mostpages =  Analytics::fetchMostVisitedPages($period,$count);
        $topbrowsers =  Analytics::fetchTopBrowsers($period,$count);
        $regions = Analytics::get($period, ['screenPageViews'],['country','region'],10);
        $metrics = ['activeUsers', 'newUsers', 'screenPageViews', 'bounceRate','scrolledUsers','userEngagementDuration','eventCount','eventCountPerUser','totalUsers'];
        $analytics = Analytics::get($period,$metrics);

        $date = [];
        //get index to array for use in datatable
        foreach ($mostpages as $key => $value) {
            $value['index'] = $key + 1;
            $mostpages[$key] = $value;
        };

        foreach ($datevisit as $d){
            array_push($date,Carbon::createFromFormat('Y-m-d H:i:s',$d)->format('d M Y'));
        }
        usort($date, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });

        return response()->json(['visitors'=> $visitors,'pageviews' =>$pageviews, 'date' => $date, 'mostpages' => json_decode($mostpages), 'analytics' => $analytics,'topbrowsers' => $topbrowsers, 'regions' =>$regions]);

    }
}
