<?php
  include_once("DBConnection.php");
  if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if(isset($_POST["shopName"]) && isset($_POST["shopEmail"]) && isset($_POST["shopStock"]) && isset($_POST["shopCnpj"]) && !empty($_POST["shopName"]) && !empty($_POST["shopEmail"]) && !empty($_POST["shopStock"]) && !empty($_POST["shopCnpj"]))
    {
      $shopName = $_POST["shopName"];
      $shopEmail = $_POST["shopEmail"];
      $shopStock = $_POST["shopStock"];
      $shopCnpj = $_POST["shopCnpj"];
      if(isset($_SESSION['identifier']))
        $_SESSION['cart'][] = array($_SESSION['identifier'],$shopCnpj,$shopName,$shopEmail,$shopStock,1);
      else
        $_SESSION['cart'][] = array(0,$shopCnpj,$shopName,$shopEmail,$shopStock,1);
      header("Location: bromelia.php");
    }
    else
      echo "erro: floricultura não carregada";
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bromelia</title>    

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

      img{
      	width: 100%;
      	border-radius: 5px;
      }

      b{
        color: #48926A;
      }

      select{
        width: 92%;
      }

      .cepValue{
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border: none;
        height: 5vh;  
        width: 95%;
        border-right: 0;
        border-top: 0;
        border-left: 0;
        border-color: #48926A;
        border-style: solid;
      }

      .cepValue:hover{
        box-shadow: 0px 0px 5px gray;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
      }

      #cepCalc{
        background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 700;
        color: white;
        border-radius: 5px;
        height: 5vh;
        width: 75%;
        margin-left: 10%;
        margin-top: 5%;
        padding: 1%;
      }

      #cepCalc:hover{
        box-shadow: 0px 0px 5px gray;
        border-radius: 5px;
      }

      #btnBuy{
        background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 700;
        color: white;
        border-radius: 5px;
        height: 5vh;
        width: 85%;
        margin-left: 5%;
        margin-top: 5%;
        padding: 1%;
      }

      #btnBuy:hover{
        box-shadow: 0px 0px 5px gray;
        border-radius: 5px;
      }

      #btnFollow{
        background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 700;
        color: white;
        border-radius: 5px;
        height: 5vh;
        width: 85%;
        margin-left: 5%;
        margin-top: 5%;
        padding: 1%;
        margin-top: 10%;
      }

      #btnFollow:hover{
        box-shadow: 0px 0px 5px gray;
        border-radius: 5px;
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

      .fa-search{
      	color: #387755;
      }

      .navbar{
      	background-color: #387755;
      }

      .bottomnavitem{
        margin-left: 5%;
      }

      .plantDetails{
        width: 98%;  
        float: left;
        margin-top: 2%;
        margin-left: 2%;
        padding: 1%;
        box-shadow: 0px 0px 5px gray;
        border-radius: 5px;
        background-color: white;
      }

      .text{
        font-size: 120%;
      }

      .shopDetails{
        margin-bottom: 10%;
        font-size: 110%;
        border-right: 0;
        border-top: 0;
        border-left: 0;
        border-color: #48926A;
      }

      #background{
      	padding: 0;
      	background-color: white;
      	margin-left: 8%;
      	margin-top: 2%;
      	border-radius: 5px;
        height: 202vh;
      }

      #picture{
      	float: left;
      	width: 40%;
        padding: 1%;
      }

      #calcCEP{
        width: 100%;
        padding: 2%;
      }

      #details{
      	float: left;
      	width: 35%;
        padding: 1%;
        background-color: white;
        box-shadow: 0px 0px 5px gray;
        border-radius: 5px;
        margin-top: 1%;
      }

      #purchase{
      	margin: 1%;
        padding: 1%;
        box-shadow: 0px 0px 5px gray;
        border-radius: 5px;
        width: 23%;
        height: auto;
        float: left;
      }

      #plantFeatures{
        position: absolute; 
        width: 75%;
        margin-top: 38%;
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

    <div class="row" style="margin-bottom: 5%;">
    	<div class="col-md-10 col-sm-11" id="background">
    		<div id="picture">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 100%; height: 40vh;">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active" data-interval="5000">
                <img src="img/sell/bromelia/1.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item" data-interval="5000">
                <img src="img/sell/bromelia/2.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item" data-interval="5000">
                <img src="img/sell/bromelia/3.jpg" class="d-block w-100" alt="...">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>          
        </div>
    		<div id="details">
          <?php details(1); ?>         
        </div>
        <div id="purchase">
          <h4 align="center">FLORICULTURA</h4><br>
          <?php 
            availableFlowerShops(1); 
            //flowerShopDetails(1,37164915000323);
          ?>
        </div>
        <div id="plantFeatures">
          <?php
            for ($i=0;$i<=8;$i++) { 
              echo "<div class='plantDetails' style='margin-bottom: 1%;'>";
              plantDetails(1,$i);
              echo "</div>";
            }
          ?>
        </div>
    	</div>   	
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script> 
    <script src="js/script.js"></script>

    <script type="text/javascript">
      function freteCalc(){       
          var userAux = document.getElementById("userCEP").value;
          var shopAux = document.getElementById("shopCEP").value;
          var cepShop = "";
          var cepUser = "";
          for (var i = 6; i <= 8; i++) {
            cepUser += userAux[i];
            cepShop += shopAux[i];
          }

          if(frete<0)
            frete *= -1;
          var frete = (cepUser - cepShop);
          frete /= 10;
          if((frete>0)&&(frete<1000)){
            if(frete<=20)
              document.getElementById("frete").innerHTML="Frete Grátis";
            else{
              if(frete%10 != 0)
                document.getElementById("frete").innerHTML="R$ "+frete+"0";
              else
                document.getElementById("frete").innerHTML="R$ "+frete+",00";
            }
          }
          else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Parece que você se esqueceu de digitar o seu CEP! Digite-o no campo para poder calcular o seu frete',
              timer: 5000
            })
          }
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
        var cep = document.getElementById("userCEP");
        if(cep.value.length == 5){
          cep.value += "-";
        }
      }

      const overlay = document.querySelector(".overlay");

      window.addEventListener("load", function(){
        overlay.style.display = "none";
      })
    </script>

</body>
</html>