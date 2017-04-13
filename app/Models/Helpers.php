<?php
/**
 * Created by PhpStorm.
 * User: inmersys
 * Date: 3/21/17
 * Time: 9:35 AM
 */

namespace App\Models;


class Helpers
{
    public static function getPublicPath($string , $coincidence){
        $whatIWant = substr($string, strpos($string, $coincidence));
        return public_path($whatIWant);
    }
}