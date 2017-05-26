<?php

namespace TestBlog\Model;

use Symfony\Component\HttpFoundation;
use PDO;


/**
 * Define methods to interact with Database.
 */
class DBModel
{
    /**
     * Start a connection with the mysql database with credentials
     *
     * @return PDO $conn object to make database queries
     */
    public function startDBConnection()
    {
        require __DIR__.'/../../../db_config.php';
        $conn = new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $db_name),
                   $user, $passwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    /**
     * Close the database connection
     *
     * @param PDO $conn php object to make database queries
     */
    public function closeDBConnection(&$conn)
    {
        $conn = null;
    }

    /**
     * Return data for all post on the blog
     *
     * @return $posts with all blog post data
     */
    public function getBlogEntries()
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

    /**
     * Return data for all tags with ids from the database
     *
     * @return $tags array of tag data
     */
    public function getTagEntries()
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

    /**
     * Return data of a post with given id
     *
     * @param $id id of the post required
     * @return $post database query data
     */
    public function getPostbyId($id)
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

    /**
     * Return data of a tag with given id
     *
     * @param $id id of the tag required
     * @return $tag database query data
     */
    public function getTagbyId($id)
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

    /**
     * Return tag ids associated with the blog id
     *
     * @param $id blog post id
     * @return $tagIds tag ids used in the blog post
     */
    public function getTagsbyBlogId($id)
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

    /**
     * Return blog ids associated with the tag id
     *
     * @param $id tag id
     * @return $blogIds blog ids using the tag
     */
    public function getBlogsbyTagId($id)
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
