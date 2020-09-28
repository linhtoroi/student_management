<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="navbars.css">
    <link rel="stylesheet" href="challenges.css">
    <style>
        body{
            background-color: floralwhite;
            margin: 0px;
        }
        .upload{
            border: none;
            list-style-type: none;
            /* margin: 10px; */
            padding: 0;
            overflow: hidden;
            font-size: 70px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: black;
            background-color: floralwhite;
            /* background: #ccc url('icon.png') no-repeat top left; */
            float: right;
            background-image:url('image/cloud-computing.png');
            background-size: 77px 74px;
        }
        .label{
            border: 7px solid;
            border-image: url('image/b99d24f738af6f0ac9dd9d15391b8f77.jpg') 30 round;
            padding: 15px ;
            width: 30%;
            list-style-type: none;
            /* margin-top: 100px; */
            overflow: hidden;
            font-size: 70px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: black;
            background-color: floralwhite;
            border-bottom-right-radius: 20px;
            border-bottom-left-radius: 20px;
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
        }
        .button{
            border: none;
            list-style-type: none;
            /* margin-left: 200px; */
            padding: 0px;
            overflow: hidden;
            font-size: 50px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: black;
            background-color: floralwhite;
            background-image: url('image/cloud-computing.png');
            background-size: 55px 55px;
        }
        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .hint{
            border: 3px solid;
            width: 40%;
            font-size: 30px;
        }
        .result{
            color: black;
            padding-top: 2px;
            margin-top: 2px;
            margin-right: 0px;
            font-size: 100px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
    </style>
</head>
<body>
    <div>
        <ul>                                                                        <!--Tạo navbar-->
            <li><a href='listOfUsers.php'>Homepage</a></li>
            <li><a href='exercise.php'>Exercise</a></li>
            <li style="float:right"><a href=""><form action="" method="POST" style="font-size: 0px;"><input type="submit" name="signOut" value="Sign Out" style="border:none; background-color:transparent;
            font-size: 50px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color: floralwhite;"></form></a></li>
            <li style="float:right"><a href=<?php session_start(); echo "'listOfUsers.php?account=".$_SESSION["account"]."'>";?> <?php echo $_SESSION["account"];?></a></li>
            <li><a href='challenge.php'>Challenge</a></li>
        </ul>
    </div>
    <?php 
        $servername = "localhost";                                                 // Khai báo database
        $database = "student_management";
        $username = "root";
        $password = ""; 
        $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
        if (!$conn) {                                                              // Check connection
            die("Connection failed: " . mysqli_connect_error());
        }

        if($_SESSION['isTeacher'] == 1){                                           // Kiểm tra account đang đăng nhập có phải là giáo viên không 
                                                                                   // để thêm chức năng tạo challenge
    ?>
            <div style="display: flex; margin-top: 50px">
                <div style="width: 35%"></div>
                <form action="" method="post" enctype="multipart/form-data" >       <!--Tạo chỗ upload file challenge-->
                    <input type="file" name="file" id="file" class="inputfile">
                    <label for="file" class="label">Choose a file <img src="image/tap.png" alt="Download" width="70" height="70"></label>
            </div>
            <div style="display: flex; margin-top: 20px">
                <div style="width: 30%"></div>
                    <input type="text" name="hint" class="hint">
            </div>
            <div style="display: flex; margin-top: 10px">
                <div style="width: 49%"></div>
                    <input type="submit" name="upChallenge" value="__" class="button">
                </form>
            </div>
    <?php    
            if (isset($_POST['upChallenge']) && isset($_FILES['file'])) {           // Nếu có $_POST và $_FILES trả giá trị về
                if ($_FILES['file']['error'] > 0)                                   // file lỗi
                    echo "Upload lỗi rồi!";
                else {
                    $sql = "SELECT COUNT(`challenge`) AS countOfChallenge
                            FROM `challenges`";                                     // Đếm số challenge có trong CSDL
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $r = mysqli_query($conn, "SHOW TABLE STATUS LIKE 'challenges'");
                    $row2 = mysqli_fetch_assoc($r);
                    $challenge = $row2['Auto_increment'];                      // Gán biến mã challenge bằng số challenge đếm được + 1
                    move_uploaded_file($_FILES['file']['tmp_name'], 'challenge/' . $challenge .'_'. $_FILES['file']['name']);     // upload file
            
                    $account = $_SESSION['account'];
                    $hint = $_POST['hint'];
            
                    $sql = "INSERT INTO `challenges` (`challenge`, `account`, `hint`) 
                            VALUES (NULL, '$account', '$hint')";                    // Thêm challenge vào CSDL

                    if ($conn->query($sql) === TRUE)  {                            
                    } else {
                    }
                }
            }
        }

        $html = '<table id="t01">';                                                 // Tạo bảng
        $html .= '<tr>';
        $html .= '<th>' . "Challenge" .'</th>';
        $html .= '<th>' . "Teacher".'</th>';
    
        if (!empty($_GET['challenge'])){                                            // Nếu có $_GET trả về ko để tạo page cho từng challenge
            $a = $_GET['challenge'];
            $html .= '<th>' . "Hint".'</th>';                                       // Bảng trong từng challenge sẽ có thêm cột Hint
            $html .= '</tr>';
            $sql = "SELECT `challenge`,`hint`, nameOfTeacher
                    FROM `challenges` a
                    JOIN teacher t
                    ON a.account = t.account
                    WHERE challenge = '$a'";                                        // Truy vấn CSDL
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $html .= '<tr>';                                                        // Tạo 1 hàng con bao gồm link trong mã số từng challenge để chuyển đến chi tiết từng challenge, tên giáo viên tạo và gợi ý
            $html .= '<td>' .'<a href="challenge.php?challenge='.$row["challenge"].'">'. $row["challenge"] .'</a>'.'</td>';
            $html .= '<td>' . $row["nameOfTeacher"] . '</td>';
            $html .= '<td>' . $row["hint"] . '</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td>Answer</td>';                                            // Tạo 1 hàng con có cột đầu là Answer, cột sau là chỗ nhập đáp án, cột cuối là submit
            $html .= '<form action="" method="POST">';
            $html .= '<td>'.'<input type="text" name="answer" class="answer">'.'</td>';
            $html .= '<td>'.'<input type="submit" name="submitAnswer" class="submitAnswer">'.'</td>';
            $html .= '</form>';
            $html .= '</tr>';
            $html .= '</table>';
            echo $html;                                                            // In bảng cho từng challenge
            if (!empty($_POST['submitAnswer'])){                                   // Nếu có giá trị $_POST trả về đã submit đáp án
   
                $str = $_POST['answer'];                    
                $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);  // Chuyển câu trả lời của sinh viên từ có dấu thành không dấu
                $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
                $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
                $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
                $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
                $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
                $str = preg_replace("/(đ)/", 'd', $str);
                $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
                $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
                $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
                $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
                $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
                $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
                $str = preg_replace("/(Đ)/", 'D', $str);
                $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
                $str = strtolower($str);                                       // Chuyển câu trả lời từ chữ hoa thành chữ thường

                $name = "";
                $path = "challenge";
                
                

                if(file_exists($path) && is_dir($path)){                        // Kiểm tra thư mục có tồn tại hay không
                    $result = scandir($path);                                   // Quét tất cả các file trong thư mục
                    $files = array_diff($result, array('.', '..'));             // Lọc ra các thư mục hiện tại (.) và các thư mục cha (..)
                    if(count($files) > 0){                                      // Lặp qua mảng đã trả lại
                        foreach($files as $file){
                            if(is_file("$path/$file")){                         // Kiểm tra đây có phải 1 file hay không

                                $pattern = "/(.*)_/";                           // Regex để lấy mã số challenge
                                $pattern2 = "/_(.*)\./";                        // Regex để lấy đáp án
                                preg_match($pattern, $file, $match);
                                preg_match($pattern2, $file, $match2);

                                if($match[1] == $_GET['challenge']){            // Kiểm tra mã số challenge có trùng không
                                    if(strtolower($match2[1]) == $str){                     // Kiểm tra có đúng đáp án không
                                        echo '<div class="result" >'."Right!!!".'</div><br>';
                                        $fileMessage = "$path/$file";                            // Tên file mò được
                                        $file = @fopen($fileMessage, 'r+');                      // Mở file gán đường dẫn vào biến $file
                                        if (!$file){                                      
                                            ?>
                                            <script>
                                                location.replace("challenge.php");
                                            </script>
                                            <?php
                                        }
                                        else {
                                            $cnt = 0;
                                            while (!feof($file)) {                                          // Đọc từng dòng trong file
                                                $string = fgets($file);
                                                //if(!feof($file))                                           // Xét xem có phải dòng cuối không, nếu đúng thì không cần cắt kí tự xuống dòng
                                                // $str = substr($string, 0, -1);                            // Cắt kí tự xuống dòng để mỗi dòng thành 1 string lời nhắn
                                                echo '<div class="result" style="font-size: 20px;" >'.$string.'</div><br>';
                                            }
                                        }  
                                    }
                                    else{
                                        echo '<div class="result" >'."Wrong!!!".'</div><br>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else{                                                                   // Nếu không có $_GET trả về ko để tạo page cho từng challenge
                                                                                // Đây là page challenge chính, liệt kê danh sách tất cả các challenge
            $sql = "SELECT `challenge`,`hint`, nameOfTeacher 
                    FROM `challenges` a
                    JOIN teacher t
                    ON a.account = t.account";                                  // Truy vấn CSDL
            $result = $conn->query($sql);                                       
            if ($result->num_rows > 0) {   
                while($row = $result->fetch_assoc()) {
                    $html .= '<tr>';                                            // Tạo ra các hàng cho từng challenge, có link đến page của từng challenge trong mã challenge
                    $html .= '<td>' .'<a href="challenge.php?challenge='.$row["challenge"].'">'. $row["challenge"] .'</a>'.'</td>';
                    $html .= '<td>' . $row["nameOfTeacher"] . '</td>';
                    $html .= '</tr>';
                }
            }
            $html .= '</table>';
            echo $html;                                                         // In bảng cho danh sách tất cả challenge
        }

        if(!empty($_POST['signOut'])){
            echo "lalalal";
            if($conn)
                mysqli_close($conn);                                                          // Đóng CSDL
            session_destroy();
            ?>
            <script>
                location.replace("signIn.html");
            </script>
            <?php
        }
    ?>
</body>