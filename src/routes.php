<?php
    use Symfony\Component\Routing;
    $routes->add('blog_page', new Routing\Route(
        '/blog/{id}',
        array('_controller' =>
                'TestBlog\Controller\BlogController::blogpostAction',)));
    $routes->add('blog_listing', new Routing\Route(
        '/blog',
        array('_controller' =>
                'TestBlog\Controller\BlogController::bloglistAction',)));
    $routes->add('tag_id', new Routing\Route(
        '/tag/{id}',
        array('id' => 1,
               '_controller' =>
                'TestBlog\Controller\BlogController::tagstableAction',)));
