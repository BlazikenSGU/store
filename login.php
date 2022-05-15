<?php 

    @include 'config.php';
    session_start();

    if(isset($_POST['submit'])){
        $email= $_POST['email'];
        $email= filter_var($email, FILTER_SANITIZE_STRING);
        $pass= md5($_POST['pass']);
        $pass= filter_var($pass, FILTER_SANITIZE_STRING);

        $sql ="SELECT * FROM `users` WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $pass]);
        $rowCount = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($rowCount > 0){ 
            if($row['user_type'] == 'admin'){
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
            }elseif($row['user_type'] == 'user'){
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }else {
                $message[] = 'khong tim thay tai khoan nay!';
            }
        }else{
            $message[] = 'email hoac password nhap khong dung!';
        }
    }
?>


<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="view-port" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cnd link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css link -->
    <link rel = "stylesheet" href="css/components.css">

</head>
<body>

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

    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>ĐĂNG NHẬP</h3>          
            <input type="email" name="email" class="box" placeholder="Nhập email đăng ký tài khoản" required>
            <input type="password" name="pass" class="box" placeholder="Nhập password " required>
            <input type="submit" class="btn" name="submit" value="ĐĂNG NHẬP">

            <p>Bạn chưa có tài khoản?  <a href="register.php"> ĐĂNG KÝ NGAY</a> </p>
        </form>   

    </section>

</body>
</html>