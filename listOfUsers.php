<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mains.css">
    <link rel="stylesheet" href="navbars.css">
    <link rel="stylesheet" href="listOfUsers.css">
</head>
<body>
    <div>
        <ul>
            <li><a href='listOfUsers.php'>Homepage</a></li>
            <li><a href='exercise.php'>Exercise</a></li>
            <?php 
                session_start();
                if (!empty($_GET['account'])){
                    if($_GET['account'] != $_SESSION['account']){
                        $_SESSION['accountReceiver'] = $_GET['account'];
                        echo "<li><a href='m.php'>Message</a></li>";
                    }
                }
            ?>
            <li style="float:right"><a href=""><form action="" method="POST" style="font-size: 0px;"><input type="submit" name="signOut" value="Sign Out" style="border:none; background-color:transparent;
            font-size: 50px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color: floralwhite;"></form></a></li>
            <li style="float:right"><a href=<?php echo "'listOfUsers.php?account=".$_SESSION["account"]."'>";?> <?php echo $_SESSION["account"];?></a></li>
            <li><a href='challenge.php'>Challenge</a></li>
        </ul>
    </div>
    <div style="height:62%">
        <?php
            $servername = "localhost";                                                 // Khai báo database
            $database = "student_management";
            $username = "root";
            $password = ""; 
            $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
            if (!$conn) {                                                              // Check connection
                die("Connection failed: " . mysqli_connect_error());
            }

            if ($_SESSION['isTeacher'] == 1 && !empty($_GET['account'])){              // Nếu account hiện thời là giáo viên và đang vào trang xem riêng từng account khác     
                $a = $_GET['account'];
                $sql2 = "SELECT account
                        FROM student
                        WHERE account='$a';";
                $result = $conn->query($sql2);
                if($result->num_rows > 0){
                    echo "<div style='display:flex'><div class='edit'><a href='editForTeacher.php'><img src='image/user.png' alt='EDIT' style='width:100px;height:100px;'></a></div>"; // Sẽ có nút Edit hiện ra để chỉnh sửa
                    echo "<div class='edit'><a href='delete.php'><img src='image/settings.png' alt='DELETE' style='width:100px;height:100px;'></a></div></div>";
                }
                $_SESSION['accountEdit'] = $_GET['account'];                       // Lưu account để chỉnh sửa vào $_SESSION
            }
            else if ($_SESSION['isTeacher'] == 0 && !empty($_GET['account'])){         // Nếu account hiện thời là sinh viên
                if($_GET['account'] == $_SESSION['account']){                          // và đang vào xem trang cá nhân của mình
                    echo "<div class='edit'><a href='edit.php'><img src='image/user.png' alt='EDIT' style='float:right;width:100px;height:100px;'></a></div>"; // Sẽ có nút Edit hiện ra để chỉnh sửa
                }
            }

            // if (!empty($_GET['account'])){
            //     if($_GET['account'] != $_SESSION['account']){
            //         $_SESSION['accountReceiver'] = $_GET['account'];
            //         echo "<div style='float:right' class='message'> <a href='m.php'>MESSAGE</a></div>";
            //     }
            // }

            if (empty($_GET['account'])){                                               // Nếu không có giá trị $_GET nào trả về tức là đang ở trang chủ xem danh sách tất cả
        ?>
        <div style="display: flex">
            <div style="width: 40%"></div>
            <form action="listOfUsers.php" method = "POST" class="selectButton">        <!--Các button để chọn xem danh sách-->
                <input type="submit" id="all" name="all" class = "detailButton" value="All"><!--Tất cả-->
                <input type="submit" id="student" name="student" class = "detailButton" value="Student"><!--Chỉ sinh viên-->
                <input type="submit" id="teacher" name="teacher" class = "detailButton" value="Teacher"><!--Chỉ giáo viên-->
            </form>
        </div>
        <?php 
            }
            $html = '<table id="t01">';                                                 // Tạo table hiện danh sách
            $html .= '<tr>';
            $html .= '<th>' . "Account" .'</th>';
            $html .= '<th>' . "Email".'</th>';
            $html .= '<th>' . "Full Name" .'</th>';
            $html .= '<th>' . "Phone Number" .'</th>';
            $html .= '</tr>';

            
            if (!empty($_GET['account'])){                                              // Nếu có giá trị $_GET account trả về, tức là vào trang riêng của 1 thành viên
                $html1 = '<table id="t01" style="margin-top: 200px">';                  // Tạo table riêng hiện thông tin sinh viên đó
                $html1 .= '<tr>';
                $html1 .= '<th>' . "Account" .'</th>';
                $html1 .= '<th>' . "Email".'</th>';
                $html1 .= '<th>' . "Full Name" .'</th>';
                $html1 .= '<th>' . "Phone Number" .'</th>';
                $html1 .= '</tr>';
                $a = $_GET['account'];
                $sql = "SELECT account, email, fullName, phoneNumber 
                        FROM student 
                        WHERE account = '$a'";                                          // Truy vấn CSDL lấy thông tin sinh viên đó
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    $html1 .= '<tr>';
                    $html1 .= '<td>' .'<a href="listOfUsers.php?account='.$row["account"].'">'. $row["account"] .'</a>'.'</td>';
                    $html1 .= '<td>' . $row["email"] . '</td>';
                    $html1 .= '<td>' . $row["fullName"] . '</td>';
                    $html1 .= '<td>' . $row["phoneNumber"] . '</td>';
                    $html1 .= '</tr>';
                    $html1 .= '</table>';
                    echo $html1;
                } else {
                    $sqlTeacher = "SELECT account, nameOfTeacher 
                                FROM teacher 
                                WHERE account = '$a'";
                    $result = $conn->query($sqlTeacher);
                    $row = $result->fetch_assoc();
                            $a = $row['account'];
                            $html1 .= '<tr>';
                            $html1 .= '<td>' .'<a href="listOfUsers.php?account='.$row["account"].'">'. $row["account"] .'</a>'.'</td>';
                            $html1 .= '<td>' .''. '</td>';
                            $html1 .= '<td>' . $row["nameOfTeacher"] . '</td>';
                            $html1 .= '<td>' .''. '</td>';
                            $html1 .= '</tr>';
                    $html1 .= '</table>';
                    echo $html1;
                }
            }
            else{

                $sqlStudent = "SELECT account, email, fullName, phoneNumber             
                                FROM student 
                                ORDER BY fullName ASC";                                 // Truy vấn CSDL lấy thông tin tất cả sinh viên
                $sqlTeacher = "SELECT account, nameOfTeacher 
                                FROM teacher 
                                ORDER BY nameOfTeacher ASC";                            // Truy vấn CSDL lấy thông tin tất cả giáo viên

                if (!empty($_POST['student'])){                                         // Nếu có trả về $_POST ấn button student
                    $result = $conn->query($sqlStudent);                                // thì tạo bảng danh sách sinh viên
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            $html .= '<tr>';
                            $html .= '<td>' .'<a href="listOfUsers.php?account='.$row["account"].'">'. $row["account"] .'</a>'.'</td>';
                            $html .= '<td>' . $row["email"] . '</td>';
                            $html .= '<td>' . $row["fullName"] . '</td>';
                            $html .= '<td>' . $row["phoneNumber"] . '</td>';
                            $html .= '</tr>';
                        }
                    }
                    $html .= '</table>';
                    echo $html;
                }
                else if (!empty($_POST['teacher'])){                                     // Nếu có trả về $_POST ấn button teacher
                    $htmlTC = '<table id="t01">';                                        // thì tạo bảng mới danh sách giáo viên
                    $htmlTC .= '<tr>';
                    $htmlTC .= '<th>' . "Account" .'</th>';
                    $htmlTC .= '<th>' . "Full Name" .'</th>';
                    $htmlTC .= '</tr>';
                    $result = $conn->query($sqlTeacher);
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            $a = $row['account'];
                            $htmlTC .= '<tr>';
                            $htmlTC .= '<td>' .'<a href="listOfUsers.php?account='.$row["account"].'">'. $row["account"] .'</a>'.'</td>';
                            $htmlTC .= '<td>' . $row["nameOfTeacher"] . '</td>';
                            $htmlTC .= '</tr>';
                        }
                        $htmlTC .= '</table>';
                        echo $htmlTC;
                    }
                }
                else{                                                                   // Nếu có trả về $_POST ấn button all hoặc không có
                    $result = $conn->query($sqlStudent);                                // thì tạo bảng danh sách tất cả
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            $a = $row['account'];
                            $html .= '<tr>';
                            $html .= '<td>' .'<a href="listOfUsers.php?account='.$row["account"].'">'. $row["account"] .'</a>'.'</td>';
                            $html .= '<td>' . $row["email"] . '</td>';
                            $html .= '<td>' . $row["fullName"] . '</td>';
                            $html .= '<td>' . $row["phoneNumber"] . '</td>';
                            $html .= '</tr>';
                        }
                    }
                    $result = $conn->query($sqlTeacher);
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            $a = $row['account'];
                            $html .= '<tr>';
                            $html .= '<td>' .'<a href="listOfUsers.php?account='.$row["account"].'">'. $row["account"] .'</a>'.'</td>';
                            $html .= '<td>' .''. '</td>';
                            $html .= '<td>' . $row["nameOfTeacher"] . '</td>';
                            $html .= '<td>' .''. '</td>';
                            $html .= '</tr>';
                        }
                    }
                    $html .= '</table>';
                    echo $html;
                }
                
                
            }
            if(!empty($_POST['signOut'])){                                                        // Nếu trả về $_POST sign out
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
</body>