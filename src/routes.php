<?php
    use Symfony\Component\Routing;
    $routes->add('blog_page', new Routing\Route(
        '/blog/{id}',
        array('_controller' =>
                'LeapYear\Controller\YearController::leapAction',)));
    $routes->add('blog_listing', new Routing\Route(
        '/blog',
        array('_controller' =>
                'LeapYear\Controller\YearController::jumpAction',)));
    $routes->add('tag_id', new Routing\Route(
        '/tag/{id}',
        array('id' => 1,
               '_controller' =>
                'LeapYear\Controller\YearController::crawlAction',)));
