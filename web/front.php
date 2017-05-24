<?php
    /**
     * Front Controller of the Blog Application
     *
     * Takes all Request and sends back Appropriate Responses
     */
    require_once __DIR__.'/../vendor/autoload.php';

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing;
    use Symfony\Component\HttpKernel\Controller;
    use Simplex\Framework;
    use TestBlog\Controller\BlogController;

    $request = Request::createFromGlobals();
    $controllerResolver = new Controller\ControllerResolver();
    $argumentResolver = new Controller\ArgumentResolver();

    $routes = new Routing\RouteCollection();
    require __DIR__.'/../src/routes.php';

    $content = new Routing\RequestContext($request);
    $matcher = new Routing\Matcher\UrlMatcher($routes, $content);

    $framework = new Framework($matcher, $controllerResolver, $argumentResolver);
    $response = $framework->handle($request);

    $response->send();
