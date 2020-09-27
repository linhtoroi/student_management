<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mains.css">
    <link rel="stylesheet" href="navbars.css">
    <link rel="stylesheet" href="exercisess.css">
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

        $html = '<table id="t01">';                                                // Tạo table danh sách bài tập
        $html .= '<tr>';
        $html .= '<th>' . "Code of exercise" .'</th>';
        $html .= '<th>' . "Teacher".'</th>';
        if (!empty($_GET['codeOfExercise'])){                                       // Nếu ấn vào trang riêng của 1 bài tập
            $html .= '<th>' . "Exercise" .'</th>';
            $html .= '</tr>';
            $codeOfExercise = $_GET['codeOfExercise'];                              // Lưu code của bài tập đang xem vào biến
            $sql = "SELECT `codeOfExercise`, teacher.account, nameOfTeacher, fileName
                    FROM `exercise`
                    JOIN teacher
                    ON teacher.account = exercise.account
                    WHERE `codeOfExercise`='$codeOfExercise'";                      // Truy vấn bài tập đó trong CSDL
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $html .= '<tr>';
            $html .= '<td>' .'<a href="exercise.php?codeOfExercise='.$row["codeOfExercise"].'">'. $row["codeOfExercise"] .'</a>'.'</td>';
            $html .= '<td>' . $row["nameOfTeacher"] . '</td>';
            $html .= '<td>' . '<p><a href="download.php?file=' . urlencode($row["fileName"]) . '">Download '.$row["fileName"]
            .'<img src="image/cloud-computing (1).png" alt="Download" width="40" height="40">'.'</a></p>' . '</td>'; // Ấn vào link để download file bài tập
            $html .= '</tr>';
            $_GET['accountTeacher'] = $row['account'];                              // Lưu account teacher vào $_GET
        }
        else {                                                                      // Nếu ở trang tổng hợp tất cả danh sách bài tập
            if ($_SESSION['isTeacher'] == 1){                                       // Nếu account người dùng hiện tại là giáo viên thì sẽ có nút upload file bài tập
    ?>
                <form action="" method="POST">
                    <input type="submit" name="upload" value="__" class="upload">
                </form>
    <?php
            }
            //$html .= '<th>' . "Summarise" .'</th>';
            $html .= '</tr>';
            $sql = "SELECT `codeOfExercise`, nameOfTeacher, `summarise`
                    FROM `exercise`
                    JOIN teacher
                    ON teacher.account = exercise.account
                    ORDER BY `codeOfExercise` ASC";                                  // Truy vấn CSDL 2 bảng để lấy lập danh sách bài tập
            $result = $conn->query($sql);  
                while($row = $result->fetch_assoc()) {
                    $html .= '<tr>';
                    $html .= '<td>' .'<a href="exercise.php?codeOfExercise='.$row["codeOfExercise"].'">'. $row["codeOfExercise"] .'</a>'.'</td>';
                    $html .= '<td>' . $row["nameOfTeacher"] . '</td>';
                    //$html .= '<td>' . $row["summarise"] . '</td>';
                    $html .= '</tr>';
                }
        }
        $html .= '</table>';
        echo $html;
        if ($_SESSION['isTeacher'] == 1){                                           // Nếu account hiện thời là giáo viên
            if (!empty($_POST['upload'])){                                          // Nếu trả về giá trị $_POST upload thì điều hướng đến trang upload
                header("Location: /student_management/upload.php", true, 301);
            }
            if(!empty($_GET['accountTeacher'])){                                    // Nếu có giá trị $_GET teacher trả về tức là ta đã vào 1 trang bài tập nào đó để xem chí tiết
                if ($_GET['accountTeacher'] == $_SESSION['account']){               // Nếu account đó trùng với account người dùng bây giờ thì giáo viên đó sẽ được xem
                    $html = '<table id="t01" style="margin:-100px 175px">';         // danh sách bài làm của sinh viên mình
                    $html .= '<tr>';
                    $html .= '<th>' . "Student" .'</th>';
                    $html .= '<th>' . "Assignment".'</th>';
                    $html .= '</tr>';
                    $sql = "SELECT fullName, completedExercise, time, mark
                        FROM student
                        JOIN homework
                        ON accountStudent = account
                        WHERE `codeOfExercise`='$codeOfExercise'";                   // Truy vấn CSDL để trả về danh sách bài làm của sinh viên
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            $html .= '<tr>';
                            $html .= '<td>' . $row["fullName"] . '</td>';
                            $html .= '<td>'.'<p><a href="download.php?file=' . urlencode($row["completedExercise"]) . '">Download '.$row["completedExercise"]
                            .'<img src="image/cloud-computing (1).png" alt="Download" width="40" height="40">'.'</a></p>' . '</td>';
                            $html .= '</tr>';
                        }
                    }
                    $html .= '</table>';
                    echo $html;
                }
            }
        }
        if ($_SESSION['isTeacher'] == 0 && !empty($_GET['codeOfExercise'])){            // Nếu là sinh viên và truy cập vào trang bài tập chi tiết
            $html1 = '<table id="t01" style="margin:-100px 175px">';
            $html1 .= '<tr>';
            $html1 .= '<th>' . "Assignment".'</th>';
            $html1 .= '<th>' . "" .'</th>';
            $html1 .= '<th>' . "".'</th>';
            $html1 .= '</tr>';
            $a = $_SESSION['account'];
            $codeOfExercise = $_GET['codeOfExercise'];
            $sql = "SELECT `completedExercise`, `time`, `mark`
                    FROM `homework`
                    WHERE `accountStudent` = '$a' AND `codeOfExercise` = '$codeOfExercise'"; // Truy vấn CSDL để lấy thông tin bài làm của sinh viên
            $result = $conn->query($sql);
            if($row = $result->fetch_assoc()){
                $html1 .= '<tr>';
                $html1 .= '<td>' . '<p><a href="download.php?file=' . urlencode($row["completedExercise"]) . '">Download '.$row["completedExercise"].'<img src="image/cloud-computing (1).png" alt="Download" width="40" height="40">'.'</a></p>' . '</td>';
                $html1 .= '<form action="" method="post" enctype="multipart/form-data">'; // Form nộp lại bài cho sinh viên
                $html1 .=  '<td>' .  '<input type="file" name="file" id="file" class="inputfile">';
                $html1 .=    '<label for="file" class="button" >Change the file</label>'.
                '<img src="image/sticky-note.png" alt="Download" width="40" height="40">'.'</td>';
                $html1 .=   '<td>' . '<input type="submit" name="uploadAgain" value="Upload" class="button">'.
                '<img src="image/cloud-computing.png" alt="Download" width="40" height="40">'.'</td>';
                $html1 .= '</form>'.'</tr>';
                $html1 .= '</table>';
                echo $html1;
                if (isset($_POST['uploadAgain']) && isset($_FILES['file'])) {                          // Nếu button nộp lại bài được ấn và nhận được $_FILES
                    if ($_FILES['file']['error'] > 0){                                                 // Nếu lỗi thì điều hướng lại trang cũ
                        header("Location: /student_management/exercise.php?codeOfExercise=".$_GET["codeOfExercise"], true, 301);
                    }
                    else {                                                                             // Không lỗi
                        move_uploaded_file($_FILES['file']['tmp_name'], 'exercise/' . $_FILES['file']['name']); // Chuyển file từ đường link tạm thời vào đường link mình muốn
                        $a = $_SESSION['account'];
                        $type = $_FILES['file']['type'];
                        $name = $_FILES['file']['name'];
                        $sql="UPDATE homework
                        SET  completedExercise = '$name', fileEnding = '$type' 
                        WHERE accountStudent = '$a'";                                                  // Update lại CSDL
                        if ($conn->query($sql) === TRUE)  {                                            // Được hay không cũng điều hướng lại trang cũ
                            header("Location: /student_management/exercise.php?codeOfExercise=".$_GET["codeOfExercise"], true, 301);
                        } 
                        else {
                            header("Location: /student_management/exercise.php?codeOfExercise=".$_GET["codeOfExercise"], true, 301);
                        }    
                    }
                }
            }
            else {
                $html1 .= '<tr>';
                $html1 .= '<td>'."".'</td>';
                $html1 .= '<form action="" method="post" enctype="multipart/form-data" >';              // Form nộp bài lần đầu cho sinh viên
                $html1 .=  '<td>' .  '<input type="file" name="file" id="file" class="inputfile">';
                $html1 .=    '<label for="file" class="button" >Choose the file</label>'.
                '<img src="image/sticky-note.png" alt="Download" width="40" height="40">'.'</td>';
                $html1 .=   '<td>' . '<input type="submit" name="up1st" value="Upload" class="button">'.
                '<img src="image/cloud-computing.png" alt="Download" width="40" height="40">'.'</td>';
                $html1 .= '</form>'.'</tr>';
                $html1 .= '</table>';
                echo $html1;
                if (isset($_POST['up1st']) && isset($_FILES['file'])) {                                // Nếu button nộp bài được ấn và nhận được $_FILES
                    if ($_FILES['file']['error'] > 0){                                                 // Nếu lỗi thì điều hướng lại trang cũ
                        header("Location: /student_management/exercise.php?codeOfExercise=".$_GET["codeOfExercise"], true, 301);
                    }
                    else {                                                                             // Không lỗi
                        move_uploaded_file($_FILES['file']['tmp_name'], 'exercise/' . $_FILES['file']['name']); // Chuyển file từ đường link tạm thời vào đường link mình muốn
                        $a = $_SESSION['account'];
                        $type = $_FILES['file']['type'];
                        $name = $_FILES['file']['name'];
                        $sql = "INSERT INTO `homework` (`accountStudent`, `codeOfExercise`, `completedExercise`, `time`, `mark`, `fileEnding`) 
                                VALUES ('$a', '$codeOfExercise', '$name', current_timestamp(), NULL, '$type')"; // Update lại CSDL
                        if ($conn->query($sql) === TRUE)  {                                            // Được hay không cũng điều hướng lại trang cũ
                            header("Location: /student_management/exercise.php?codeOfExercise=".$_GET["codeOfExercise"], true, 301);
                        } 
                        else {
                            header("Location: /student_management/exercise.php?codeOfExercise=".$_GET["codeOfExercise"], true, 301);
                        }
                    
                    }
                }
            }


    }
    if(!empty($_POST['signOut'])){
        echo "lalalal";
        if($conn)
            mysqli_close($conn);                                                          // Đóng CSDL
        session_destroy();
        header("location:/student_management/signIn.html");
        exit();
    }
    ?>
</body>