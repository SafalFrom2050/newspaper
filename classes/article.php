<!-- This php class wraps the database operations of articles -->
<?php

class Article extends Database
{

    //Attributes of the class

    const SORT_DEFAULT = 1, SORT_BY_POPULARITY = 0,
        SORT_BY_LATEST = 1, SORT_BY_OLDEST = 2,
        SORT_BY_LONGEST = 3, SORT_BY_SHORTEST = 4;

    public $article_id;
    public $title;
    public $post_datetime;

    //user_id
    public $user_id;
    public $author;

    public $body;
    public $is_published;
    public $category_id;
    public $image_url;
    public $views;

    public function __construct()
    {
    }

    // static instance creator
    public static function fromParameters($title, $user_id, $body, $image_url, $category_id, $is_published)
    {
        $instance = new self();

        $instance->title = $title;

        $instance->user_id = $user_id;

        // NOTE: current user_name is the author
        $user = User::withID($user_id);
        $user_name = $user->name;

        $instance->author = $user_name;

        $instance->body = $body;
        $instance->image_url = $image_url;
        $instance->category_id = $category_id;
        $instance->is_published = $is_published;

        return $instance;
    }

    // static instance creator (convert associative array to object)
    public static function fromDB($row)
    {
        $instance = new self();

        $instance->article_id = $row['article_id'];
        $instance->title = $row['title'];
        $instance->post_datetime = $row['post_datetime'];
        $instance->user_id = $row['user_id'];
        $instance->author = $row['author'];
        $instance->body = $row['body'];
        $instance->image_url = $row['image_url'];
        $instance->category_id = $row['category_id'];
        $instance->is_published = $row['is_published'];
        $instance->views = $row['views'];

        return $instance;
    }

    //setters
    public function setPublished($is_published)
    {
        $this->is_published = $is_published;
    }

    public function setImage($image_url)
    {
        $this->image_url = $image_url;
    }

    // Add view count of article
    public function addViewCount()
    {
        $sql = 'UPDATE `articles` SET `views` = `views` + 1 WHERE `article_id`=:article_id';

        $criteria = ['article_id' => $this->article_id];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }

    // return list of array of articles
    public function getListOfArticles($sort_by = self::SORT_DEFAULT, $is_published = 1)
    {
        $sql = 'SELECT * FROM `articles`';

        // Set constraint, by default only published articles are to be returned
        if ($is_published !== -1) {
            $sql .= ' WHERE is_published = ' . $is_published;
        }

        // Sorting constraint, set how to sort article list
        if ($sort_by == self::SORT_BY_POPULARITY) {
            $sql .= ' ORDER BY views DESC';
        } else if ($sort_by == self::SORT_BY_OLDEST) {
            $sql .= ' ORDER BY post_datetime ASC';
        } else if ($sort_by == self::SORT_BY_LONGEST) {
            $sql .= ' ORDER BY LENGTH(body) DESC';
        } else if ($sort_by == self::SORT_BY_SHORTEST) {
            $sql .= ' ORDER BY LENGTH(body) ASC';
        } else {
            $sql .= ' ORDER BY post_datetime DESC';
        }

        $stmp = $this->executeSql($sql);

        // Create and return array of objects
        $articles = array();
        foreach ($stmp as $row) {
            $article = Article::fromDB($row);
            $articles[] = $article;
        }
        return $articles;
    }

    // function to get list of articles from certain category
    public function getListFromCategory($category_id, $sort_by = self::SORT_DEFAULT, $is_published = 1)
    {
        // set category id as constraint
        $sql = 'SELECT * FROM `articles` WHERE `category_id`=:category_id';

        if ($is_published !== -1) {
            $sql .= ' AND is_published = ' . $is_published;
        }

        if ($sort_by == self::SORT_BY_POPULARITY) {
            $sql .= ' ORDER BY views DESC';
        } else if ($sort_by == self::SORT_BY_OLDEST) {
            $sql .= ' ORDER BY post_datetime ASC';
        } else if ($sort_by == self::SORT_BY_LONGEST) {
            $sql .= ' ORDER BY LENGTH(body) DESC';
        } else if ($sort_by == self::SORT_BY_SHORTEST) {
            $sql .= ' ORDER BY LENGTH(body) ASC';
        } else {
            $sql .= ' ORDER BY post_datetime DESC';
        }

        $criteria = ['category_id' => $category_id];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $articles = array();
        foreach ($stmp as $row) {
            $article = Article::fromDB($row);
            $articles[] = $article;
        }
        // return as array of objects
        return $articles;
    }

    // function to get list of articles from certain author
    public function getListFromAuthor($user_id, $is_published = -1)
    {
        $sql = 'SELECT * FROM `articles` WHERE `user_id`=:user_id';

        if ($is_published !== -1) {
            $sql .= ' AND is_published = ' . $is_published;
        }

        $criteria = ['user_id' => $user_id];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $articles = array();
        foreach ($stmp as $row) {
            $article = Article::fromDB($row);
            $articles[] = $article;
        }
        return $articles;
    }

    // function to get list of articles matching certain keywords
    public function searchArticles($query, $sort_by = self::SORT_DEFAULT, $is_published = 1)
    {
        $sql = 'SELECT * FROM `articles` WHERE `title` LIKE :query';

        if ($is_published !== -1) {
            $sql .= ' AND is_published = ' . $is_published;
        }

        if ($sort_by == self::SORT_BY_POPULARITY) {
            $sql .= ' ORDER BY views DESC';
        } else if ($sort_by == self::SORT_BY_OLDEST) {
            $sql .= ' ORDER BY post_datetime ASC';
        } else if ($sort_by == self::SORT_BY_LONGEST) {
            $sql .= ' ORDER BY LENGTH(body) DESC';
        } else if ($sort_by == self::SORT_BY_SHORTEST) {
            $sql .= ' ORDER BY LENGTH(body) ASC';
        } else {
            $sql .= ' ORDER BY post_datetime DESC';
        }

        // '%' important to for searching 
        $criteria = ['query' => $query . '%'];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $articles = array();
        foreach ($stmp as $row) {
            $article = Article::fromDB($row);
            $articles[] = $article;
        }
        return $articles;
    }

    // return an article matching certain article_id
    public function getArticleFromId($article_id)
    {
        $sql = 'SELECT * FROM `articles` WHERE article_id=:article_id';

        $criteria = [
            'article_id' => $article_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $row = $stmp->fetch();
        $article = Article::fromDB($row);

        return $article;
    }

    // Function to add article to database
    public function postArticle($article = null)
    {
        // if the paramater if null, use the 'self' object 
        if (is_null($article)) {
            $article = $this;
        }

        // Sql insert statement
        $sql = 'INSERT INTO `articles`(`title`, `author`, `user_id`, `body`, `image_url`, `category_id`, `is_published`)
        VALUES (:title, :author, :user_id, :body, :image_url, :category_id, :is_published)';

        $criteria = [
            'title' => $article->title,
            'author' => $article->author,
            'user_id' => $article->user_id,
            'body' => $article->body,
            'image_url' => $article->image_url,
            'category_id' => $article->category_id,
            'is_published' => $article->is_published
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        // return status
        return $stmp;
    }

    // Function to edit article to database
    public function editPost($article = null)
    {

        if (is_null($article)) {
            $article = $this;
        }

        // Validation
        if (is_null($article->article_id)) {
            echo 'Cannot Update!!! Looks like you article_ID was not included...';
            return false;
        }

        // Check if the image Url is given

        if ($article->image_url == '') {
            // Without New Image Url
            $sql = 'UPDATE `articles` SET `title`=:title, `author`=:author, `user_id`=:user_id, 
            `body`=:body, `category_id`=:category_id, `is_published`=:is_published
            WHERE `article_id`=:article_id';

            $criteria = [
                'article_id' => $article->article_id,
                'title' => $article->title,
                'author' => $article->author,
                'user_id' => $article->user_id,
                'body' => $article->body,
                'category_id' => $article->category_id,
                'is_published' => $article->is_published
            ];
        } else {
            // With New Image Url
            $sql = 'UPDATE `articles` SET `title`=:title, `author`=:author, `user_id`=:user_id, 
                    `body`=:body, `image_url`=:image_url, `category_id`=:category_id, `is_published`=:is_published
                    WHERE `article_id`=:article_id';

            $criteria = [
                'article_id' => $article->article_id,
                'title' => $article->title,
                'author' => $article->author,
                'user_id' => $article->user_id,
                'body' => $article->body,
                'image_url' => $article->image_url,
                'category_id' => $article->category_id,
                'is_published' => $article->is_published
            ];
        }
        $this->executeWithCriteria($sql, $criteria);

        return true;
    }

    // Function to delete article from database
    public function deleteArticle($article = null)
    {

        if (is_null($article)) {
            $article = $this;
        }

        $sql = 'DELETE FROM `articles` WHERE article_id=:article_id';

        $criteria = [
            'article_id' => $article->article_id
        ];

        $this->executeWithCriteria($sql, $criteria);
    }
}
