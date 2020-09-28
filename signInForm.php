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
    if (!empty($_POST['sign-up'])){
        echo $_POST['sign-up'];
        ?>
        <script>
            location.replace("signUp.html");
        </script>
        <?php
    }
?>
<div style="display: flex">
    <div style="width:35%"></div>
    <div style="width:30%">
        <div style="height:20%"></div>
        <form action="signIn.php" method = "POST" class="signInForm">       <!--Tạo form để điền-->
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="account" class="string">Account</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="text" id="account" name="account" class="box" required
                <?php 
                    session_start();
                    if($_SESSION['status'] == 2){
                        $a = $_SESSION['account'];
                        echo "value='".$a."'";
                    }
                ?>><br>
            </div>
            <?php 
                if($_SESSION['status'] == 0){
                    echo '<div style="display:flex">
                            <div style="width:20%"></div>
                            <label for="account" class="string" style="color: red">This account doesn\'t existed!</label><br>
                        </div>';
                }
            ?>
            
            <div style="display:flex">
                <div style="width:20%"></div>
                <label for="password" class="string">Password</label><br>
            </div>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="password" id="password" name="password" class="box" required><br>
            </div>
            <?php 
                if($_SESSION['status'] == 2){
                    echo '<div style="display:flex">
                            <div style="width:20%"></div>
                            <label for="account" class="string" style="color: red">!Wrong password</label><br>
                        </div>';
                }
            ?>
            <div style="display:flex">
                <div style="width:20%"></div>
                <input type="submit" class = "submit" value="Sign in">
            </div>
        </form>
    <?php
        if ($_SESSION['status'] == 0){
            echo '<form action="signInForm.php" method = "POST" class="signUpButton" style="margin-top: -90px">
                    <div style="display:flex">
                        <div style="width:20%"></div>
                        <input type="submit" class = "submit" name="sign-up" id="sign-up" value="Sign up" style="margin-top:-50px">
                    </div>
                </form>';
        }
    ?>
    </div>
<div>
