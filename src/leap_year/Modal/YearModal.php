<?php

namespace LeapYear\Modal;

class YearModal{
    function is_leap_year($year){
        return $year%4 == 0;
    }
}
