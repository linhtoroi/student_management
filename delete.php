<?php
    session_start();                                                           // Khởi tạo Sesion
    $a = $_SESSION['accountEdit'];                                             // Gán account cần edit vào biến

    $servername = "localhost";                                                 // Khai báo database
    $database = "student_management";
    $username = "root";
    $password = ""; 
    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
    if (!$conn) {                                                              // Check connection
        die("Connection failed: " . mysqli_connect_error());
    }

                                                 
    
    $sql1 = "DELETE  FROM person
            WHERE account='$a';";                                               // Truy vấn CSDL
    $sql =  "DELETE  FROM student
            WHERE account='$a';";                                               // Truy vấn CSDL

    if ($conn->query($sql1) === TRUE && $conn->query($sql) === TRUE)  {         // Thực hiện xoá record
        ?>
        <script>
            location.replace("listOfUsers.php");                                 // Hoàn thành thì điều hướng lại về trang chủ
        </script>
        <?php
    } else {
        ?>
        <script>
            location.replace("listOfUsers.php");                                 // Không hoàn thành thì điều hướng lại về trang chủ  
        </script>
        <?php                       
    }   

    $conn->close();                                                             // Ngắt kết nối CSDL
?>