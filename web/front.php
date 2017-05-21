<?php
    require_once __DIR__.'/../vendor/autoload.php';

    use Symfony\Component\HttpFoundation;
    use Symfony\Component\Routing;
    require 'YearController.php';

    $request = HttpFoundation\Request::createFromGlobals();

    $routes = new Routing\RouteCollection();
    $content = new Routing\RequestContext($request);
    $routes->add('leap_year', new Routing\Route(
        '/is_leap_year/{year}',
            array('year' => 2016,
                  '_controller' => array(new YearController(), 'leapAction'))));

    $matcher = new Routing\Matcher\UrlMatcher($routes, $content);
    $response = new HttpFoundation\Response();
    try {
        $request->attributes->add(
                $matcher->match($request->getPathInfo()));
        $response = call_user_func($request->attributes->get('_controller'),
                    $request);

    } catch (Routing\Exception\ResourceNotFoundException $e) {
        $response->setContent("Resource not Found!");
    } catch (Exception $e) {
        $response->setContent("Another Exception!");
    }

    $response->send();


function is_leap_year($year){
    return $year%4 == 0;
}
