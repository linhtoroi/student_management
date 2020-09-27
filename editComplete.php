<?php
    session_start();                                                           // Khởi tạo Sesion
    $a = $_SESSION['account'];                                                 // Gán account của người dùng hiện tại cần edit vào biến
    $passwordOfUser = $_POST['password'];                                      // Gán password đổi vào biến
    $email = $_POST['email'];                                                  // Gán email đổi vào biến
    $phoneNumber = $_POST['phoneNumber'];                                      // Gán phoneNumber đổi vào biến

    

    $servername = "localhost";                                                 // Khai báo database
    $database = "student_management";
    $username = "root";
    $password = ""; 
    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
    if (!$conn) {                                                              // Check connection
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql1 = "UPDATE person
            SET passwordOfUser = '$passwordOfUser'
            WHERE account = '$a';";                                            // Truy vấn CSDL
    $sql =  "UPDATE student
            SET email = '$email', phoneNumber = '$phoneNumber'
            WHERE account = '$a';";                                            // Truy vấn CSDL

    
    if ($conn->query($sql1) === TRUE && $conn->query($sql) === TRUE)  {        // Thực hiện thêm record
        header("Location: /student_management/listOfUsers.php?account=".$a, true, 301); // Hoàn thành thì điều hướng lại về trang riêng của account đó
    } else {
        header("Location: /student_management/edit.php", true, 301);           // Không hoàn thành thì điều hướng lại về trang edit
    }

    $conn->close();                                                            // Ngắt kết nối CSDL
?>