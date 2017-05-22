<?php
namespace LeapYear\Controller;

use Symfony\Component\HttpFoundation;
use LeapYear\Modal\YearModal;

class YearController{
    function leapAction(HttpFoundation\Request $request){
        $year = $request->attributes->get('year');
        $answer = YearModal::is_leap_year($year)? 'Leap Year': 'False';
        return new HttpFoundation\Response($answer);
    }
}
