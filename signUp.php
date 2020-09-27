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
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];

    
    
    $sql1 = "INSERT INTO person (account, passwordOfUser) 
            VALUES ('$account', '$passwordOfUser')";                        // Truy vấn CSDL
    $sql = "INSERT INTO student(account, email, fullName, phoneNumber) 
            VALUES ('$account', '$email', '$fullName', '$phoneNumber')";    // Truy vấn CSDL

if ($conn->query($sql1) === TRUE && $conn->query($sql) === TRUE)  {         // Thực hiện thêm record
    session_start();
    $_SESSION['account'] = $account;
    $_SESSION['isTeacher'] = 0;
    header("Location: /student_management/listOfUsers.php", true, 301);     // Hoàn thành thì điều hướng lại về trang riêng của account đó
    exit();
} else {
    //header("Location: /student_management/signUp.php", true, 301);          // Không hoàn thành thì điều hướng lại về trang edit    
    //exit();
    echo "Có thể do bạn tạo account trùng account đã có, hãy quay lại signUp để tạo lại nhé";   // Do điều hướng cứ bị lỗi ạ T_T                        
}   

$conn->close();                                                             // Ngắt kết nối CSDL
?>