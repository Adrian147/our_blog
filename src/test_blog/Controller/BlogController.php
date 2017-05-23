<?php
namespace TestBlog\Controller;


use Symfony\Component\HttpFoundation;
use TestBlog\Modal\DBModal;
use TestBlog\Modal\BlogModal;
use PDO;

//Need to change respose value.
//Accomadate for Response Objects and render arrays.
//tags aren't properly returned.
//Need format for page render array.
//need to add server address to page to render array.
class BlogController{
    function blogpostAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        $post = DBModal::get_post_by_id($id);
        $tag_ids = DBModal::get_tags_by_blog_id($id);
        $tags = BlogModal::tags_from_tag_ids($tag_ids);
        $render_array = BlogModal::page_to_render_array($post, $tags);
        return new HttpFoundation\Response(json_encode($render_array));
    }

    function bloglistAction(HttpFoundation\Request $request){
        $post = DBModal::get_blog_entries();
        $render_array = BlogModal::table_to_render_array($post, 'Blog Posts');
        return new HttpFoundation\Response(json_encode($render_array));
    }

    //need to check for wrong id.
    //Serve the render array
    function tagstableAction(HttpFoundation\Request $request){
        $id = $request->attributes->get('id');
        $tag = DBModal::get_tag_by_id($id);
        $blog_ids = DBModal::get_blogs_by_tag_id($id);
        $posts = BlogModal::posts_from_blog_ids($blog_ids);
        $render_array = BlogModal::tag_to_render_array($tag, $posts);
        return new HttpFoundation\Response(json_encode($render_array));
    }
}
