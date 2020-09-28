<?php
    $servername = "localhost";                                                 // Khai báo database
    $database = "student_management";
    $username = "root";
    $password = ""; 
    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
    if (!$conn) {                                                              // Check connection
        die("Connection failed: " . mysqli_connect_error());
    }
    echo $_POST['account'];
    $account = $_POST['account'];
    $passwordOfUser = $_POST['password'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];

    
    $sql = "INSERT INTO person (account, passwordOfUser) 
            VALUES ('$account', '$passwordOfUser');";                        // Truy vấn CSDL
    $sqll = "INSERT INTO student (account, email, fullName, phoneNumber) 
            VALUES ('$account', '$email', '$fullName', '$phoneNumber')";    // Truy vấn CSDL

    if ($conn->query($sql) == TRUE && $conn->query($sqll) == TRUE)  {         // Thực hiện thêm record
        echo 'hihi';
        session_start();
        $_SESSION['account'] = $account;
        $_SESSION['isTeacher'] = 0; 
        echo "thêm record thành công";
    ?>
    <script>
        location.replace("listOfUsers.php");                                // Hoàn thành thì điều hướng lại về trang riêng của account đó
    </script>
    <?php
    }else{
        echo "<a href='signUp.html'>Quay lại trang sign up, hãy tạo acccount khác</a>"
        ?>
        <script>
            //location.replace("signUp.html");                                     // Không hoàn thành thì điều hướng lại về trang edit    
        </script>
        <?php  
    }


    $conn->close();                                                             // Ngắt kết nối CSDL
?>