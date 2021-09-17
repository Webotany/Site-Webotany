<?php
	/*include("DBConnection.php");
	$sessionUsername = array("nome" => "Entrar");
  	if(isset($_SESSION['identifier'])){
    	$sessionUsername=logged($_SESSION['identifier']);
    	if($sessionUsername["nome"]==null)
    		echo "ola";
  	}
  	/*else
    	$sessionUsername[0]="Entrar";*/
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Denk+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rambla:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="https://kit.fontawesome.com/4b44bf342d.js" crossorigin="anonymous"></script>
    
    <style type="text/css">
      @keyframes long{
      	0%{
      		height: 100%;
      	}
      	100%{
      		height: 120%;
      	}
      }

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

      .d-flex{
      	width: 40vw;
      	margin-left: 20%;
      	height: 30%;
      }

      .d-block{
      	height: 55vh;
      }

      .carousel-control-next{
      	width: 5%;
      }

      .carousel-control-prev{
      	width: 5%;
      }

      .card{
      	margin-left: 12%;
        width: 80%;
        height: 100%;
        transition-property: height;
        transition-duration: 0.2s; 
      }

      .card:hover{
      	height: 105%;
      	box-shadow: 0px 1px 5px gray;
      	text-decoration: none;
      }

      .card-title{
      	color: black;
      	font-size: 110%;
      	margin-bottom: 0;
      }

      .card-text{
      	color: black;
      	font-size: 170%;
      }

      .row{
        width: 100vw;
        z-index: 0;
      }

      .fa-search{
      	color: #387755;
      }

      .featuresThings{
      	width: 25%;
      	height: 100%;
      	float: left;
      }

      .featureText{
      	color: black;
      	font-size: 105%;
      	text-align: center;
      	margin-top: 2%;
      }

      .bottomnavitem{
        margin-left: 5%;
      }

      #featureImg{
      	margin-left: 42%;
      	margin-right: 42%;
      	margin-top: 2%;
      	color: #48926A;
      }

      #indexCards{
      	padding: 0;
      }

      #features{
      	background-color: white;
      	margin-left: 3%;
      	margin-top: 3%;
      	margin-bottom: 3%;
      	width: 95%;
      	height: 14vh;
      	border-radius: 5px;
      	box-shadow: 1px 1px 5px gray;
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
    <div class="row">
    	<div class="col-md-12 col-sm-12" style="padding: 0">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width:100%; height: 55vh;">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active" data-interval="5000">
						<img src="img/indexCarousel1.png" class="d-block w-100" alt="...">
					</div>
					<div class="carousel-item" data-interval="5000">
					    <img src="img/indexCarousel2.png" class="d-block w-100" alt="...">
					</div>
					<div class="carousel-item" data-interval="5000">
					   	<img src="img/indexCarousel3.png" class="d-block w-100" alt="...">
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
			<div id="features">
				<div class="featuresThings"><i class="fas fa-hand-holding-usd fa-2x" id="featureImg"></i><div class="featureText">Transações rápidas e seguras</div></div>
				<div class="featuresThings"><i class="far fa-credit-card fa-2x" id="featureImg"></i><div class="featureText">Crédito, débito e boleto</div></div>
				<div class="featuresThings"><i class="fas fa-seedling fa-2x" id="featureImg"></i><div class="featureText">Maior variedade em plantas</div></div>
				<div style="" class="featuresThings"><i class="fas fa-laugh fa-2x" id="featureImg"></i><div class="featureText">Acompanhamento exclusivo</div></div>
			</div>		
      	<?php addProd(1); ?>
      	<?php addProd(2); ?>
      	<?php addProd(1); ?>
      	<?php addProd(1); ?>
    </div><br><br><!--<br><br><br><br><br><br> <h5><a href="?logout=1">SAIR</a></h5>-->  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <style type="text/css">
    	.cartItemsNumber{
	    	margin-left: 76.5%;
	    	margin-top: 3.2%;
      	}
    </style>
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
