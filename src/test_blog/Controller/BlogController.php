<?php

namespace TestBlog\Controller;

use Symfony\Component\HttpFoundation;
use TestBlog\Model\DBModel;
use TestBlog\Model\BlogModel;
use PDO;

/**
 * Class that defines the controller for the blog application
 */
class BlogController
{
    /**
     * Handle request for a blog post of requested id (/blog/{id})
     *
     * @param Request object holding request data.
     * @return $renderArray data for a blog post or Response object if exception
     */
    public function blogpostAction(HttpFoundation\Request $request)
    {
        $id = $request->attributes->get('id');
        $post = DBModel::getPostbyId($id);
        if ($post != '') {
            $tagIds = DBModel::getTagsbyBlogId($id);
            $tags = BlogModel::tagsfromTagIds($tagIds);
            $renderArray = BlogModel::pagetoRenderArray($post, $tags);
        } else {
            $renderArray = new HttpFoundation\Response('Resource Not Found');
        }

        return $renderArray;
    }

    /**
     * Handle request for the list of all blog posts (/blog)
     *
     * @param Request object holding request data.
     * @return $renderArray data for the table or Response object if exception
     */
    public function bloglistAction(HttpFoundation\Request $request)
    {
        $post = DBModel::getBlogEntries();
        if ($post != '') {
            $renderArray = BlogModel::tabletoRenderArray($post, 'Blog Posts');
        } else {
            $renderArray = new HttpFoundation\Response('Resource Not Found');
        }

        return $renderArray;
    }

    /**
     * Handle request for blog with a specific tag id (/tag/{id})
     *
     * @param Request object holding request data.
     * @return $renderArray data for the table or Response object if exception
     */
    public function tagstableAction(HttpFoundation\Request $request)
    {
        $id = $request->attributes->get('id');
        $tag = DBModel::getTagbyId($id);
        if ($tag != '') {
            $blogIds = DBModel::getBlogsbyTagId($id);
            $posts = BlogModel::postsfromBlogIds($blogIds);
            $renderArray = BlogModel::tagtoRenderArray($tag, $posts);
        } else {
            $renderArray = new HttpFoundation\Response('Resource Not Found');
        }

        return $renderArray;
    }
}
