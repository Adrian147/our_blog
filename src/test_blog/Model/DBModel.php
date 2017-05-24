<?php

namespace TestBlog\Model;

use Symfony\Component\HttpFoundation;
use PDO;

class DBModel
{
    function startDBConnection()
    {
        $conn = new PDO("mysql:host=127.0.0.1;dbname=testblog_db",
                   'root', 'qwerty123');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    function closeDBConnection(&$conn)
    {
        $conn = null;
    }

    function getBlogEntries()
    {
        try {
            $conn = DBModel::startDBConnection();
            $query = 'SELECT id, title, author_name FROM blog_entry';
            $result = $conn->query($query);

            $posts = $result->fetchAll(PDO::FETCH_ASSOC);
            DBModel::closeDBConnection($conn);

            return $posts;
        }
        catch (PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function getTagEntries()
    {
        try {
            $conn = DBModel::startDBConnection();
            $query = 'SELECT id, tag FROM tag_entries';
            $result = $conn->query($query);

            $tags = $result->fetchAll(PDO::FETCH_ASSOC);
            DBModel::closeDBConnection($conn);

            return $tags;
        }
        catch (PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function getPostbyId($id)
    {
        try {
            $conn = DBModel::startDBConnection();
            $query = 'SELECT id, title, author_name, body ';
            $query .= 'FROM blog_entry WHERE id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $post = $statement->fetch(PDO::FETCH_ASSOC);
            DBModel::closeDBConnection($conn);

            return $post;
        }
        catch (PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function getTagbyId($id)
    {
        try {
            $conn = DBModel::startDBConnection();
            $query = 'SELECT id, tag ';
            $query .= 'FROM tag_entries WHERE id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $tag = $statement->fetch(PDO::FETCH_ASSOC);
            DBModel::closeDBConnection($conn);

            return $tag;
        }
        catch (PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function getTagsbyBlogId($id)
    {
        try {
            $conn = DBModel::startDBConnection();
            $query = 'SELECT id, blog_id, tag_id ';
            $query .= 'FROM blog_tag_table WHERE blog_id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $tagIds = $statement->fetchAll(PDO::FETCH_ASSOC);
            DBModel::closeDBConnection($conn);

            return $tagIds;
        }
        catch (PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }

    function getBlogsbyTagId($id)
    {
        try {
            $conn = DBModel::startDBConnection();
            $query = 'SELECT id, blog_id, tag_id ';
            $query .= 'FROM blog_tag_table WHERE tag_id=:id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $blogIds = $statement->fetchAll(PDO::FETCH_ASSOC);
            DBModel::closeDBConnection($conn);

            return $blogIds;
        }
        catch (PDOException $e) {
            return new HttpFoundation\Response('Resource not Found', 404);
        }
    }
}
