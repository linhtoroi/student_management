<?php
session_start();

if(!isset($_SESSION['access_token'])){
	?>
            <script>
                location.replace("login.php");
            </script>
    <?php
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<title>My profile</title>
</head>
<body>
	
<div class="container" style="margin-top: 100px">
	<div class="row justify-content-center">
		<div class="col-md-3">
			<img src="<?php echo $_SESSION['userData']['picture']['url'] ?>">
		</div>

		<div class="col-md-9">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
						<td>ID</td>
						<td><?php echo $_SESSION['userData']['id'] ?></td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><?php echo $_SESSION['userData']['first_name'] ?></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><?php echo $_SESSION['userData']['last_name'] ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $_SESSION['userData']['email'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


</body>
</html>

<?php

    $servername = "localhost";                                                 // Khai báo database
    $database = "student_management";
    $username = "root";
    $password = ""; 
    $conn = mysqli_connect($servername, $username, $password, $database);      // Create connection
    if (!$conn) {                                                              // Check connection
        die("Connection failed: " . mysqli_connect_error());
    }
	$account = $_SESSION['userData']['id'];
	$email = $_SESSION['userData']['email'];
	$fullName = $_SESSION['userData']['first_name']." ".$_SESSION['userData']['last_name'];
	$_SESSION['isTeacher'] = 0; 
	$_SESSION['status'] = 1;  
	$_SESSION['account'] = $account; 
    $sql1 = "SELECT account
            FROM person";                                  
	$result = $conn->query($sql1);  
	$exsit = false;    
	if ($result->num_rows > 0) {                                               // Duyệt để so sánh account và password để tránh trường hợp hack
		while($row = $result->fetch_assoc()) {
            if ($account == $row['account']){
				echo "co";
				$exsit = true;
				?>
				<script>
					location.replace("listOfUsers.php");                                // Hoàn thành thì điều hướng lại về trang riêng của account đó
				</script>
				<?php
			}
		}
		if($exsit==false){
			echo "chua co";
			$sql = "INSERT INTO person (account, passwordOfUser) 
					VALUES ('$account', NULL);";
			$sql2 = "INSERT INTO student(account, email, fullName, phoneNumber) 
            		VALUES ('$account', '$email', '$fullName', NULL)";
			if ($conn->query($sql) == TRUE && $conn->query($sql2) == TRUE){
				?>
				<script>
					location.replace("listOfUsers.php");                                // Hoàn thành thì điều hướng lại về trang riêng của account đó
				</script>
				<?php
			}		
		}
		
	}                