<?php

namespace TestBlog\Modal;

class BlogModal{
    function is_leap_year($year){
        return $year%4 == 0;
    }
}
