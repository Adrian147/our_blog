<?php
/**
 * Blog Application using the Symfony framework
*/
namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use TestBlog\Controller\BlogController;
use Render\RenderArray;

/**
  * Blog Application using the Symfony framework
  *
  * @var UrlMatcher $matcher used to match route from Request Object.
  * @var ControllerResolver $controllerResolver appoint controller for route
  * @var $ArgumentResolver $argumentResolver return argument list for controller
*/
class Framework
{
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    public function __construct(UrlMatcher $matcher, ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    /**
     * Provide a Symfony Response object for an entered Request
     *
     * @param Request $request Object containing the Request details
     * @return Response $$response Object sent back to user
     * @throws RescourceNotFoundException when requested route(url) is not found
     */
    public function handle(Request $request)
    {
        try {
            $this->matcher->getContext()->fromRequest($request);

            $request->attributes->add($this->matcher->match(
                $request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments =
                  $this->argumentResolver->getArguments($request, $controller);

            $controllerReturn = call_user_func_array($controller, $arguments);

            if ($controllerReturn instanceof Response) {
                $response = $controllerReturn;
            }else {
                $rendered = (new RenderArray())->preHandle($controllerReturn);
                $response = new Response($rendered);
            }

            return $response;
        }catch (ResourceNotFoundException $e) {
            return new Response('Not Found!!', 404);
        }   catch (Exception $e) {
            return new Response('An Error Occured!', 500);
        }
    }
}
