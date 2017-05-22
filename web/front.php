<?php
    require_once __DIR__.'/../vendor/autoload.php';

    use Symfony\Component\HttpFoundation;
    use Symfony\Component\Routing;
    use Symfony\Component\HttpKernel;
    use Simplex\Framework;
    require_once 'YearController.php';

    $request = HttpFoundation\Request::createFromGlobals();
    $controllerResolver = new HttpKernel\Controller\ControllerResolver();
    $argumentResolver = new HttpKernel\Controller\ArgumentResolver();

    $routes = new Routing\RouteCollection();
    $routes->add('leap_year', new Routing\Route(
        '/is_leap_year/{year}',
            array('year' => 2016,
                  '_controller' => 'YearController::leapAction',)));

    $content = new Routing\RequestContext($request);
    $matcher = new Routing\Matcher\UrlMatcher($routes, $content);

    $simplex = new Framework($matcher, $controllerResolver, $argumentResolver);
    $response = $simplex->handle($request);

    $response->send();


function is_leap_year($year){
    return $year%4 == 0;
}
