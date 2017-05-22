<?php
    use Symfony\Component\Routing;
    $routes->add('leap_year', new Routing\Route(
    '/is_leap_year/{year}',
        array('year' => 2016,
              '_controller' =>
                     'LeapYear\Controller\YearController::leapAction',)));
