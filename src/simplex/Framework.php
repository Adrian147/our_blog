<?php
namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use TestBlog\Controller\BlogController;
//require_once __DIR__.'/../../web/YearController.php';

class Framework {
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    public function __construct(UrlMatcher $matcher,
    ControllerResolver $controllerResolver,
    ArgumentResolver $argumentResolver) {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request) {
        //return new Response('', 404);
        try {
            $this->matcher->getContext()->fromRequest($request);

            $request->attributes->add($this->matcher->match(
                $request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments =
                  $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found!!', 404);
        }   catch (Exception $e) {
            return new Response('An Error Occured!', 500);
        }
    }
}
