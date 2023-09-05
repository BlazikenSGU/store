<?php

@include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $size = $_POST['size'];
    $size = filter_var($size, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    

    $image= $_FILES['image']['name'];
    $image= filter_var($image, FILTER_SANITIZE_STRING);
    $image_size= $_FILES['image']['size'];
    $image_tmp_name= $_FILES['image']['tmp_name'];
    $image_folder= 'uploaded_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'trùng tên sản phẩm đã có!';
    }else{

        $insert_products = $conn->prepare("INSERT INTO `products` (name, category, size, details, price, image) VALUE(?,?,?,?,?,?)");
        $insert_products->execute([$name, $category, $size, $details, $price, $image]);

        if($insert_products){
            if($image_size > 2000000){
                $message[] = 'image size is too large';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'thêm sản phẩm mới thành công!';
            }  
        }


    }

};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);

    $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/'.$fetch_delete_image['image']);

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart->execute([$delete_id]);

    header('location:admin_products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>admin add products</title>

        <!-- font awesome cnd link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- custom css link -->
        <link rel = "stylesheet" href="css/admin_style.css">

                
    </head>
    <body>
        <?php include 'admin_header.php'; ?>

        <section class="add-products">
            <h1 class="title">thêm sản phẩm mới</h1>
            <form action="" method="POST" enctype="multipart/form-data"> 
                <div class="flex">
                    
                    <div class="inputBOX">
                        <input type="text" name="name" class="box" required placeholder="Nhập tên sản phẩm">
                        <select name="category" class="box" required>
                            <option value="" selected disabled> Hãng giày </option>
                                <option value="adidas">ADIDAS</option>
                                <option value="nike">NIKE</option>
                                <option value="puma">PUMA</option>
                                <option value="mizuno">MIZUNO</option>
                                <option value="joma">JOMA</option>
                                <option value="kamito">KAMITO</option>
                        </select>
                        <select name="size" class="box" required>
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

                    </div>
                    
                    <div class="inputBOX">
                        <input type="number" min="0" name="price" class="box" required placeholder="Nhập giá sản phẩm">
                        <input type="file" name="image" required class="box" accept="image/.jpg, image/.jpeg, image/png">
                    </div>
                </div>
                <textarea name="details" class="box" required placeholder="Nhập mô tả về sản phẩm" cols="30" rows="10"></textarea>
                <input type="submit" class="btn" value="Thêm sản phẩm" name="add_product">
            </form>
        </section>

        <section class="show-products">

            <h1 class="title">SẢN PHẨM HIỆN ĐANG BÁN</h1>

            <div class="box-container">
                <?php
                    $show_products = $conn->prepare("SELECT * FROM `products`");
                    $show_products->execute();
                    if($show_products->rowCount() > 0){
                        while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>"alt="">
                    <div class="price"><?= $fetch_products['price']; ?>.vnđ</div>
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="cat">Hãng: <?= $fetch_products['category']; ?></div>
                    <div class="size">Size: <?= $fetch_products['size']; ?></div>
                    <div class="details"><?= $fetch_products['details']; ?></div>
                    <div class="flex-btn">
                        <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                        <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('xóa sản phẩm này ??');">delete</a>
                    </div>
                </div>
                <?php
                        }
                    }else{
                        echo '<p class="empty">Hiện tại đang trống!</p>';
                    }
                ?>

            </div>

        </section>



        <script src="js/script.js"></script>
    </body>
</html> 

