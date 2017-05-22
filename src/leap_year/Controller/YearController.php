<?php
namespace LeapYear\Controller;

use Symfony\Component\HttpFoundation;
use LeapYear\Modal\YearModal;

class YearController{
    function leapAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        //$answer = YearModal::is_leap_year($year)? 'Leap Year': 'False';
        $answer = 'Asking for a blog page with id -> '.$id;
        return new HttpFoundation\Response($answer);
    }

    function jumpAction(HttpFoundation\Request $request){
        $answer = 'Asking for a blog table listing';
        return new HttpFoundation\Response($answer);
    }

    function crawlAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        //$answer = YearModal::is_leap_year($year)? 'Leap Year': 'False';
        $answer = 'Asking for a blog entries with tag id -> '.$id;
        return new HttpFoundation\Response($answer);
    }
}
