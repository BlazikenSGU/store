<?php

@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
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

  

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $user_id]);

    if($check_cart_numbers->rowCount() > 0){
        $message[] = 'đã được thêm vào giỏ hàng!';
    }else{

        $check_wishlist_numbers = $conn->prepare("SELECT* FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$p_name, $user_id]);

        if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$p_name, $user_id]);
        }

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, size, price, quantity, image) VALUES(?,?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $p_name, $p_size, $p_price, $p_qty, $p_image]);
        $message[] = 'thêm thành công vào giỏ hàng!';
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE  id = ?");
    $delete_wishlist_item->execute([$delete_id]);
    header('location:wishlist.php');
}

if(isset($_GET['delete_all'])){
 
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE  user_id = ?");
    $delete_wishlist_item->execute([$user_id]);
    header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>wishlist</title>

         <!-- font awesome cnd link -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- custom css link -->
        <link rel = "stylesheet" href="css/style.css">
        

    </head>
    <body>
        <?php  include 'header.php';?>   
        <section class="wishlist">
            <h1 class="title">DANH SÁCH YÊU THÍCH</h1>
            <div class="box-container">
                <?php
                    $grand_total=0;
                    $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                    $select_wishlist->execute([$user_id]);
                    if($select_wishlist->rowCount() > 0){
                        while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){         
                ?>
                <form action="" method="POST" class="box">
                        <a href="wishlist.php?delete=<?= $fetch_wishlist['id'];?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
                        <a href="view_page.php?pid=<?= $fetch_wishlist['pid'];?>" class="fas fa-eye"></a>
                        
                        <img src="uploaded_img/<?= $fetch_wishlist['image'];?>" alt="">
                        <div class="name"><?= $fetch_wishlist['name'];?></div>
                        <div class="price"><?= $fetch_wishlist['price'];?>vnđ</div>
                        <select name="size" class="box1" required>
                                <option selected><?= $fetch_wishlist['size'];?></option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                        </select>
                        <input type="number" min="1" value="1" class="qty" name="p_qty">
                        <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid'];?>">
                        <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name'];?>">
                        <input type="hidden" name="p_size" value="<?= $fetch_wishlist['size'];?>">
                        <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price'];?>">
                        <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image'];?>">
                        <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn">
                </form>
                <?php
                        $grand_total +=  $fetch_wishlist['price'];
                        }
                    }else{
                        echo '<p class="empty">danh sách yêu thích trống!</p>';
                    }
                ?>
            </div>
            <div class="wishlist-total">
                    <p>TỔNG CỘNG: <span><?= $grand_total; ?></span>vnđ </p>
                    <a href="shop.php" class="option-btn">TIẾP TỤC MUA HÀNG</a>
                    <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">XÓA TẤT CẢ</a>
            </div>
        </section>
        <?php  include 'footer.php';?> 
        <script src="js/script.js"></script>
    </body>
</html>

