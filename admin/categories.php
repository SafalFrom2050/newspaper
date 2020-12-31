<?php
    include 'header.php';
?>

<?php
    if(isset($_POST['submit'])){
        $categoryObj = new Category();
        $categoryObj->createCategory($_POST['category']);
    }
?>

<article>
    <h2>
        <a href="/admin">Back</a>
        Manage Categories
    </h2>

    <div class="category-list">
        <?php
            $categoryObj = new Category();
            $categories = array();
            $categories = $categoryObj->getListOfCategories();

            foreach($categories as $category){
                echo '<div class="edit-category-list-item">';
                echo '<h3>'.$category->getName().
                        '<a href="/admin/edit-category.php?category_id='.$category->category_id.'">Edit</a>
                    </h3>';
                
                echo '</div>';
            }
        ?>
    </div>
    <h3>Add New</h3>
    <form method="POST" class="add-category">
        <input type="text" name="category" placeholder="Category title...">
        <input type="submit" name="submit" value="Add">
    </form>
</article>

<?php
    include 'footer.php';
?>