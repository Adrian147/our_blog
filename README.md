# Our Blog
 A exercise blog application based on the Symfony framework.

## Specifics
Implement a blog application using three routes:-
- `/blog` list all the blog posts in a table.
- `/blog/{id}` return the page with the requested blog post  id.
- `/tag/{id}` return the blog posts using the respective tag.

## Usage
1. Clone the repository
2. Create a database for the application
3. create a db_config.php file with the mysql server details
4. use the `web/front.php` script

## Example `db_config.php`
Fill the `db_config_template.php` file and rename to `db_config.php`

```
<?php
    $host = '127.0.0.1';
    $db_name = 'testblog_db';
    $user = 'root';
    $passwd = 'password';
```
