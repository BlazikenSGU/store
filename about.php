<?php

@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>about</title>

         <!-- font awesome cnd link -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- custom css link -->
        <link rel = "stylesheet" href="css/style.css">
        

    </head>
    <body>
    <?php  include 'header.php';?>   
        <section class="about">
            <div class="row">
                <div class="box">
                    <h1 class="title">CÁC CHI NHÁNH</h1>
                    <img src="images/about1.png" alt="">
                </div>

                <div class="box2">
                    <h1 class="title">GIỚI THIỆU</h1>
                    <p>Được ra đời từ năm 2013 với định hướng trở thành một trong những cửa hàng cung cấp các sản phẩm giày đá bóng chính hãng tốt nhất Việt Nam. Thanh Hùng Futsal đã và đang nỗ lực nhằm đem lại cho khách hàng những trải nghiệm tốt nhất về chất lượng dịch vụ, cũng như đưa ra những tư vấn tận tâm để khách hàng có thể chọn lựa được cho mình những đôi giày đá banh phù hợp nhất, ưng ý nhất khi mang ra sân.</p>
                    <img src="images/about2.png" alt="">
                    <br> <br>
                    <span>
                        <strong>TẦM NHÌN</strong>
                    </span>
                    <p>Tại ThanhHung Futsal, chúng tôi luôn hướng đến việc cải tiến chất lượng trải nghiệm của khách hàng thông qua việc đa dạng hóa các loại sản phẩm, đầu tư nghiên cứu để đưa ra những tư vấn phù hợp với từng khách hàng một. Và với định hướng trở thành một trong những cửa hàng cung cấp các sản phẩm giày đá bóng chính hãng tốt nhất Việt Nam, ThanhHung Futsal luôn hướng đến những giá trị cốt lõi cho khách hàng</p>

                </div>

            </div>
        </section>

        <section class="about2">
            <h1 class="title">TRẢI NGHIỆM DỊCH VỤ MUA SẮM</h1>
            <div class="groupby">
                <div class="groupby-container">
                    <div class="item">
                        <img src="images/group1.png" alt="">
                        <h3>Tư vấn bán hàng chuyên nghiệp</h3>
                    </div>

                    <div class="item">
                        <img src="images/group2.png" alt="">
                        <h3>Hỗ trợ đo size chân cho khách hàng</h3>
                    </div>

                    <div class="item">
                        <img src="images/group3.png" alt="">
                        <h3>Quà tặng kèm khi mua giày (tất, balo)</h3>
                    </div>

                    <div class="item">
                        <img src="images/group4.png" alt="">
                        <h3>Thanh toán tiện lợi, hỗ trợ nhiều phương thức</h3>
                    </div>

                    <div class="item">
                        <img src="images/group5.png" alt="">
                        <h3>Hỗ trợ trả góp lãi suất 0% với Fundiin</h3>
                    </div>

                    <div class="item">
                        <img src="images/group6.png" alt="">
                        <h3>Giao hàng hỏa tốc cùng với Grab hoặc GHTK</h3>
                    </div>
                </div>
            </div>
        </section>

        

    <?php  include 'footer.php';?> 
        <script src="js/script.js"></script>
    </body>
</html>

