<?php

namespace App\Http\Controllers;



class SchedulerController extends BaseController
{
    public function run()
    {
        \Artisan::call('schedule:run');
        return response('Scheduler run successfully', 200);
    }
}
