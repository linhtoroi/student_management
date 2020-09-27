<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="navbars.css">
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
            border: 10px solid;
            border-image: url('image/b99d24f738af6f0ac9dd9d15391b8f77.jpg') 30 round;
            padding: 15px ;
            list-style-type: none;
            /* margin-top: 100px; */
            overflow: hidden;
            font-size: 100px;
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
            margin-top: 50px;
            padding: 0px;
            overflow: hidden;
            font-size: 140px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: black;
            background-color: floralwhite;
            background-image: url('image/cloud-computing.png');
            background-size: 154px 148px;
        }
        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
    </style>
</head>
<body>
    <ul>
        <li><a href='listOfUsers.php'>Homepage</a></li>
        <li><a href='exercise.php'>Exercise</a></li>
        <li style="float:right"><a href=""><form action="" method="POST" style="font-size: 0px;"><input type="submit" name="signOut" value="Sign Out" style="border:none; background-color:transparent;
            font-size: 50px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color: floralwhite;"></form></a></li>
        <li style="float:right"><a href=<?php session_start(); echo "'listOfUsers.php?account=".$_SESSION["account"]."'>";?> <?php echo $_SESSION["account"];?></a></li>
        <li><a href='listOfUsers.php'>Challenge</a></li>
    </ul>
    
    <div style="display: flex; margin-top: 200px">
        <div style="width: 30%"></div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id ="file" class="inputfile">
            <label for="file" class="label" style="width: 40%">Choose a file<img src="image/tap.png" alt="Download" width="100" height="100"></label>
        <div style="width: 30%"></div>
    </div>
    <div style="display: flex">
        <div style="width: 45%"></div>
            <input type="submit" name="up" value="__" class="button">
        </form>
    </div>
    

    <?php
    if (isset($_POST['up']) && isset($_FILES['file'])) {
        if ($_FILES['file']['error'] > 0)
        header("Location: /student_management/upload.php", true, 301);
        else {
            move_uploaded_file($_FILES['file']['tmp_name'], 'exercise/' . $_FILES['file']['name']);

            $servername = "localhost";                                                 // Khai báo database
            $database = "student_management";
            $username = "root";
            $password = ""; 
            $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
            if (!$conn) {                                                              // Check connection
                die("Connection failed: " . mysqli_connect_error());
            }

            $a = $_SESSION['account'];
            $type = $_FILES['file']['type'];
            $name = $_FILES['file']['name'];

            $sql = "INSERT INTO `exercise` (`account`, `codeOfExercise`, `summarise`, `fileName`, `fileEnding`) 
                    VALUES ('$a', NULL, 'haha', '$name', '$type')";

            if ($conn->query($sql) === TRUE)  {
                header("Location: /student_management/exercise.php", true, 301);
            } else {
                header("Location: /student_management/exercise.php", true, 301);
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
