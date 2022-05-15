<?php 

    if(isset($message)){
        foreach($message as $message){
            echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
            ';
        }
    }

?>

<header class="header">
    <div class="flex">
        <a href="index.php"><img src="images/logo2.png" alt="index.php"></a>
        
        <a href="index.php" class="logo">TRƯỜNG QUÂN FUTSAL</a>

        <nav class="navbar">
            <a href="index.php">Trang chủ</a>
            <a href="shop.php">Sản phẩm</a>
            <a href="orders.php">Đơn hàng</a>
            <a href="about.php">Thông tin liên hệ</a>
          
        </nav>
        
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            
            <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
                $count_cart_items->execute([$user_id]);
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id=?");
                $count_wishlist_items->execute([$user_id]);  
            ?>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $count_wishlist_items->rowCount();?>)</span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount();?>)</span></a>
        </div>

        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <p style="color: black;font-weight: 700;"><?= $fetch_profile['name']; ?></p>
            <a href="user_update_profile.php" class="btn">CẬP NHẬT THÔNG TIN</a>
            <a href="logout.php" class="delete-btn">ĐĂNG XUẤT</a>
            
        </div>

    </div>
</header>