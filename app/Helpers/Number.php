<?php
namespace App\Helpers;

class Number{
    public static function ToShortForm($num)
    {
        if($num >=1E9)
            return round($num/1E9,2).'B';
        else if($num >= 1E6)
            return round($num/1E6,2).'M';
        else if($num >= 1E3)
            return round($num/1E3,2).'K';
        return $num;
    }
    
    public static function ToSizeFormat($num)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $num > 0 ? floor(log($num, 1024)) : 0;
        $size = number_format($num / pow(1024, $power), 2, '.',',') . ' ' . $units[$power]; 
    }
}