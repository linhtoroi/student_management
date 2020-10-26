<?php

    
    $servername = "localhost";                                                 // Khai báo database
    $database = "student_management";
    $username = "root";
    $password = ""; 
    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
    if (!$conn) {                                                              // Check connection
        die("Connection failed: " . mysqli_connect_error());
    }
    $account = $_POST['account'];
    $passwordOfUser = $_POST['password'];
    
    $sql1 = "SELECT account, passwordOfUser
            FROM person";                                                      // Truy vấn CSDL để có danh sách tất cả

    $sqlTeacher = "SELECT account
                    FROM teacher
                    WHERE account='$account'";                                 // Truy vấn để xem account này có là giáo viên không
    session_start();                                                           // Khởi tạo Sesion
    $_SESSION['status'] = 0;                                                   // Tình trạng chưa tìm thấy account này trong danh sách
    $_SESSION['isTeacher'] = 0;                                                // Gán tạm không phải giáo viên
    $result = $conn->query($sql1);                                
    if ($result->num_rows > 0) {                                               // Duyệt để so sánh account và password để tránh trường hợp hack
        while($row = $result->fetch_assoc()) {
            if ($account == $row['account'] && $passwordOfUser == $row['passwordOfUser']){
                $_SESSION['status'] = 1;                                        // Tình trạng đăng nhập thành công
                $result1 = $conn->query($sqlTeacher);
                if ($result1->num_rows > 0){
                    $_SESSION['isTeacher'] = 1;                                 // Xem có phải giáo viên không để gán bằng 1
                }
                $_SESSION['account'] = $account;
                echo $row['passwordOfUser'];
                ?>
                <script>
                    location.replace("listOfUsers.php");
                </script>
                <?php // Điều hướng đến trang chủ
            }
            else if($account == $row['account'] && $passwordOfUser != $row['passwordOfUser']){
                $_SESSION['status'] = 2;                                        // Tình trạng sai mật khẩu
                $_SESSION['account'] = $account;
                ?>
                <script>
                    location.replace("login.php");                            // Điều hướng quay lại trang đăng nhập
                </script>
                <?php 
            }
        }
    }
    if ($_SESSION['status'] == 0){                                              // Tình trạng chưa tìm thấy account này trong danh sách     
        ?>
        <script>
            location.replace("signInForm.php");                                 // Điều hướng quay lại trang đăng nhập
        </script>
        <?php      
    } 

    $conn->close();                                                             // Ngắt kết nối CSDL
?>

