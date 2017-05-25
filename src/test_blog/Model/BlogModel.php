<?php

namespace TestBlog\Model;

use Symfony\Component\HttpFoundation;
use TestBlog\Model\DBModel;
use PDO;

/**
 *  Define Class with methods to Render Blog Data into Renderable Arrays
 */
class BlogModel
{
    /**
     * Create Render Array for all blog post page (/blog)
     *
     * @param $posts all the posts of the blog
     * @param $title main title to the rendered page
     * @return $renderArray array for the page
     */
    public function tabletoRenderArray($posts, $title)
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

    /**
     * Create Render Array for a blog post (/blog/{id})
     *
     * @param $post data of post of given id
     * @param $tags tag data associated with post
     * @return $renderArray array for the page rendering
     */
    public function pagetoRenderArray($post, $tags, $url)
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
                'url' => sprintf('%s/tag/%s', $url, $tag['id']),
                'text' => $tag['tag']
            );
        }

        return $renderArray;
    }

    /**
     * Create Render Array for blog entries with a tag of id (/tag/{id})
     *
     * @param $tag data of tag of given id
     * @param $posts posts data associated with the tag
     * @return $renderArray array for the page rendering
     */
    public function tagtoRenderArray($tag, $posts)
    {
        $renderArray = array(
            'type' => 'page',
            'title' => $tag['tag'],
        );
        if (count($posts) == 0) {
            $renderArray['body'] = 'Sorry, blogs are not using this tag.';
        } else {
            $renderArray['body'] = array(array(
                'type' => 'table',
                'headers' => array_keys($posts[0]),
                'rows' => array(),
            ));

            //Setting up rows data;
            foreach ($posts as $post) {
                $renderArray['body'][0]['rows'][] = array_values($post);
            }
        }
        return $renderArray;
    }

    /**
     * Return tags used by a blog post
     *
     * @param $tagIds array of tags_ids used by the blog post
     * @return $tags array for the tags for the post
     */
    public function tagsfromTagIds($tagIds)
    {
        $tagsArray = DBModel::getTagEntries();
        $tags = array();

        foreach ($tagIds as $id) {
            foreach ($tagsArray as $tag) {
                if ($tag['id'] == $id['tag_id']) {
                    $tags[] = $tag;
                }
            }
        }

        return $tags;
    }

    /**
     * Return blog posts with the given tag
     *
     * @param $blogIds array of blog ids with the given tag
     * @return $tags array for the blog data associated with tag
     */
    public function postsfromBlogIds($blogIds)
    {
        $postsArray = DBModel::getBlogEntries();
        $posts = array();

        //filtering entries by the blog_id
        foreach ($blogIds as $id) {
            foreach ($postsArray as $post) {
                if ($post['id'] == $id['blog_id']) {
                    $posts[] = $post;
                }
            }
        }

        return $posts;
    }
}
