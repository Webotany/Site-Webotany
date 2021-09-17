<?php
	include_once("DBConnection.php");
	if(isset($_SESSION['identifier']) && $_SESSION['identifier']!=null)
	{
		if ($_SERVER["REQUEST_METHOD"] === 'POST') {
		    if(isset($_POST["newUserName"]) && isset($_POST["newUserEmail"]) && isset($_POST["newUserPhone"]) && isset($_POST["newUserCEP"]) && isset($_FILES["newUserPhoto"]) && !empty($_POST["newUserName"]) && !empty($_POST["newUserEmail"]) && !empty($_POST["newUserPhone"]) && !empty($_POST["newUserCEP"]) && !empty($_FILES["newUserPhoto"]) && (!empty(trim($_POST["newUserName"]))) && (!empty(trim($_POST["newUserEmail"]))) && (!empty(trim($_POST["newUserPhone"]))) && (!empty(trim($_POST["newUserCEP"]))) && ($_FILES["newUserPhoto"]!=null))
		    {
		    	$newUserName = $_POST["newUserName"];
		    	$newUserEmail = $_POST["newUserEmail"];
		    	$newUserPhone = $_POST["newUserPhone"];
		    	$newUserCEP = $_POST["newUserCEP"];
		    	$newUserPhoto = $_FILES["newUserPhoto"];

		    	define('MAX_SIZE', (2 * 2048 * 2048));
			    $userDirectory = 'img/userProfiles/';
			    $photoName = $newUserPhoto['name']; 
			    $photoType = $newUserPhoto['type'];
			    $photoSize = $newUserPhoto['size'];
			    if(($photoName != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $photoType)))
			    	echo "<script>alert('Erro ao carregar a imagem');</script>";
			    else if(($photoName != "") && ($photoSize > MAX_SIZE))
			    	echo "<script>alert('A imagem não pode ser maior que 8MB');</script>";
			    else{
			    	$temp = new SplFileInfo($photoName);
			    	$photoExtension = $temp->getExtension();
			    	$photoNewName = $_SESSION['identifier'] . "." . $photoExtension;
			    	if(($photoName != "") && (move_uploaded_file($newUserPhoto['tmp_name'], $userDirectory . $photoNewName)))
			    		$uploadfile = $userDirectory . $photoNewName;
			    	else{
			    		$uploadfile = null;
			    		echo "<script>alert('Sem upload de imagem');</script>";
			    	}

			    }

		    	updateUserData($newUserName,$newUserEmail,$newUserPhone,$newUserCEP,$uploadfile);
		    	//header("Refresh: 0");
		    }
	  	}
	}
	else
		header("Location: login.php");

	/*if(isset($_SESSION['identifier']) && $_SESSION['identifier']!=null)
	{
		if ($_SERVER["REQUEST_METHOD"] === 'POST'){
			if(isset($_POST["settings"]) && $_POST["settings"]!=null){
				$settings = $_POST["settings"]; 
				for ($i = 0; $i < count($settings); $i++) { 
					if ($settings[$i]=='on1')
						setcookie('receiveEmailsPromotions','on',time()+31536000);
					else if($settings[$i]=='on2')
						setcookie('darkTheme','on',time()+31536000);
					else if($settings[$i]=='on3')
						setcookie('rememberMe','on',time()+31536000);
				}
				header("Refresh: 0");
				print_r($settings);
			}
		}
	}
	else
		header("Location: login.php");*/
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Minha Conta</title>    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Denk+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rambla:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4b44bf342d.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/script.js"></script>
    <script type="text/javascript">
    	function chooseFile(){
    		let photo = document.getElementById('defaultPhoto');
    		let file = document.getElementById('Photo');
    		file.click();
    	}

    	function differentPasswords(){
    		Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'As senhas digitadas são diferentes!',
			})
    	}

    	function incorrectPasswords(){
    		Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'A senha digitada está incorreta!',
			})
    	}

    	function deleteConfirm(){
    		Swal.fire({
			  title: 'Tem Certeza?',
			  html: "Ao desativar sua conta você não terá mais acesso ao acompanhamento exclusivo <b>Webotany</b> e perderá todos os seus dados cadastrais!",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#d33',
			  cancelButtonColor: '#3085d6',
			  confirmButtonText: '<a id="btnDeleteConfirm" href="?0f5f5c08aacf51e7855d2d438459cb6c=1">Sim</a>'
			})
    	}

		function relatoryFail(){
			Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Erro ao gerar relatório. Tente novamente!',
			})
		}

		function relatorySuccess(){
			Swal.fire({
			  icon: 'success',
			  title: 'Pronto!',
			  text: 'O relátorio foi baixado em seu aparelho!',
			})
		}
    </script>
    <style type="text/css">
	    body{
	        background-color: rgb(235,235,235);
	    }

	    h1{
	        color: white;
	        font-family: 'Denk One', sans-serif;
	    }

	    i{
	        color: white;
	    }

	    a:link{
	    	text-decoration: none;
	    }

	    a#logout{
	    	text-decoration: none;
	    	color: #636363;
	    }

	    p.menuItems{
	    	color: #636363;
	    	cursor: pointer;
	    }

	    p#plantText{
	    	margin: 0;
	    	padding: 0;
	    	font-size: 110%;
	    }

	    p#logout{
	    	margin-top: 10%;
	    	padding-top: 2%;
	    	border-width: 2px; 
	    	border-style: solid;
	    	border-right: 0; 
	    	border-bottom: 0; 
	    	border-left: 0; 
	    	border-radius: 0px;
	    	border-color: #636363;
	    }

	    form#report{
	    	padding-bottom: 0px;
	    	margin-bottom: 0px;
	    }

	    input[type='file']{
      		display: none;
      	}

	    .d-flex{
	      	width: 40vw;
	      	margin-left: 20%;
	      	height: 30%;
	    }

	    .d-block{
	      	height: 55vh;
	    }

	    .fa-search{
      		color: #387755;
      	}

      	.noItems{
      		width: 100%;
      		height: 100%;
      		max-height: 20%;
      		margin-bottom: 1%;
      		display: flex;
      		justify-content: center;
      		align-items: flex-end;
      	}

      	.noItemsText{
      		color: #ebebeb;
      		font-weight: 600;
      		font-size: 130%;
      	}

	    .row{
	        width: 100vw;
	        z-index: 0;
	    }

	    .menuItems{
	    	background-color: rgb(235,235,235);
	    	padding: 1%;
	    	padding-left: 3%;
	    	border-radius: 5px;
	    	width: 80%;
	    }	

	    .userDashboardData{
	    	margin-bottom: 5%;
	        border-right: 0;
	        border-top: 0;
	        border-left: 0;
	        border-color: #48926A;
	        width: 100%;
	        font-size: 105%;
	        outline: none;
	    } 

	    .userDeleteAccount{
	    	margin-bottom: 5%;
	        border-right: 0;
	        border-top: 0;
	        border-left: 0;
	        border-color: #48926A;
	        width: 100%;
	        font-size: 105%;
	        outline: none;
	    } 

	    .subtitle{
	    	margin-top: 5%; 
	    	margin-left: 5%;
	    	margin-bottom: 5%;
	    	color: #636363; 
	    	width: 90%; 
	    	padding-bottom: 2%; 
	    	border-width: 1px; 
	    	border-style: solid;
	    	border-right: 0; 
	    	border-top: 0; 
	    	border-left: 0; 
	    	border-color: #e5e5e5;
	    }  

	    .inputTitle{
	    	font-size: 80%;
	    }

	    .plants{
	    	width: 40%;
	    	height: auto;
        	float: left;
        	margin-bottom: 5%;
        	margin-left: 5%;
        	margin-right: 5%;
        	padding: 1%;
        	padding-left: 3%;
        	padding-right: 4%;
        	box-shadow: 0px 0px 5px gray;
        	border-radius: 5px;
        	background-color: white;
        	border-width: 15px; 
	    	border-style: solid;
	    	border-right: 0; 
	    	border-top: 0; 
	    	border-bottom: 0; 
	    	border-color: #48926A;
	    }

	    .plantImg{
	    	width: 100%;
	    	height: auto;
	    	border-radius: 5px;
	    	margin: 2%;
	    	margin-top: 1%;
	    }

	    .transactions{
	    	width: 90%;
	    	height: auto;
        	float: left;
        	margin-bottom: 5%;
        	margin-left: 5%;
        	padding: 1%;
        	padding-bottom: 0px;
        	box-shadow: 0px 0px 5px gray;
        	border-radius: 5px;
        	background-color: white;
        	border-width: 15px; 
	    	border-style: solid;
	    	border-right: 0; 
	    	border-top: 0; 
	    	border-bottom: 0; 
	    }

	    .purchaseGroup{
	    	float: left;
	    	width: 23%;
	    	border-width: 2px; 
	    	border-style: solid;
	    	border-bottom: 0; 
	    	border-top: 0; 
	    	border-left: 0; 
	    	border-color: #e5e5e5;
	    	margin-right: 2%;
	    }

	    .purchasesText{
	    	font-size: 110%;
	    	color: #636363;
	    	border-right: 2px; 
	    }

	    .plantGroup{
	    	border-width: 2px; 
	    	border-style: solid;
	    	border-right: 0; 
	    	border-top: 0; 
	    	border-left: 0; 
	    	border-color: #e5e5e5;
	    	margin-bottom: 1%;
	    	padding-bottom: 1%;
	    	margin-left: 3%;
	    }

	    .btnReport{
	    	width: 60%;
	    	margin-left: 20%;
	        margin-right: 20%;
	        margin-top: 2%;
	        margin-bottom: 1%;
	        background-image: linear-gradient(to bottom right, #56B07F, #387755);
	        border: none;
	        cursor: pointer;
	        font-weight: 500;
	        color: white;
	        border-radius: 5px;
	        height: 4%;
	        padding: 0px;
	        text-align: center;
	        outline: none;
	    }

	    .settingsText{
	    	margin-left: 1%;
	    	width: 35%;
	    	float: left;
	    	font-size: 105%;
	    	padding-top: 0px;
	    }

	    .photo{
	      	width: 30%;
	      	margin: auto;  
	      	display: flex; 
	      	justify-content: center; 
      	}

	    /*BOTÃO SWITCH - INICIO*/
	    	input[type="checkbox"]{
	    		position: relative;
	    		margin-left: 5%;
	    		margin-top: 4px;
	    		float: left;
	    		width: 40px;
	    		height: 20px;
	    		-webkit-appearance: none;
	    		background-color: #a6a6a6;
	    		outline: none;
	    		border-radius: 20px;
	    		box-shadow: inset 0 0 5px rgba(85,85,85,0.2);
	    		transition: 0.2s;
	    	}

	    	input[type="checkbox"]::before{
	    		content: '';
	    		position: absolute;
	    		width: 20px;
	    		height: 20px;
	    		border-radius: 50%;
	    		top: 0;
	    		left: 0;
	    		background-color: white;
	    		transform: scale(1.2);
	    		box-shadow: 0 2px 5px rgba(0,0,0,0.2);
	    		transition: 0.2s;
	    	}

	    	input:checked[type="checkbox"]::before{
	    		left: 20px;	
	    		/*background-color: #81cc81;*/ 		
	    	}

	    	input:checked[type="checkbox"]{
	    		background-color: green;
	    	}

	    /*BOTÃO SWITCH - FINAL*/
	    
	    #background{
	      	background-color: white;
	      	border-radius: 5px;
	      	margin-top: 9%;
	        height: 100vh;
	        margin-bottom: 8%;
	        overflow: auto;
      	}

      	#menu{
      		margin-left: 3%;
      		margin-top: 3%;
      		font-family: 'Roboto', sans-serif;
      		/*background-color: pink;*/
      	}

      	#menuIcons1{
      		margin-right: 5%;
      		color: #387755;
      	}

      	#menuIcons2{
      		margin-right: 5%;
      		color: #636363;
      	}

      	#menuIcons3{
      		margin-right: 5%;
      		color: #636363;
      	}

      	#menuIcons4{
      		margin-right: 5%;
      		color: #636363; 
      	}

      	#menuIcons5{
      		margin-right: 5%;
      		color: #636363; 
      	}

      	#menuIcons6{
      		margin-right: 5%;
      		color: #636363; 
      	}

      	#btnUpdate{
      		background-image: linear-gradient(to bottom right, #56B07F, #387755);
	        border: none;
	        cursor: pointer;
	        font-weight: 700;
	        color: white;
	        border-radius: 5px;
	        margin-top: 3%;
	        width: 70%;
	        margin-left: 15%;
	        margin-right: 15%;
	        height: 5%;
      	}

      	#btnDelete{
      		background-image: linear-gradient(to bottom right, #56B07F, #387755);
      		border-width: 0;
	        cursor: pointer;
	        font-weight: 700;
	        color: white;
	        border-radius: 5px;
	        width: 30%;
	        display: flex;
	        align-items: center;
	        justify-content: center;
	       	margin-top: 3%;
	        margin-left: 5%;
	        height: 5%;
      	}

      	#btnDeleteConfirm{
      		text-decoration: none;
      		color: white;
      		border-width: 0;
      	}

		#btnRelatory{
      		background-image: linear-gradient(to bottom right, #56B07F, #387755);
	        border: none;
	        cursor: pointer;
	        font-weight: 700;
	        color: white;
	        border-radius: 5px;
			margin-bottom: 1%;
	        width: 70%;
	        margin-left: 15%;
	        margin-right: 15%;
	        height: 5%;
      	}

      	#doubtIcon{
      		color: #636363; 
      		margin-left: 2%;
      		cursor: pointer;
      	}

      	#doubt{
      		background-color: rgb(235,235,235);
      		color: #636363;
      		width: 38%;
      		height: 22%;
      		position: absolute;
      		display: none;
      		font-size: 85%;
      		margin-left: 35%;
      		padding: 1%;
      		border-radius: 10px;
      		margin-bottom: 200%;
      	}

      	#doubt1{
      		background-color: rgb(235,235,235);
      		color: #636363;
      		width: 32%;
      		height: 20%;
      		position: absolute;
      		display: none;
      		font-size: 85%;
      		margin-left: 37%;
      		padding: 1%;
      		border-radius: 10px;
      		margin-bottom: 200%;
      	}

      	#doubt2{
      		background-color: rgb(235,235,235);
      		color: #636363;
      		width: 32%;
      		height: 16%;
      		position: absolute;
      		display: none;
      		font-size: 85%;
      		margin-left: 30%;
      		padding: 1%;
      		border-radius: 10px;
      		margin-bottom: 200%;
      	}

      	#defaultPhoto{
	      	color: #48926A;
	      	cursor: pointer;
	      	border-radius: 50%;
	      	width: 120px;
	      	height: 120px;
	      	object-fit: cover;
	    	object-position: center;
	      	transition: color .3s;
	      	transition: background .3s;
	      	margin: auto;
      	}

      	#defaultPhoto:hover{
	      	color: #387755;
	      	background-color: #ebebeb;
        }

	    @media only screen and (max-width: 600px) {
	        #navbarBottom{
	        background-color: #48926A; 
	        height: auto; 
	        box-shadow: 0px 1px 5px black;"
	      }
	    }

    </style>
</head>

<body>
    <?php
    	$navbar = ("navbar.php");
    	include($navbar);
    ?>
    <div class="row">
    	<div class="col-md-3 col-sm-11" id="menu">
    		<h2 style="margin-bottom: 20%; color: #636363;">Minha Conta</h2>
    		<p class="menuItems" id="dashboard" onclick="activateButton('dashboard','menuIcons1')" style="color: #387755; background-color: rgba(155, 201, 177, 0.3);"><i class="fas fa-chart-bar" id="menuIcons1"></i>Painel de Controle</p>
    		<p class="menuItems" id="purchases" onclick="activateButton('purchases','menuIcons2')"><i class="fas fa-tags" id="menuIcons2"></i>Minhas Compras</p>
    		<p class="menuItems" id="plants" onclick="activateButton('plants','menuIcons3')"><i class="fas fa-seedling" id="menuIcons3"></i>Minhas Plantas</p>
    		<p class="menuItems" id="settings" onclick="activateButton('settings','menuIcons4')"><i class="fas fa-cog" id="menuIcons4"></i>Configurações</p>
    		<p class="menuItems" id="delete" onclick="activateButton('delete','menuIcons5')"><i class="fas fa-user-minus" id="menuIcons5"></i>Desativar Conta</p>
    		<p class="menuItems" id="logout"><i class="fas fa-sign-out-alt" id="menuIcons6"></i><a id='logout' href="?logout=1">SAIR</a></p>
    	</div>
    	<div class="col-md-8 col-sm-11" id="background">
    		<div id="userDashboard" style="display: block;">
    			<h3 style='margin-top: 5%; margin-left: 5%; color: #636363;'>Detalhes da Conta</h3>
            	<p class='subtitle'><b>Informações Pessoais</b></p>
            	<?php userDashboard(); ?>
            </div>

    		<div id="userPurchases" style="display: none;">
	    		<h3 style='margin-top: 5%; margin-left: 5%; color: #636363;'>Detalhes das Compras</h3>
	            <div id='doubt'>Aqui estão localizadas todas as informações das transações que você fez na Webotany! <b>A borda à esquerda</b> da transação indica o status da entrega, se estiver <b style='color: #D6C01A'>amarelo</b> a sua compra está em trânsito, se estiver <b style='color: #48926A;'>verde</b> a sua compra já foi entregue!</div>
	            <p class='subtitle'><b>Informações de Transações</b><i class='fas fa-question-circle' id='doubtIcon' onmouseover='doubtOpen()' onmouseout='doubtClose()'></i></p>
	            <?php userPurchases(); ?>
	        </div>

	        <div id="userPlants" style="display: none;">
    			<h3 style='margin-top: 5%; margin-left: 5%; color: #636363;'>Detalhes das plantas</h3>
    			<div id='doubt1'>Aqui estão todas as plantas que você está acompanhando! Pata ter informações adicionais sobre a planta acesse o aplicativo da <b>Webotany</b> no seu celular ou computador</div>
            	<p class='subtitle'><b>Informações das suas Plantas</b><i class='fas fa-question-circle' id='doubtIcon' onmouseover='doubtOpen()' onmouseout='doubtClose()'></i></p>
            	<?php userPlants(); ?>
            </div>

            <div id="userSettings" style="display: none;">
    			<h3 style='margin-top: 5%; margin-left: 5%; color: #636363;'>Configurações</h3>
            	<p class='subtitle'><b>Configurações da Conta</b></p>
            	<?php userSettings(); ?>
            </div>
            <div id="userDelete" style="display: none;">
    			<h3 style='margin-top: 5%; margin-left: 5%; color: #636363;'>Desativar Conta</h3>
    			<div id='doubt2'>Aqui você pode desativar a sua conta Webotany. Uma vez desativada a conta será excluída para sempre do sistema da Webotany.</div>
            	<p class='subtitle'><b>Desativação de Conta</b><i class='fas fa-question-circle' id='doubtIcon' onmouseover='doubtOpen()' onmouseout='doubtClose()'></i></p>
            	<?php userDelete(); ?>
            </div>
    	</div>
    </div>  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script> 
    <script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/script.js"></script>

    <script type="text/javascript">
    	var purchaseID;
    	function disableButton(){
    		//Resetando os botões
    		document.getElementById("dashboard").style.backgroundColor="rgb(235,235,235)";
    		document.getElementById("purchases").style.backgroundColor="rgb(235,235,235)";
    		document.getElementById("plants").style.backgroundColor="rgb(235,235,235)";
    		document.getElementById("settings").style.backgroundColor="rgb(235,235,235)";
    		document.getElementById("delete").style.backgroundColor="rgb(235,235,235)";
    		document.getElementById("dashboard").style.color="#636363";
    		document.getElementById("purchases").style.color="#636363";
    		document.getElementById("plants").style.color="#636363";
    		document.getElementById("settings").style.color="#636363";
    		document.getElementById("delete").style.color="#636363";
    		document.getElementById("menuIcons1").style.color="#636363";
    		document.getElementById("menuIcons2").style.color="#636363";
    		document.getElementById("menuIcons3").style.color="#636363";
    		document.getElementById("menuIcons4").style.color="#636363";
    		document.getElementById("menuIcons5").style.color="#636363";
    	}

    	function activateButton(id,icon){
    		disableButton();
    		document.getElementById(id).style.backgroundColor="rgba(155, 201, 177, 0.3)";
    		document.getElementById(icon).style.color="#387755";
    		document.getElementById(id).style.color="#387755";    
			
			if(id=='dashboard'){
				document.getElementById("userPurchases").style.display = "none";
				document.getElementById("userPlants").style.display = "none";
				document.getElementById("userSettings").style.display = "none";
				document.getElementById("userDelete").style.display = "none";
				document.getElementById("userDashboard").style.display = "block";
        	}
        	else if(id=='purchases'){
        		document.getElementById("userDashboard").style.display = "none";
        		document.getElementById("userPlants").style.display = "none";
        		document.getElementById("userSettings").style.display = "none";
        		document.getElementById("userDelete").style.display = "none";
        		document.getElementById("userPurchases").style.display = "block";
        	}

        	else if(id=='plants'){
        		document.getElementById("userDashboard").style.display = "none";
        		document.getElementById("userPurchases").style.display = "none";
        		document.getElementById("userSettings").style.display = "none";
        		document.getElementById("userDelete").style.display = "none";
        		document.getElementById("userPlants").style.display = "block";
        	}
        	else if(id=='settings'){
        		document.getElementById("userDashboard").style.display = "none";
        		document.getElementById("userPurchases").style.display = "none";
        		document.getElementById("userPlants").style.display = "none";
        		document.getElementById("userDelete").style.display = "none";
        		document.getElementById("userSettings").style.display = "block";
        	}
        	else if(id=='delete'){
        		document.getElementById("userDashboard").style.display = "none";
        		document.getElementById("userPurchases").style.display = "none";
        		document.getElementById("userPlants").style.display = "none";
        		document.getElementById("userSettings").style.display = "none";
        		document.getElementById("userDelete").style.display = "block";
        	}

			//document.getElementById("background").innerHTML = html;		
    	}

    	function CEPmask(evt){
	        var theEvent = evt || window.event;
	        var key = theEvent.keyCode || theEvent.which;
	        key = String.fromCharCode( key );
	        var regex = /^[0-9.]+$/;
	        if( !regex.test(key) ) {
	          theEvent.returnValue = false;
	          if(theEvent.preventDefault) theEvent.preventDefault();
	        }
	        var cep = document.getElementById("newUserCEP");
	        if(cep.value.length == 5){
	          cep.value += "-";
	        }
      	}
      	function Phonemask(evt){
	        var theEvent = evt || window.event;
	        var key = theEvent.keyCode || theEvent.which;
	        key = String.fromCharCode( key );
	        var regex = /^[0-9.]+$/;
	        if( !regex.test(key) ) {
	          theEvent.returnValue = false;
	          if(theEvent.preventDefault) theEvent.preventDefault();
	        }   
      	}

      	function doubtOpen(){
      		document.getElementById("doubt").style.display = "block";
      		document.getElementById("doubt1").style.display = "block";
      		document.getElementById("doubt2").style.display = "block";
      	}

      	function doubtClose(){
      		document.getElementById("doubt").style.display = "none";
      		document.getElementById("doubt1").style.display = "none";
      		document.getElementById("doubt2").style.display = "none";
      	}	

      	function imagePreview(event){
	      	var image = URL.createObjectURL(event.target.files[0]);
	      	document.getElementById('defaultPhoto').src = image;
      	}
    </script>

    <?php 
    	if ($_SERVER["REQUEST_METHOD"] === 'POST') {
			if(isset($_SESSION['identifier']) && $_SESSION['identifier']!=null){   	
				if(isset($_POST["deletePassword"]) && !empty($_POST["deletePassword"]) && (!empty(trim($_POST["deletePassword"]))) && isset($_POST["deleteConfirmPassword"]) && !empty($_POST["deleteConfirmPassword"]) && (!empty(trim($_POST["deleteConfirmPassword"]))))
				{
					$password = $_POST["deletePassword"];
					$confirmPassword = $_POST["deleteConfirmPassword"];
					if($password == $confirmPassword){
						$accountConfirm = confirmPassword($_SESSION['identifier'],$password);
						if($accountConfirm){
							echo "<script>deleteConfirm();</script>";
						}
						else
							echo "<script>incorrectPasswords();</script>";
					}
					else{
						echo "<script>differentPasswords();</script>";             
					}
				}

				if(isset($_POST["validator"]) && $_POST["validator"]==1){
					$filename = "Relatório ".date('d-m-Y').".txt";
					$handle = fopen($filename, 'w');
					if(!$handle){
						echo "<script>relatoryFail();</script>";
						exit;
					}
					else if(fwrite($handle,relatory()) === false){
						echo "<script>relatoryFail();</script>";
						exit;
					}
					else
						echo "<script>relatorySuccess();</script>";
					fclose($handle);
				}
			}
		}
    ?>

</body>

</html>
