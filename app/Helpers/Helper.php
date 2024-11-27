<?php
namespace App\Helpers;

class Helper{

    public static function calculateStars ($stars,$total)
    {
        $total_score = 0;
        $total_response = 0;
        $keys = array_keys($stars->toArray());
        foreach($keys as $key)
        {
            $total_response += count($stars[$key]); 
            $total_score += $key * count($stars[$key]);
            $stars[$key] = count($stars[$key]) * 100 / $total;
        }
        if($total_response > 0)
        return round($total_score / $total_response,1);
        else 
        return 0;
    }
}