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
        <title>orders</title>

         <!-- font awesome cnd link -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <!-- custom css link -->
        <link rel = "stylesheet" href="css/style.css">
        

    </head>
    <body>
        <?php  include 'header.php';?>   
        <section class="placed-orders">
            <h1 class="title">ĐƠN HÀNG CỦA BẠN</h1>
            <div class="box-container">

                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                    $select_orders->execute([$user_id]);
                    if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){      
                ?>
                <div class="box">
                    <p> thời gian đặt: <span><?= $fetch_orders['placed_on']; ?></span> </p>
                    <p> họ tên: <span><?= $fetch_orders['name']; ?></span> </p>
                    <p> sđt: <span><?= $fetch_orders['number']; ?></span> </p>
                    <p> email: <span><?= $fetch_orders['email']; ?></span> </p>
                    <p> địa chỉ: <span><?= $fetch_orders['address']; ?></span> </p>
                    <p> phương thức thanh toán: <span><?= $fetch_orders['method']; ?></span> </p>
                    <p> thông tin đơn hàng: <span><?= $fetch_orders['total_products']; ?></span> </p>
                    <p> tổng tiền: <span><?= $fetch_orders['total_price']; ?> vnđ</span> </p>
                    <p> trạng thái đơn hàng: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>

                </div>
                <?php
                        }
                    }else{
                        echo '<p class="empty"> KHÔNG CÓ ĐƠN ĐẶT HÀNG NÀO!</p>';
                    }
                ?>

            </div>
        </section>

        <?php  include 'footer.php';?> 

        <script src="js/script.js"></script>
    </body>
</html>

