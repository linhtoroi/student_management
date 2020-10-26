<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="">
    <style>
        .signInForm{
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
require_once('config.php');

if(isset($_SESSION['access_token'])){
	header("Location: index.php");
	exit();
}


$redirectTo = "https://localhost:8443/student_management/fb-callback.php";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>

<div style="display: flex">
    <div style="width:35%"></div>
    <div style="width:30%">
        <div style="height:20%"></div>
        <form action="signIn.php" method = "POST" class="signInForm">       <!--Tạo form để điền-->
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="account" class="string">Account:</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="text" id="account" name="account" class="box" required><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="password" class="string">Password:</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="password" id="password" name="password" class="box" required><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="submit" value="Sign in" class="submit">
            </div>
            <div style="display:flex">
                <div style="width:30%"></div>
                <input type="button" onclick="window.location = '<?php echo $fullURL ?>'" style="border:none; background-color:transparent; color: rgb(199, 175, 175); font-size: 20px" value="Login with Facebook" >
            </div>
        </form>
    </div>
</div>