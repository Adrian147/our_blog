<?php
    /**
     *  Defines the Routes for the application with their controllers.
     */
    use Symfony\Component\Routing\Route;

    $routes->add('blog_page', new Route(
        '/blog/{id}',
        array('_controller' =>
                'TestBlog\Controller\BlogController::blogpostAction',
        )
    ));
    $routes->add('blog_listing', new Route(
        '/blog',
        array('_controller' =>
                'TestBlog\Controller\BlogController::bloglistAction',
        )
    ));
    $routes->add('tag_id', new Route(
        '/tag/{id}',
        array('id' => 1,
               '_controller' =>
                'TestBlog\Controller\BlogController::tagstableAction',
        )
    ));
