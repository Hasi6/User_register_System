<?php 
	$con = mysqli_connect("localhost", "root", "", "se_socail_media");
	if(mysqli_connect_errno()){
		echo "failed to Connect:" .mysqli_connect_errno();
	}
	$query = mysqli_query($con, "INSERT INTO test VALUES('2','Tiro')");
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome To SE Social Meadia Site</title>
</head>
<body>

</body>
</html>