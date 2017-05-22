<?php
namespace TestBlog\Controller;

use Symfony\Component\HttpFoundation;
use LeapYear\Modal\BlogModal;

class BlogController{
    function blogpostAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        $answer = 'Asking for a blog page with id -> '.$id;
        return new HttpFoundation\Response($answer);
    }

    function bloglistAction(HttpFoundation\Request $request){
        $answer = 'Asking for a blog table listing';
        return new HttpFoundation\Response($answer);
    }

    function tagstableAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        $answer = 'Asking for a blog entries with tag id -> '.$id;
        return new HttpFoundation\Response($answer);
    }
}
