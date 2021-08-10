<?php
    include('connect/connectDB.php'); 

    $search = '';
    if(!isset($_POST['submit'])){
        $sql = 'SELECT title, ingredients, id, price FROM pizzas';
    } else {
        if(!empty($_POST['search'])){
            $search = $_POST['search'];
            $sql = "SELECT title,ingredients, price FROM pizzas WHERE title = '$search'";
        } else {
            $sql = 'SELECT title, ingredients, id, price FROM pizzas';
              }
        }   
      
    // make query & get result
    $result = mysqli_query($conn, $sql);
    

    // fetch the resulting rows as an arry 
     $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

     mysqli_free_result($result);

    // close connection
     mysqli_close($conn);

     $flag = "0";
	  
    
 ?>

 <!DOCTYPE html>
 <html>

    <?php include('templates/header.php'); ?>

        
         <h4 class="center">search your pizza from the home page: </h4>
        <form class="#fff176" action="index.php" method="POST">
            <label>search your pizza: :</label>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-2">
            </div>
        </form>
        <div class="container">
            <div class="row">

                <?php foreach($pizzas as $pizza): ?>
                    <div  class="col s6 md3">
                        <div class="card z-depth-0">
                            <div id="div1" class="card-content center">
                                <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                                <ul>
                                    <?php foreach(explode(',', $pizza['ingredients']) as $ing): ?>
                                        <li><?php echo htmlspecialchars($ing); ?></li>
                                    <?php endforeach; ?> 
                                </ul>
                            </div>
                            
                        </div>
                    </div>

                <?php endforeach; ?>

    

            </div>
        </div>

    <?php include('templates/footer.php'); ?>

</html>