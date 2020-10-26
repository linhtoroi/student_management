<!--Đây là message ạ-->
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mains.css">
    <link rel="stylesheet" href="navbars.css">
    <link rel="stylesheet" href="message.css">
    <style>
        
    .message{
        color: floralwhite;
        padding-top: 2px;
        margin-top: 2px;
        margin-right: 0px;
        font-size: 24px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
    body{
        margin: 0px;
        background-color: floralwhite;
    }
    .delete{
        border: none;
        background-color: floralwhite;
    }
    .change{
        border: none;
        margin-left: 5px;
        background-color: floralwhite;
    }
    .hide{
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
        border:none;
        color:red;
    }
    .box-chat1{
        /* scroll-behavior: smooth; */
        /* height:150px; */
        overflow-y: scroll;
    }
    </style>
</head>
<body>
    <ul>
            <li><a href='listOfUsers.php'>Homepage</a></li>                                    <!--Tạo navbar-->
            <li><a href='exercise.php'>Exercise</a></li>
            <li style="float:right"><a href=""><form action="" method="POST" style="font-size: 0px;"><input type="submit" name="signOut" value="Sign Out" style="border:none; background-color:transparent;
            font-size: 50px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color: floralwhite;"></form></a></li>
            <li style="float:right"><a href=<?php session_start(); echo "'listOfUsers.php?account=".$_SESSION["account"]."'>";?> <?php echo $_SESSION["account"];?></a></li>
            <li><a href='challenge.php'>Challenge</a></li>
    </ul>
    <div class="container">                                                                    <!--Tạo 1 cái div khung để chia các vùng-->
        <div style="width: 10%"></div>
        <div class="list" style="width: 50%">
            <div class="box-chat1" style="height: 60%; overflow-y: scroll;">
                <?php
                    $servername = "localhost";                                                 // Khai báo database
                    $database = "student_management";
                    $username = "root";
                    $password = ""; 
                    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
                    if (!$conn) {                                                              // Check connection
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $account = $_SESSION['account'];                                      // Gán biến $a = giá trị account người đăng nhập hiện thời
                    $accountR = $_SESSION['accountReceiver'];                                    // Gán biến $s = giá trị account $_GET trả về
                    echo '<div class="message">'."MESSAGE to ".$accountR.':</div><br>';
                    $sql = "SELECT accountReceiver, accountSender, message 
                            FROM message 
                            WHERE accountReceiver='$accountR' AND accountSender='$account'"; // Truy vấn CSDL để lấy tên file message đã có giữa 2 account
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $file = NULL;                                                           // Biến để lát lưu đường dẫn file
                    $fileMessage = "";
                    if ($result->num_rows > 0) {                                            // Nếu đã có tên file message sẵn trong CSDL 
                        $fileMessage = $row['message'];                                     // Tên file lấy được từ CSDL
                        $file = @fopen('message/'.$fileMessage, 'r+');                      // Mở file gán đường dẫn vào biến $file
                        if (!$file)                                                         // TÍ XOÁ
                            echo "Mở file không thành công";
                        else {
                            $cnt = 0;
                            $num = 0;
                            while (!feof($file)) {                                          // Đọc từng dòng trong file
                                $string = fgets($file);
                                //if(!feof($file))                                           // Xét xem có phải dòng cuối không, nếu đúng thì không cần cắt kí tự xuống dòng
                               // $str = substr($string, 0, -1);                       // Cắt kí tự xuống dòng để mỗi dòng thành 1 string lời nhắn
                               if(!feof($file)){
                                    echo '<div style="display:flex"><div class="message">'.$string.'</div><br>';
                                    echo '<form action="" method="post" style="display:flex; margin-left:20px; margin-top: 10px">
                                    <input type="text" value="'.$num.'" name="string" class"hide" style="width: 0.1px;
                                    height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1;">
                                    <input type="submit" value="Delete" name="delete" class="delete">
                                    <input type="submit" value="Change" name="change" class="change">
                                    </form></div>';
                                    //echo $num;
                               }
                                $num++; 
                            }
                        }
                    }
                    else {                                                                  // Nếu chưa có tên file message sẵn trong CSDL
                        $fileMessage = $accountR."_".$account.".txt";                       // Tên file nếu file chưa được tạo
                        $sql = "INSERT INTO `message` (`accountReceiver`, `accountSender`, `message`, `fileEnding`) 
                                VALUES ('$accountR', '$account', '$fileMessage', 'text/plain')";    // Ghi vào CSDL
                        $conn->query($sql);  
                        $file = @fopen($fileMessage, "x+");                                 // Tạo file lưu message và gán đường dẫn vào $file
                        rename($fileMessage, 'message/'.$fileMessage);                      // Đổi tên để đổi thư mục lưu
                        $file = @fopen('message/'.$fileMessage, 'r+');                      // Lấy đường dẫn mới
                    }
                    
                    if(!empty($_POST['submitt'])) {                                          // Nếu có $_POST submit gửi tin nhắn
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $date = date('m/d/Y h:i:s a', time());
                        $m = "\n".$date;                                             
                        //fwrite($file, $m);
                        $data = $_POST['box-chat']."\n";
                        //echo "<br>".$date;
                        //echo "<br>".$data;
                        fwrite($file, $data);
                ?>
                <script>
                    location.replace("m.php");
                </script>
                <?php 
                    }
                    if(!empty($_POST['delete'])) {                                          // Nếu có $_POST delete tin nhắn
                        //echo $_POST['string'];
                        $row_number = $_POST['string'];    // Number of the line we are deleting
                        $file_out = file("message/".$fileMessage); // Read the whole file into an array

                        //Delete the recorded line
                        unset($file_out[$row_number]);

                        //Recorded in a file
                        file_put_contents("message/".$fileMessage, implode("", $file_out));
                ?>
                <script>
                    location.replace("m.php");
                </script>
                <?php        
                    }                 
                ?>
            </div>
            <div class="box-chat2" style="height:20%">
                <form action="" method="POST">
                    <input type="text" name="box-chat" class="box-chat" required>
                    <input type="submit" name="submitt" class="submitChat" value="submit">
                </form>
            </div>
        </div>
        <div style="width:2%"></div>
        <div style="width:35%"> 
            <div style="height:30%"></div>
            <div>
                <?php
                    if(!empty($_POST['change'])) {                                         // Nếu có $_POST delete tin nhắn
                        $_SESSION['row_number'] = $_POST['string'];
                        $cnt = 0;
                        
                ?>  
                    <div class="box-chat2">
                        <form action="" method="POST">
                            <input type="text" name="box-change" class="box-chat" style="height:100%" required>
                            <input type="submit" name="hihihi" class="submitChat" value="submit">
                        </form>
                    </div>  
                <?php  
                    }
                    if(!empty($_POST['hihihi'])){
                        $myFile = 'message/'.$fileMessage;
                        $row_number = $_SESSION['row_number'];
                        $data = $_POST['box-change'];
                        $lines = file($myFile);
                        $lines[$row_number] = $data."\n";
                        file_put_contents($myFile , implode("", $lines));
                ?>
                <script>
                    location.replace("m.php");
                </script>
                <?php 
                    }
                    if(!empty($_POST['signOut'])){
                        echo "lalalal";
                        if($conn)
                            mysqli_close($conn);                                                          // Đóng CSDL
                        session_destroy();
                ?>
                <script>
                    location.replace("login.php");
                </script>
                <?php   
                    }
                ?>
            </div>
        </div>
    </div>

</body>