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

    $check_wishlist_numbers = $conn->prepare("SELECT* FROM `wishlist` WHERE  name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$p_name, $user_id]);

    $check_cart_numbers = $conn->prepare("SELECT* FROM `cart` WHERE  name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $user_id]);

    if($check_wishlist_numbers->rowCount() > 0){
        $message[] = 'STOP! đã được thêm vào yêu thích!';
    }elseif($check_cart_numbers->rowCount() > 0){
        $message[] = 'STOP! đã được thêm vào giỏ hàng!';
    }else{
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, size, price, image) VALUES(?,?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $p_name, $p_size, $p_price, $p_image]);
        $message[] = 'thêm thành công vào danh sách yêu thích!';
    }
};

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

  

    $check_cart_numbers = $conn->prepare("SELECT* FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $user_id]);

    if($check_cart_numbers->rowCount() > 0){
        $message[] = 'STOP! đã được thêm vào giỏ hàng!';
    }else{

        $check_wishlist_numbers = $conn->prepare("SELECT* FROM `wishlist` WHERE  name = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$p_name, $user_id]);

        if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE  name = ? AND user_id = ?");
            $delete_wishlist->execute([$p_name, $user_id]);
        }

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name,size, price,quantity, image) VALUES(?,?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $p_name, $p_size, $p_price, $p_qty, $p_image]);
        $message[] = 'thêm thành công vào giỏ hàng!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>shop</title>

         <!-- font awesome cnd link -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- custom css link -->
        <link rel = "stylesheet" href="css/style.css">
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
        
        

    </head>
    <body>
        <?php  include 'header.php';?>  
        
        <section class="header-shop">
                <div class="menu-bar">
                    <ul>
                        <li class="#"><a href="#">THƯƠNG HIỆU GIÀY</a><i class="fa-solid fa-angle-down"></i>
                            <div class="menu-1">
                                <ul>
                                    <li><a href="category.php?category=nike">NIKE</a></li>
                                    <li><a href="category.php?category=adidas">ADIDAS</a></li>
                                    <li><a href="category.php?category=puma">PUMA</a></li>
                                    <li><a href="category.php?category=joma">JOMA</a></li> 
                                    <li><a href="category.php?category=kamito">KAMITO</a></li>
                                    <li><a href="category.php?category=mizuno">MIZUNO</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">SIZE GIÀY</a><i class="fa-solid fa-angle-down"></i>
                            <div class="menu-1">
                                <ul>
                                    <li><a href="#">37</a></li>
                                    <li><a href="#">38</a></li>
                                    <li><a href="#">39</a></li>
                                    <li><a href="#">40</a></li> 
                                    <li><a href="#">41</a></li>
                                    <li><a href="#">42</a></li>
                                    <li><a href="#">43</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">SẮP XẾP THEO GIÁ</a><i class="fa-solid fa-angle-down"></i>
                            <div class="menu-1">
                                <ul>
                                    <li><a href="#">Tăng Dần</a><i class="fa-solid fa-arrow-up-long"></i></li>
                                    <li><a href="#">Giảm Dần</a><i class="fa-solid fa-arrow-down-long"></i></li>
                                    <li><a href="khuyenmai.php">Khuyến Mãi</a><i class="fa-solid fa-percent"></i></li>    
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">SẮP XẾP THEO NGÀY RA MẮT</a><i class="fa-solid fa-angle-down"></i>
                            <div class="menu-1">
                                <ul>
                                    <li><a href="#">Mới Nhất</a><i class="fa-solid fa-arrow-up-long"></i></li>
                                    <li><a href="#">Cũ Nhất</a><i class="fa-solid fa-arrow-down-long"></i></li>
                                    <li><a href="#">Hot Sale</a><i class="fa-brands fa-hotjar"></i></li>    
                                </ul>
                            </div>
                        </li>
                        
                    </ul>
                </div>

                <div class="pic-product">
                    <img src="images/pic_in_product.png" alt="">
                </div>
                
        </section>

        <section class="products">
                <!-- <h1 class="title">SẢN PHẨM MỚI NHẤT</h1> -->
                <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT* FROM `products` ");
                    $select_products->execute();
                    if($select_products->rowCount() > 0){
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){        
                ?>
                <form action="" class="box" method="POST">
                    <div class="price"><span><?= $fetch_products['price']; ?></span>vnđ</div>
                    <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <select name="size" class="box1" required>
                            <option value="" selected disabled> Size </option>
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
                    <input type="submit" value="Yêu thích" class="option-btn" name="add_to_wishlist">
                    <input type="submit" value="Thêm vào giỏ hàng" class="btn" name="add_to_cart">
                </form>
                <?php
                        }
                    }else{
                        echo '<p class="empty">no product added</p>';
                    }
                ?>

                </div>
            </section>



        <?php  include 'footer.php';?> 
        <script src="js/script.js"></script>
    </body>
</html>

