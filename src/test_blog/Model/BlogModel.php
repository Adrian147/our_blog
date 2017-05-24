<?php

namespace TestBlog\Model;

use Symfony\Component\HttpFoundation;
use TestBlog\Model\DBModel;
//Haven't checked for valid Database response.

use PDO;
class BlogModel
{
    function tabletoRenderArray($posts, $title)
    {
        $renderArray = array(
            'type' => 'page',
            'title' => $title,
        );
        $renderArray['body'] = array(array(
            'type' => 'table',
            'headers' => array_keys($posts[0]),
            'rows' => array(),
        ));
        //Setting up rows data;
        foreach ($posts as $post) {
            $renderArray['body'][0]['rows'][] = array_values($post);
        }

        return $renderArray;
    }

    function pagetoRenderArray($post, $tags)
    {
        $renderArray = array(
            'type' => 'page',
            'title' => $post['title'],
            'body' => $post['body'],
            'tags' => array(),
        );
        //setting up tag links
        foreach ($tags as $tag) {
            $renderArray['tags'][] = array(
                'type' => 'link',
                'url' => 'http://localhost:4321/tag/'.$tag['id'],
                'text' => $tag['tag']
            );
        }

        return $renderArray;
    }

    function tagtoRenderArray($tag, $posts)
    {
        $renderArray = array(
            'type' => 'page',
            'title' => $tag['tag'],
        );

        $renderArray['body'] = array(array(
            'type' => 'table',
            'headers' => array_keys($posts[0]),
            'rows' => array(),
        ));
        //Setting up rows data;
        foreach ($posts as $post){
            $renderArray['body'][0]['rows'][] = array_values($post);
        }

        return $renderArray;
    }

    function tagsfromTagIds($tagIds)
    {
        $tagsArray = DBModel::getTagEntries();
        $tags = array();

        foreach ($tagIds as $id) {
            foreach ($tagsArray as $tag){
                if($tag['id'] == $id['tag_id']){
                    $tags[] = $tag;
                }
            }
        }

        return $tags;
    }

    function postsfromBlogIds($blogIds)
    {
        $postsArray = DBModel::getBlogEntries();
        $posts = array();

        //filtering entries by the blog_id
        foreach ($blogIds as $id) {
            foreach ($postsArray as $post){
                if($post['id'] == $id['blog_id']){
                    $posts[] = $post;
                }
            }
        }

        return $posts;
    }
}
