<?php 
  include("DBConnection.php");
  if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $identifier = $_POST["identifier"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $cep = $_POST["cep"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ((trim($identifier) == "") || (trim($name) == "") || (trim($email) == "") || (trim($phone) == "") || (trim($cep) == "") || (trim($password) == "") || (trim($confirmPassword) == "")) {
      echo "<span>Preencha todos os campos</span>";
    } 
    else {
      if($password==$confirmPassword){
      	define('MAX_SIZE', (2 * 2048 * 2048));
      	if((isset($_FILES["UCPhoto"])) && ($_FILES["UCPhoto"]!=null))
    		$photo = $_FILES["UCPhoto"];
    	else if((isset($_FILES["UFPhoto"])) && ($_FILES["UFPhoto"]!=null))
    		$photo = $_FILES["UFPhoto"];
	    $userDirectory = 'img/userProfiles/';
	    $photoName = $photo['name']; 
	    $photoType = $photo['type'];
	    $photoSize = $photo['size'];
	    if(($photoName != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $photoType)))
	    	echo "<script>alert('Erro ao carregar a imagem');</script>";
	    else if(($photoName != "") && ($photoSize > MAX_SIZE))
	    	echo "<script>alert('A imagem não pode ser maior que 8MB');</script>";
	    else{
	    	$temp = new SplFileInfo($photoName);
	    	$photoExtension = $temp->getExtension();
	    	$photoNewName = $identifier . "." . $photoExtension;
	    	if(($photoName != "") && (move_uploaded_file($photo['tmp_name'], $userDirectory . $photoNewName)))
	    		$uploadfile = $userDirectory . $photoNewName;
	    	else{
	    		$uploadfile = null;
	    		echo "<script>alert('Sem upload de imagem');</script>";
	    	}
	    } 
        register($identifier, $name, $email, $phone, $cep, $password, $uploadfile);
      }
      else
        echo("<script type='text/javascript'>alert('As senhas digitas são diferentes!');</script>");
    }
  }
?>

<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastrar-se</title>    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Denk+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rambla:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4b44bf342d.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.mask.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
    	function chooseFileUC(){
    		let UCphoto = document.getElementById('defaultUCPhoto');
    		let UCfile = document.getElementById('UCPhoto');
    		UCfile.click();
    	}

    	function chooseFileUF(){
    		let UFphoto = document.getElementById('defaultUFPhoto');
    		let UFfile = document.getElementById('UFPhoto');
    		UFfile.click();
    	}
    </script> 
    <style type="text/css">

      body{
        background-color: rgb(235,235,235);
      }

      p{
        margin: 0;
      }

      h1{
        color: white;
        font-family: 'Denk One', sans-serif;
      }

      i{
        color: white;
      }

      a{
        text-decoration: none;
        color: #48926A;
      }

      a:hover{
        color: black;
      }

      img{
        width: 100%;
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
        height: 40vh;
      }

      .row{
        width: 100vw;
        z-index: 0;
      }

      .form-control{
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
      }

      .fa-search{
        color: #387755;
      }

      .navbar{
        background-color: #387755;
      }

      .bottomnavitem{
        margin-left: 5%;
      }

      .users{
        border-color: #48926A;
        border-width: 2px;
        border-style: solid;
        border-right: 0;
        border-top: 0;
        border-bottom: 0;
        float: left;
        background-color: rgb(235,235,235);
        margin-top: 5%;
        margin-left: 5%;
        width: 45%;
        height: 65%;
      }

      .registerForm{
        background-color: white;
        box-shadow: 0px 0px 5px gray;
        border-radius: 10px;
        width: 60%;
        height: 100%;
        margin-left: 20%;
        padding-top: 5%;
        overflow: auto;
      }

      .register{
        margin-bottom: 5%;
        margin-top: 2%;
        margin-left: 22%;
        border-right: 0;
        border-top: 0;
        border-left: 0;
        border-color: #48926A;
      }

      .photo{
      	width: 29%;
      	margin: auto;  
      	display: flex; 
      	justify-content: center; 
      	border-radius: 50%;
      }

      #btnLogin{
        background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 700;
        color: white;
        border-radius: 50px;
        margin-top: 10%;
        width: 70%;
        margin-left: 15%;
        margin-right: 15%;
      }

      #idleNav{
        margin-right: 10%; 
        padding-right: 10%; 
      }

      #navbarBottom{
        background-color: #48926A; 
        height: 5vh; 
        box-shadow: 0px 1px 5px black;
        z-index: 1;
      }

      #search{
        background-color: white;
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
        height: 6vh;        
      }

      #signUp{
        margin-left: 1%;
        width: 14%;
        font-family: 'Rambla', sans-serif;
        font-size: 3vh;
      }

      #cart{
        margin-left: 22%;
        width: 16%;
        font-family: 'Rambla', sans-serif;
        font-size: 3vh;
      }

      #defaultUCPhoto{
      	color: #48926A;
      	cursor: pointer;
      	border-radius: 50%;
      	width: 98px;
      	height: 98px;
      	object-fit: cover;
    	object-position: center;
      	transition: color .3s;
      	transition: background .3s;
      }

      #defaultUCPhoto:hover{
      	color: #387755;
      	background-color: #ebebeb;
      }

      #defaultUFPhoto{
      	color: #48926A;
      	cursor: pointer;
      	border-radius: 50%;
      	width: 98px;
      	height: 98px;
      	object-fit: cover;
    	object-position: center;
      	transition: color .3s;
      	transition: background .3s;
      }

      #defaultUFPhoto:hover{
      	color: #387755;
      	background-color: #ebebeb;

      }


      @media only screen and (max-width: 600px) {
        #navbarBottom{
        background-color: #48926A; 
        height: auto; 
        box-shadow: 0px 1px 5px black;
        }
      }

    </style>
</head>

<body>
  <div class="overlay">
    <div class="loader"></div> 
  </div>
    <?php
      $navbar = ("navbar.php");
      include($navbar);
    ?>
    <div class="users" style="border-left: 0;">     
      <div class="registerForm">
        <div style="color: #48926A;">
          <p align="center">Cadastre-se como <h4 align="center">USUÁRIO COMUM</h4></p>
        </div>
        <form method="post" enctype="multipart/form-data">
        	<div class="photo">
        		<img src="img/userDefault.png" id="defaultUCPhoto" onclick="chooseFileUC()">        	
        	</div>
          	<input type="text" name="identifier" id="identifier" placeholder="CPF:" maxlength="11" required class="register" style="margin-top: 10%;" onkeypress="return event.charCode >= 48 && event.charCode <= 57" autocomplete="off">
          	<input type="text" name="name" id="name" placeholder="Nome:" required class="register" minlength="3" autocomplete="off"><br>
         	<input type="email" name="email" id="email" placeholder="E-mail:" required class="register" autocomplete="off"><br>
         	<input type="tel" name="phone" id="phone" placeholder="Telefone:" maxlength="10" minlength="9" required class="register" onkeypress="return event.charCode >= 48 && event.charCode <= 57" autocomplete="off">
          	<input type="text" name="cep" id="cep" placeholder="CEP:" maxlength="8" minlength="8" required class="register" onkeypress="return event.charCode >= 48 && event.charCode <= 57" autocomplete="off">
          	<input type="password" name="password" id="password" placeholder="Senha:" required class="register" autocomplete="off"><br>
          	<input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirme sua senha:" required class="register" autocomplete="off"><br>
          	<input type="file" name="UCPhoto" id='UCPhoto' accept="image.jpg,image.png,image.JPG" onchange="imagePreviewUC(event)">
          	<input type="submit" id="btnLogin" value="Cadastrar">
        </form>
      </div>
    </div>
    <div class="users" style="margin-left: 0;">     
      <div class="registerForm">
        <div style="color: #48926A;">
          <p align="center">Cadastre-se como <h4 align="center">USUÁRIO FLORICULTURA</h4></p>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="photo">
        	<img src="img/userDefault.png" id="defaultUFPhoto" onclick="chooseFileUF()">        	
          </div>
          <input type="text" name="identifier" id="identifier" placeholder="CNPJ:" maxlength="14" required class="register" style="margin-top: 10%;" onkeypress="return event.charCode >= 48 && event.charCode <= 57" autocomplete="off">
          <input type="text" name="name" id="name" placeholder="Nome da floricultura:" required class="register" minlength="3" autocomplete="off"><br>
          <input type="email" name="email" id="email" placeholder="E-mail:" required class="register" autocomplete="off"><br>
          <input type="tel" name="phone" id="phone" placeholder="Telefone:" maxlength="10" minlength="9" required class="register" onkeypress="return event.charCode >= 48 && event.charCode <= 57" autocomplete="off">
          <input type="text" name="cep" id="cep" placeholder="CEP:" maxlength="9" minlength="8" required class="register" onkeypress="return event.charCode >= 48 && event.charCode <= 57" autocomplete="off">
          <input type="password" name="password" id="password" placeholder="Senha:" required class="register" autocomplete="off"><br>
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirme sua senha:" required class="register" autocomplete="off"><br>
          <input type="file" name="UFPhoto" id='UFPhoto' accept="image.jpg,image.png,image.JPG" onchange="imagePreviewUF(event)">
          <input type="submit" id="btnLogin" value="Cadastrar">
        </form>
      </div>
    </div>
    <!--<div class="row">
      <div class="col-md-9 col-sm-10" style="padding: 0">
        <img src="img/loginImg.png">
      </div>   
    </div>-->  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    <script type="text/javascript">
      const overlay = document.querySelector(".overlay");

      window.addEventListener("load", function(){
        overlay.style.display = "none";
      })

      function imagePreviewUC(event){
      	var image = URL.createObjectURL(event.target.files[0]);
      	document.getElementById('defaultUCPhoto').src = image;
      }

      function imagePreviewUF(event){
      	var image = URL.createObjectURL(event.target.files[0]);
      	document.getElementById('defaultUFPhoto').src = image;
      }
    </script>

</body>

</html>