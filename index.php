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
        <title>home page</title>

         <!-- font awesome cnd link -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
         <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

        <!-- custom css link -->
        <link rel = "stylesheet" href="css/style.css">
        

    </head>
    <body>
        <?php  include 'header.php';?>   
            <section class="slideshow-header">
                <div class="slide fade">
                    <div class="number-slide">1 / 5</div>
                    <img src="images/slideshow1.jpg" style="width:100%">
                      
                </div>
                <div class="slide fade">
                    <div class="number-slide">2 / 5</div>
                    <img src="images/slideshow2.png" style="width:100%">
                </div>  
                <div class="slide fade">
                    <div class="number-slide">3 / 5</div>
                    <img src="images/slideshow3.png" style="width:100%">  
                </div>
                <div class="slide fade">
                    <div class="number-slide">4 / 5</div>
                    <img src="images/slideshow4.png" style="width:100%">
                </div>
                <div class="slide fade">
                    <div class="number-slide">5 / 5</div>
                    <img src="images/slideshow5.png" style="width:100%">  
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </section>
            <br>

            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                <span class="dot" onclick="currentSlide(5)"></span>
            </div>

            <section class="home-category">
                <h1 class="title">THƯƠNG HIỆU GIÀY NỔI TIẾNG</h1>
                <div class="box-container">
                    <div class="box">
                        <img src="images/nike.png" alt="">
                        <h3>NIKE</h3>
                        <a href="category.php?category=nike" class="btn">danh mục giày NIKE</a>
                        <p>Nike là một thương hiệu sản xuất đồ thể thao lớn nhất đến từ nước Mỹ. Hãng này sản xuất rất nhiều sản phẩm để phục vụ chơi các môn thể thao. Trong đó bóng đá là một môn thể thao được hãng này đầu tư rất nhiều (đặc biệt là giày bóng đá).</p>
                        <p>Tất cả bắt đầu vào năm 1996, khi Nike hợp tác với một trong những đội tuyển quốc gia hào hoa và nổi bật nhất thế giới, tuyển quốc gia Brazil. Trong tính toán của “the swoosh”, đó là thời điểm cần tạo ra một dòng giày mới phù hợp với tầm cỡ của đội tuyển đầy những anh tài này.</p>
                        
                    </div>
                    <div class="box">
                        <img src="images/joma.png" alt="">
                        <h3>JOMA</h3>
                        <a href="category.php?category=joma" class="btn">danh mục Giày JOMA</a>
                        <p>Được thành lập tại Tây Ban Nha vào năm 1965, Joma được biết đến như là một thương hiệu sản xuất giày thể thao chất lượng cao. JOMA TOP FLEX là một sản phẩm tiêu biểu đại diện cho thương hiệu này. Upper của JOMA Top Flex Leather được làm từ da mềm và rất dẻo, đem lại cảm giác thoải mái khi di chuyển với độ bền vượt trội. Hệ thống Pulsor phân bổ ở phía trước và phía sau, giúp hấp thụ lực khi bật nhảy và tiếp đất và hỗ trợ cho những cú bứt tốc tốt hơn. Đi kèm với đó là Technology 360, hệ thống độc quyền của JOMA SPORT với phần upper ôm vừa vặn theo bàn chân, mang lại sự ổn định cao và giảm thiểu chấn thương có thể xảy ra với bàn chân.</p>
                        
                    </div>
                    <div class="box">
                        <img src="images/logo_adidas.png" alt="">
                        <h3>ADIDAS</h3>
                        <a href="category.php?category=adidas" class="btn"> danh mục Giày ADIDAS</a>
                        <p>Adidas là một thương hiệu và biểu tượng thể thao nổi tiếng ở Đức. Adidas được thành lập vào năm 1924 bởi Adi (Adolf) Dassler và anh trai của ông là Rudolf Dassler. Là một người hâm mộ trung thành của bóng đá, quần vợt và các môn thể thao khác, Adolf Dassler đã tạo ra nhiều loại giày thể thao và quần áo tương hợp cho từng bộ môn, sở thích và nhu cầu của từng vận động viên.</p>
                        
                    </div>
                    <div class="box">
                        <img src="images/mizuno.png" alt="">
                        <h3>MIZUNO</h3>
                        <a href="category.php?category=mizuno" class="btn">danh mục Giày MIZUNO</a>
                        <p>MIZUNO được biết đến là một hãng thể thao lớn đến từ đất nước mặt trời mọc, Nhật Bản. Giày đá banh chính hãng MIZUNO sánh vai cùng ASICS là hai thương hiệu thể thao của Nhật nổi tiếng toàn thế giới, nhờ sự sáng tạo trong công nghệ và cam kết chất lượng sản phẩm hàng đầu..</p>
                        
                    </div>
                    <div class="box">
                        <img src="images/puma.png" alt="">
                        <h3>PUMA</h3>
                        <a href="category.php?category=puma" class="btn">danh mục Giày PUMA</a>
                        <p>Puma SE, được chính thức là PUMA, là một tập đoàn đa quốc gia của Đức chuyên thiết kế và sản xuất giày dép, quần áo và dụng cụ thể thao và thông thường, có trụ sở chính tại Herzogenaurach, Bavaria, Đức. Puma là nhà sản xuất đồ thể thao lớn thứ ba trên thế giới. Công ty được thành lập vào năm 1948 bởi Rudolf Dassler..</p>
                    </div>
                    <div class="box">
                        <img src="images/kamito.png" alt="">
                        <h3>KAMITO</h3>
                        <a href="category.php?category=kamito" class="btn">danh mục Giày KAMITO</a>
                        <p>Kamito là thương hiệu nổi tiếng bao gồm những sản phẩm thể thao mang đậm dấu ấn Nhật Bản, ra đời với sứ mệnh đem những giá trị cốt lõi, tinh thần Nhật Bản đến gần hơn với người tiêu dùng Việt Nam. Một trong những mẫu giày đá bóng vô cùng nổi tiếng trong giới bóng đá phong trào, được thiết kế với sự góp ý của cầu thủ Tuấn Anh - Hoàng Anh Gia Lai Việt Nam. Kamito TA11 ra đời để vinh danh cũng như ghi nhận những đóng góp đáng giá của cầu thủ Nguyễn Tuấn Anh. Giống như những mẫu giày "Signature" khác, Kamito TA11 sở hữu những đặc trưng khác biệt và thú vị liên quan đến đội trưởng của CLB Hoàng Anh Gia Lai.</p>
                    </div>
                </div>
            </section>

            <section class="products">
                <h1 class="title">SẢN PHẨM MỚI NHẤT</h1>
                <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT* FROM `products` LIMIT 4");
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

            <section class="newcare">
                <h1 class="title">BẠN ĐANG QUAN TÂM ĐẾN</h1>
                <div class="grid-container">
                    <div><img src="images/newcare1.png" alt=""></div>
                    <div><img src="images/newcare2.png" alt=""></div>
                    <div><img src="images/newcare3.png" alt=""></div>
                    <div><img src="images/newcare4.png" alt=""></div>
                </div>
            </section>






        <?php  include 'footer.php';?> 
        <script src="js/script.js"></script>
        <script src="js/slide.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="slick/slick.min.js"></script>

    </body>
</html>

