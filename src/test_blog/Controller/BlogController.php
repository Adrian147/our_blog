<?php
namespace TestBlog\Controller;


use Symfony\Component\HttpFoundation;
use TestBlog\Model\DBModel;
use TestBlog\Model\BlogModel;
use PDO;

//Need to change respose value.
//Accomadate for Response Objects and render arrays.
//tags aren't properly returned.
//Need format for page render array.
//need to add server address to page to render array.
//check if data exists in database.

class BlogController{
    function blogpostAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        $post = DBModel::get_post_by_id($id);
        $tag_ids = DBModel::get_tags_by_blog_id($id);
        $tags = BlogModel::tags_from_tag_ids($tag_ids);
        $render_array = BlogModel::page_to_render_array($post, $tags);
        return $render_array;
    }

    function bloglistAction(HttpFoundation\Request $request){
        $post = DBModel::get_blog_entries();
        $render_array = BlogModel::table_to_render_array($post, 'Blog Posts');
        return $render_array;
    }

    //need to check for wrong id.
    //Serve the render array
    function tagstableAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        $tag = DBModel::get_tag_by_id($id);
        $blog_ids = DBModel::get_blogs_by_tag_id($id);
        $posts = BlogModel::posts_from_blog_ids($blog_ids);
        //echo json_encode($posts).'<br><br>';
        $render_array = BlogModel::tag_to_render_array($tag, $posts);
        return $render_array;
    }
}
