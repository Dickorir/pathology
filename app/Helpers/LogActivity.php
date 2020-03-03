<?php

namespace App\Helpers;
use App\LogActivity as LogActivityModel;
use Request;


class LogActivity
{


    public static function addToLog($subject)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['user_name'] = auth()->check() ? auth()->user()->name : 'Default';
        LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }

}
