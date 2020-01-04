<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function date_time_difference ($time_in, $time_out)
    {
        $time_in = new \DateTime($time_in);
        $time_out = new \DateTime($time_out);
        $diff = $time_in->diff($time_out);
        return $diff->format('%H:%I:%S');
    }

    protected function decimal_to_hour ($decimal_number)
    {
        $hour = floor($decimal_number);
        $min = round(60 * ($decimal_number - $hour));
        return date('h:i:s', strtotime($hour.':'.$min));
    }

    // not used
//    protected function time_to_decimal($time)
//    {
//        $hms = explode(":", $time);
//        return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
//    }

    protected function sum_times($times)
    {
        $seconds = 0;
        foreach ($times as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        if($seconds < 9)
        {
            $seconds = "0".$seconds;
        }
        if($minutes < 9)
        {
            $minutes = "0".$minutes;
        }
        if($hours < 9)
        {
            $hours = "0".$hours;
        }
        return "{$hours}:{$minutes}:{$seconds}";
    }

    public function redirectBackBack(){
        $links = session()->has('links') ? session('links') : [];
        $currentLink = request()->path(); // Getting current URI like 'category/books/'
        array_unshift($links, $currentLink); // Putting it in the beginning of links array
        session(['links' => $links]); // Saving links array to the session
    }



}
