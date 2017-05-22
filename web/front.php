<?php
    require_once __DIR__.'/../vendor/autoload.php';

    use Symfony\Component\HttpFoundation;
    use Symfony\Component\Routing;
    use Symfony\Component\HttpKernel;
    use Simplex\Framework;
    use LeapYear\Controller\YearController;

    $request = HttpFoundation\Request::createFromGlobals();
    $controllerResolver = new HttpKernel\Controller\ControllerResolver();
    $argumentResolver = new HttpKernel\Controller\ArgumentResolver();

    $routes = new Routing\RouteCollection();
    require __DIR__.'/../src/routes.php';
    
    $content = new Routing\RequestContext($request);
    $matcher = new Routing\Matcher\UrlMatcher($routes, $content);

    $framework = new Framework($matcher, $controllerResolver, $argumentResolver);
    $response = $framework->handle($request);

    $response->send();
