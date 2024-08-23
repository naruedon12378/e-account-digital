<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set("Asia/Bangkok");

class UniversalHelper
{
    function getrandomstring($length)
    {
        global $template;
        settype($template, "string");

        $template = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        /* this line can include numbers or not */

        settype($length, "integer");
        settype($rndstring, "string");
        settype($a, "integer");
        settype($b, "integer");

        for ($a = 0; $a <= $length; $a++) {
            $b = rand(0, strlen($template) - 1);
            $rndstring .= $template[$b];
        }

        return $rndstring;
    }

    function getCurrentYearGregorian()
    {
        return date('Y'); // ปีปัจจุบัน (ค.ศ.) แสดง 4 ตัว
    }

    function getCurrentYearThai()
    {
        $thaiYear = date('Y') + 543;
        return $thaiYear; // ปีปัจจุบัน (พ.ศ.) แสดง 4 ตัว
    }

    function getCurrentYearLastTwoDigitsGregorian()
    {
        return date('y'); // ปีปัจจุบัน (ค.ศ.) แสดง 2 ตัวหลัง
    }

    function getCurrentYearLastTwoDigitsThai()
    {
        $thaiYear = date('y') + 43;
        return $thaiYear; // ปีปัจจุบัน (พ.ศ.) แสดง 2 ตัวหลัง
    }

    function addActivityLog($table_name, $primary_key_name, $primary_key_value, $activity)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
        $company_id = $auth->company_id;
        $name = $auth->name;
        $status = false;

        $create = new ActivityLog();
        $create->table_name = $table_name;
        $create->primary_key_name = $primary_key_name;
        $create->primary_key_value = $primary_key_value;
        $create->activity = $activity;
        $create->company_id = $company_id;
        $create->user_id = $user_id;
        $create->created_by = $auth->firstname . " " . $auth->lastname;

        if ($create->save()) {
            $status = true;
        }

        return $status;
    }
}
