<?php

namespace TestBlog\Model;

use Symfony\Component\HttpFoundation;
//Haven't checked for valid Database response.

use PDO;
class DBModel{
    function start_db_connection(){
        $conn = new PDO("mysql:host=127.0.0.1;dbname=testblog_db",
                   'root', 'qwerty123');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    function close_db_connection(&$conn) {
        $conn = null;
    }

    function get_blog_entries() {
        try{
            $conn = DBModel::start_db_connection();
            $query = 'SELECT id, title, author_name FROM blog_entry';
            $result = $conn->query($query);

            $posts = $result->fetchAll(PDO::FETCH_ASSOC);
            DBModel::close_db_connection($conn);

            return $posts;
        }
        catch(PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function get_tag_entries() {
        try{
            $conn = DBModel::start_db_connection();
            $query = 'SELECT id, tag FROM tag_entries';
            $result = $conn->query($query);

            $tags = $result->fetchAll(PDO::FETCH_ASSOC);
            DBModel::close_db_connection($conn);

            return $tags;
        }
        catch(PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }


    function get_post_by_id($id){
        try{
            $conn = DBModel::start_db_connection();
            $query = 'SELECT id, title, author_name, body ';
            $query .= 'FROM blog_entry WHERE id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $post = $statement->fetch(PDO::FETCH_ASSOC);
            DBModel::close_db_connection($conn);
            return $post;
        }
        catch(PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function get_tag_by_id($id){
        try{
            $conn = DBModel::start_db_connection();
            $query = 'SELECT id, tag ';
            $query .= 'FROM tag_entries WHERE id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $tag = $statement->fetch(PDO::FETCH_ASSOC);
            DBModel::close_db_connection($conn);
            return $tag;
        }
        catch(PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function get_tags_by_blog_id($id){
        try{
            $conn = DBModel::start_db_connection();
            $query = 'SELECT id, blog_id, tag_id ';
            $query .= 'FROM blog_tag_table WHERE blog_id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $tag_ids = $statement->fetchAll(PDO::FETCH_ASSOC);
            DBModel::close_db_connection($conn);
            return $tag_ids;
        }
        catch(PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function get_blogs_by_tag_id($id){
        try{
            $conn = DBModel::start_db_connection();
            $query = 'SELECT id, blog_id, tag_id ';
            $query .= 'FROM blog_tag_table WHERE tag_id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $blog_ids = $statement->fetchAll(PDO::FETCH_ASSOC);
            DBModel::close_db_connection($conn);
            return $blog_ids;
        }
        catch(PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

}
