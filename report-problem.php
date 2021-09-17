<?php
	if(isset($_SESSION['identifier']) && $_SESSION['identifier']!=null)
	{
		//-----------------------------FAZER DEPOIS----------------------------

		if(isset($_POST["btnReport"])){
		   	echo $_POST["cnpjReport"]."<br>";
		   	echo $_POST["emailReport"];
		}
	}
	else
		header("Location: login.php");
?>