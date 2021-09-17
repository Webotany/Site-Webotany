<?php
  include_once("DBConnection.php");
  if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if(isset($_POST["identifier"]) && !empty($_POST["identifier"]) && isset($_POST["password"]) && !empty($_POST["password"]) && !empty(trim($_POST["password"]))){
      $loginIdentifier = $_POST["identifier"];
      $loginPassword = $_POST["password"];
      if(login($loginIdentifier, $loginPassword)==true){
        //header("Location: index.php");
        if(isset($_SESSION['identifier'])){
          header("Location: index.php");
        }
        else{
          echo "<script>alert('erro');</script>";
        }
      }
      else{
        //header("Location: login.php");
        echo "<script>alert('Usuário e/ou Senha incorretos');</script>";
      }
    }
    /*else{
      header("Location: login.php");
    }*/
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Download</title>    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Denk+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rambla:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="https://kit.fontawesome.com/4b44bf342d.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style type="text/css">

      body{
        background-color: rgb(235,235,235);
      }

      p{
        margin: 0;
      }

      h3{
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

      a:hover#clickHere{
        font-size: 105%;
        text-decoration: underline;
        color: #48926A;
      }

      img{
        width: 100%;
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

      .apresentation{
        border-color: #48926A;
        border-width: 2px;
        border-style: solid;
        border-right: 0;
        border-top: 0;
        border-bottom: 0;
        float: left;
        background-color: rgb(235,235,235);
        margin: 2%;
        margin-top: 5%;
        width: 35%;
        height: 65%;
        padding-left: 7%;
        padding-right: 7%;
      }

      /*.login{
        margin-bottom: 5%;
        margin-top: 5%;
        margin-left: 10%;
        border-right: 0;
        border-top: 0;
        border-left: 0;
        border-color: #48926A;
      }

      .text{
        font-size: 120%;
      }

      .signup{
        font-size: 75%;
        margin-top: 12%;
        padding-left: 22%;
        color: #48926A;
        font-family: 'Rambla', sans-serif;
      }

      .signup2{
        margin-left: 9%;
        font-size: 95%;
      }*/

      .downloadForm{
        background-color: white;
        box-shadow: 0px 0px 5px gray;
        padding: 5%;
        padding-top: 1%;
        border-radius: 10px;
        margin-top: 5%;
        padding-top: 10%;
        padding-bottom: 10%;
      }

      /*#btnLogin{
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
      }*/

      #OSDownload{
        color: #48926A;
        margin-top: 5%;
        margin-left: 34%;
        margin-right: 34%;
      }

      #download{
        background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 700;
        color: white;
        border-radius: 50px;
        margin-top: 5%;
        width: 70%;
        margin-left: 15%;
        margin-right: 15%;
      }

      #OSName{
        color: #48926A;
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
    <div class="overlay">
      <div class="loader"></div> 
    </div>
    <?php
      $navbar = ("navbar.php");
      include($navbar);
    ?>
    <img src="img/downloadImg.png" style="height: 82vh; width: auto; float: left;">
    <div class="apresentation">
      
      <div class="downloadForm">
        <div style="color: #48926A;">
          <p align="center">Baixe agora a<h3 align="center">WEBOTANY</h3> <p align="center">para o seu computador</p></p><hr>
        </div>
          <!--<input type="text" name="identifier" id="identifier" placeholder="CPF/CNPJ:" maxlength="18" minlength="11" required class="login" style="margin-top: 10%;" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
          <input type="password" name="password" id="password" placeholder="Senha:" required class="login"><br>
          <input type="submit" id="btnLogin" value="Entrar">
          <div class="signup">
            <div class="signup2">Novo na Webotany?</div>
            <a href="signup.php" id="clickHere">Clique aqui</a> e cadastre-se-->
        <div>
          <i class="fab fa-windows fa-5x" id="OSDownload"></i>
          <h5 align="center" id="OSName">Windows</h5>
          <a href="download/Webotany.txt" download="Webotany.txt"><button id="download">Baixar .EXE</button></a>
          <a href="download/Webotany.zip" download="Webotany.zip"><button id="download" style="margin-top: 5%;">Baixar .ZIP</button></a>
        </div>
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
    </script>

</body>

</html>