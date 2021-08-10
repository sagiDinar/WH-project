<?php

    include('connect/connectDB.php');
    $title = $price = $ingredients = '';
    $errors = array('price'=>'', 'title'=>'','ingredients'=>'');

    if(isset($_POST['submit'])){
        
        //check title
        if(empty($_POST['title'])){
            $errors['title'] = 'An title is required <br />';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] = 'Title must be letters and spaces only';
            }
        }
        //check ingredients
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'At least one ingredients is required <br />';
        } else {
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients'] = ' ingredients must be a comma separated list';
            }
        }
        //check price
        if(empty($_POST['price'])){
            $errors['price'] = 'An price is required <br />';
        } else {
            $price = $_POST['price'];
            if(!filter_var($price, FILTER_VALIDATE_INT)){
                $errors['price'] = 'price must be a valid price ';
            }
        }
        if(array_filter($errors)){
            //echo 'errors in the form';
        } else{

            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
            
            $sql = "INSERT INTO pizzas(title,ingredients,price) VALUES('$title', '$ingredients', '$price')";

            if(mysqli_query($conn, $sql)){
                //success
                header('Location: index.php');
            } else{
                //error
                echo 'query error: ' . mysqli_error($conn);
            }


            
            
        }
        
        
    } // end of POST check 
    
?>

<!DOCTYPE html>
<html>

    <?php include('templates/header.php'); ?>

    <section class="container black-text">
        <h4 class="center">Add a Pizza</h4>
        <form class="white" action="add.php" method="POST">
            <label>Your price:</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>">
            <div class="red-text"><?php echo $errors['price']; ?></div>
            <label>Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label>Ingredients (comma separated):</label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>

</html>