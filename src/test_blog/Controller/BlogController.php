<?php

namespace TestBlog\Controller;

use Symfony\Component\HttpFoundation;
use TestBlog\Model\DBModel;
use TestBlog\Model\BlogModel;
use PDO;

class BlogController
{
    function blogpostAction(HttpFoundation\Request $request)
    {
        $id = $request->attributes->get('id');
        $post = DBModel::getPostbyId($id);
        $tagIds = DBModel::getTagsbyBlogId($id);
        $tags = BlogModel::tagsfromTagIds($tagIds);
        $renderArray = BlogModel::pagetoRenderArray($post, $tags);

        return $renderArray;
    }

    function bloglistAction(HttpFoundation\Request $request)
    {
        $post = DBModel::getBlogEntries();
        $renderArray = BlogModel::tabletoRenderArray($post, 'Blog Posts');

        return $renderArray;
    }

    function tagstableAction(HttpFoundation\Request $request)
    {
        $id = $request->attributes->get('id');
        $tag = DBModel::getTagbyId($id);
        $blogIds = DBModel::getBlogsbyTagId($id);
        $posts = BlogModel::postsfromBlogIds($blogIds);
        $renderArray = BlogModel::tagtoRenderArray($tag, $posts);

        return $renderArray;
    }
}
