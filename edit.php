<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="">
    <style>
    .editForm{
        padding-top: 100px;
        padding-bottom: 20px;
        height: 80%;
        border: none;
        background-color: rgb(199, 175, 175, 0.5);
    }

    .submit{
        background-color: rgb(199, 175, 175);
        color: white;
        padding: 14px 20px;
        margin-top: 100px;
        margin-bottom: 100px;
        border-color: black;
        cursor: pointer;
        border: none;
        width: 60%;
        font-size: 20px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .box{
        padding: 5px;
        margin-top: 10px;
        cursor: pointer;
        width: 60%;
        border-color: black;
        border: none;
        background-color: floralwhite;
    }

    .string{
        padding: 0;
        margin-top: 10px;
        cursor: pointer;
        width: 60%;
        font-size: 20px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
    body{
        background-color: floralwhite;
    }
    </style>
</head>
<?php 
    session_start();                                                           // Khởi tạo Sesion
    
    $servername = "localhost";                                                 // Khai báo database
    $database = "student_management";
    $username = "root";
    $password = ""; 
    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
    if (!$conn) {                                                              // Check connection
        die("Connection failed: " . mysqli_connect_error());
    }

    $a = $_SESSION['account'];                                                 // Truyền account của người dùng hiện tại vào biến
    $sql = "SELECT account, email, fullName, phoneNumber
            FROM student 
            WHERE account = '$a'";                                             // Truy vấn thông tin của account đó
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $sql1 = "SELECT passwordOfUser
            FROM person 
            WHERE account = '$a'";                                              // Truy vấn password của account đó
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

?>
<div style="display: flex">
    <div style="width:35%"></div>
    <div style="width:30%">
        <div style="height:20%"></div>
        <form action="editComplete.php" method = "POST" class="editForm">       <!--Tạo form để điền-->
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="password" class="string">Password:</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="password" id="password" name="password" class="box" value= '<?php echo $row1["passwordOfUser"]?>' ><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="email" class="string">Email:</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="text" id="email" name="email" class="box" value= '<?php echo $row["email"]?>' ><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="phoneNumber" class="string">Phone number:</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="text" id="phoneNumber" name="phoneNumber" class="box" value= '<?php echo $row["phoneNumber"]?>' ><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="submit" value="Save" class="submit">
            </div>    
        </form>
    </div>
</div>
