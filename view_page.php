<?php

@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name= filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price= filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image= filter_var($p_image, FILTER_SANITIZE_STRING);
    $p_size = $_POST['p_size'];
    $p_size= filter_var($p_size, FILTER_SANITIZE_STRING);
    // $p_category = $_POST['p_category '];
    // $p_category= filter_var($p_category , FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT* FROM `wishlist` WHERE size =?");
    $check_wishlist_numbers->execute([$p_size]);

    $check_cart_numbers = $conn->prepare("SELECT* FROM `cart` WHERE size =?");
    $check_cart_numbers->execute([$p_size]);

    if($check_wishlist_numbers->rowCount() > 0){
        $message[] = 'đã được thêm vào yêu thích!';
    }elseif($check_cart_numbers->rowCount() > 0){
        $message[] = 'đã được thêm vào giỏ hàng!';
    }else{
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name,size, price, image) VALUES(?,?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $p_name, $p_size, $p_price, $p_image]);
        $message[] = 'thêm thành công vào danh sách yêu thích!';
    }
}

if(isset($_POST['add_to_cart'])){
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name= filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price= filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image= filter_var($p_image, FILTER_SANITIZE_STRING);
    $p_qty = $_POST['p_qty'];
    $p_qty= filter_var($p_qty, FILTER_SANITIZE_STRING);
    $p_size = $_POST['p_size'];
    $p_size= filter_var($p_size, FILTER_SANITIZE_STRING);
    // $p_category = $_POST['p_category '];
    // $p_category= filter_var($p_category , FILTER_SANITIZE_STRING);


  

    $check_cart_numbers = $conn->prepare("SELECT* FROM `cart` WHERE size =?");
    $check_cart_numbers->execute([$p_size]);

    if($check_cart_numbers->rowCount() > 0){
        $message[] = 'đã được thêm vào giỏ hàng!';
    }else{

        $check_wishlist_numbers = $conn->prepare("SELECT* FROM `wishlist` WHERE size =?");
        $check_wishlist_numbers->execute([$p_size]);

        if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE size =?");
            $delete_wishlist->execute([$p_size]);
        }

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name,size, price,quantity, image) VALUES(?,?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $p_name,$p_size, $p_price,$p_qty, $p_image]);
        $message[] = 'Thêm vào giỏ thành công!';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>quick view</title>

         <!-- font awesome cnd link -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- custom css link -->
        <link rel = "stylesheet" href="css/style.css">
        

    </head>
    <body>
        <?php  include 'header.php';?>   
        <section class="quick-view">
                    <h1 class="title">chi tiết sản phẩm</h1>

                    <?php
                    $pid = $_GET['pid'];
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$pid]);

                    if($select_products->rowCount() > 0){
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
                    ?>
                    <form action="" class="box" method="POST">
                    <div class="price"><span><?= $fetch_products['price']; ?></span>vnđ</div>
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="details"><?= $fetch_products['details']; ?></div>
                    <select name="size" class="box1" required>
                            <option value="" selected disabled> Size</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                    </select>
                    
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                    <input type="hidden" name="p_size" value="<?= $fetch_products['size']; ?>">
                    <input type="number" min="1" value="1" name="p_qty" class="qty">
                    <input type="submit" value="Lưu danh sách yêu thích" class="option-btn" name="add_to_wishlist">
                    <input type="submit" value="thêm vào giỏ hàng" class="btn" name="add_to_cart">
                    </form>
                    <?php
                        }
                    }else{
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>

            </section>



        <?php  include 'footer.php';?> 
        <script src="js/script.js"></script>
    </body>
</html>

