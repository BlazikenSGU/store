<?php 

     include 'config.php';
    if(isset($_POST['submit'])){
        $name= $_POST['name'];
        $name= filter_var($name, FILTER_SANITIZE_STRING);
        $email= $_POST['email'];
        $email= filter_var($email, FILTER_SANITIZE_STRING);
        $pass= md5($_POST['pass']);
        $pass= filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass= md5($_POST['cpass']);
        $cpass= filter_var($cpass, FILTER_SANITIZE_STRING);

        $image= $_FILES['image']['name'];
        $image_size= $_FILES['image']['size'];
        $image_tmp_name= $_FILES['image']['tmp_name'];
        $image_folder= 'uploaded_img/'.$image;

        $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select->execute([$email]);

        if($select->rowCount() > 0){
            $message[] = 'tai khoan email da ton tai!';
        }else {
            if($pass != $cpass){
                $message[] = 'mat khau vua nhap khong khop nhau!'; 
            }else{
                $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
                $insert->execute([$name, $email, $pass, $image]);
                
                if($insert){
                    if($image_size > 2000000){
                        $message[] = 'kich thuoc anh vuot qua quy dinh !'; 
                    }else{
                        move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'dang ky tai khoan thanh cong !';
                        header('location:login.php'); 
                    }
                }
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="view-port" content="width=device-width, initial-scale=1.0">
    <title>register</title>

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
            <h3>ĐĂNG KÝ TÀI KHOẢN</h3>          
            <input type="email" name="email" class="box" placeholder="Nhập email đăng ký tài khoản" required>
            <input type="text" name="name" class="box" placeholder="Nhập họ và tên" required>
            <input type="password" name="pass" class="box" placeholder="Nhập password " required>
            <input type="password" name="cpass" class="box" placeholder="Nhập password lần nữa" required>
            <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
            <input type="submit" class="btn" name="submit" value="ĐĂNG KÝ NGAY">

            <p>Bạn đã có tài khoản?  <a href="login.php"> ĐĂNG NHẬP</a> </p>
        </form>   

    </section>

</body>
</html>