<?php

namespace TestBlog\Model;


use Symfony\Component\HttpFoundation;
use TestBlog\Model\DBModel;
//Haven't checked for valid Database response.

use PDO;
class BlogModel{

    function table_to_render_array($posts, $title) {
        //constructing a page around content.
        $render_array = array(
            'type' => 'page',
            'title' => $title,
        );

        $render_array['body'] = array(array(
                        'type' => 'table',
                        'headers' => array_keys($posts[0]),
                        'rows' => array(),
                    ));
        //Setting up rows data;
        foreach($posts as $post){
            $render_array['body'][0]['rows'][] = array_values($post);
        }
        return $render_array;
    }

    function page_to_render_array($post, $tags){
        $render_array = array(
            'type' => 'page',
            'title' => $post['title'],
            'body' => $post['body'],
            'tags' => array(),
        );
        //setting up tag links
        foreach($tags as $tag){
            $render_array['tags'][] = array(
                'type' => 'link',
                'url' => 'http://localhost:4321/tag/'.$tag['id'],
                'text' => $tag['tag']
            );
        }
        return $render_array;
    }

    function tag_to_render_array($tag, $posts){
        $render_array = array(
            'type' => 'page',
            'title' => $tag['tag'],
        );

        $render_array['body'] = array(array(
                        'type' => 'table',
                        'headers' => array_keys($posts[0]),
                        'rows' => array(),
                    ));
        //Setting up rows data;
        foreach($posts as $post){
            $render_array['body'][0]['rows'][] = array_values($post);
        }
        return $render_array;
    }

    function tags_from_tag_ids($tag_ids) {
        $tags_array = DBModel::get_tag_entries();
        $tags = array();

        foreach($tag_ids as $id) {
            foreach($tags_array as $tag){
                if($tag['id'] == $id['tag_id']){
                    $tags[] = $tag;
                }
            }
        }
        return $tags;
    }

    function posts_from_blog_ids($blog_ids) {
        $posts_array = DBModel::get_blog_entries();
        $posts = array();

        //filtering entries by the blog_id
        foreach($blog_ids as $id) {
            foreach($posts_array as $post){
                if($post['id'] == $id['blog_id']){
                    $posts[] = $post;
                }
            }
        }

        return $posts;
    }
}
