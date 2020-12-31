<?php

class Post extends Database{
    public $category_id;

    //Required
    public $name;
    //

    private function generateCategoriesTemplate(){
        $categoryObj = new Category();
        $categories = array();
        $categories = $categoryObj->getListOfCategories();

        $categories_template = '';
        foreach($categories as $category){
            $name = $category->getName();
            $categories_template .= '<option value="'.($name).'">';
        }
        return $categories_template;
    }

    public function generateCreatePostTemplate(){
        $categories_template = $this->generateCategoriesTemplate();

        $create_post_template = ('
            <article>
                <h2>
                    <a href="/admin">Back</a>
                    Add New Story
                </h2>
                <form method="POST" enctype="multipart/form-data">

                    <label>Title</label> <input type="text" name="title" placeholder="Article Heading"/>
                    <label>Body</label> <textarea name="body" placeholder="Start writing your awesome article!"></textarea>

                    <label>Add Image</label> <input name="image" type="file" />
                    <label>Category</label>

                    <input list="categories" name="category" id="category">
                    <datalist id="categories">
                        '.$categories_template.'
                    </datalist>


                    <label for="publish-toggle">Publish</label>
                    <input type="checkbox" name="is_published" id="publish-toggle">

                    <input type="submit" name="submit" value="Submit" />
                </form>

            </article>
        ');

        return $create_post_template;
    }


    public function generateEditPostTemplate(){
        $categories_template = $this->generateCategoriesTemplate();

        // Get the original Article
        $original_article = new Article();
        $original_article = $original_article->getArticleFromId($_GET['article_id']);

        // Now get the category name
        $categoryObj = new Category();
        $categoryObj = $categoryObj->getCategoryFromId($original_article->category_id);

        $edit_post_template = ('
            <article>
                <h2>
                    <a href="/admin/posts.php">Back</a>
                    Edit Story
                </h2>
                <form method="post" enctype="multipart/form-data">
                    
                    <!-- For passing article ID which is hidden from the user -->
                    <input type="hidden" value='.$original_article->article_id.' name="article_id"/>
                    
                    <label>Title</label> <input type="text" name="title" placeholder="Article Heading" value = "'.$original_article->title.'"/>
                    
                    <label>Body</label> 
                    <textarea name="body" placeholder="Start writing your awesome article!">'.$original_article->body.'</textarea>

                    <label>Replace Image</label> <input name="image" type="file" />
                    <label>Category</label>

                    <input list="categories" name="category" id="category" value = "'.$categoryObj->name.'">
                    <datalist id="categories">
                        '.$categories_template.'
                    </datalist>


                    <label for="publish-toggle">Publish</label>
                    <input type="checkbox" name="is_published" id="publish-toggle" checked = "'.$original_article->is_published.'">

                    <input type="submit" name="submit" value="Submit" />
                </form>

            </article>
        ');
        return $edit_post_template;
    }

    public function handlePost($edit = false){
        $title = $_POST['title'];

        //TODO Get username from user_id
        $user_id = $_SESSION['user_id'];
        
        $body = $_POST['body'];

        
        // Upload image and get the url
        $image_url = $this->handleImageUpload();
        
        $category = Category::withName($_POST['category']);

        $category_id = $category->getId();

        $is_published = isset($_POST['is_published']) ? 1 : 0;

        $article = Article::fromParameters($title, $user_id, $body, $image_url, $category_id, $is_published);

        if(!$edit){
            $article->postArticle();
        }else{
            $article_id = $_POST['article_id'];
            
            // Important For Updating Existing !!!
            $article->article_id = $article_id;
            $article->editPost();
        }
    }

    function handleImageUpload(){
        if(isset($_FILES['image'])){
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            $extensions= array("jpeg","jpg","png");
            
            if(in_array($file_ext, $extensions)=== false){
               $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > 2097152) {
               $errors[]='File size must be below 2 MB';
            }
            
            if(empty($errors)==true) {
                $path = '/uploads/images/';
    
                $file_name_new = $file_name;
                $count = 0;
                // If filename already exists, append the file count
                while(file_exists('..'.$path.$file_name_new)){
                    $file_name_new = $file_name;
                    $count += 1;
                    $name_only = pathinfo($file_name_new, PATHINFO_FILENAME);
    
                    // Renames duplicates like filename(1).png, filename(2).png...
                    $file_name_new = $name_only.'('.$count.').'.$file_ext;       
                }
    
                move_uploaded_file($file_tmp, '..'.$path.$file_name_new);
               // Success
               $imageUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$path.$file_name_new;
               return $imageUrl;
            }else{
               print_r($errors);
               return '';
            }
        }else{
            return '';
        }
    }
}

?>