<?php
	include_once("DBConnection.php");
	$cart = $_SESSION['cart'];
	if(isset($_GET['delete']) && ($_GET['delete']!=null)){
    array_splice($_SESSION['cart'],$_GET['delete'],1);
    header("Location: shopping-cart.php");
  }
  if(isset($_GET['clean']) && ($_GET['clean']!=null)){
    for ($i=0; $i<count($_SESSION['cart']); $i++) {
      if(isset($_SESSION['identifier'])){
  	    if($cart[$i][0]==$_SESSION['identifier']){
  	    	array_splice($_SESSION['cart'],$i,1);
  	    			//array_splice($_SESSION['cart'],$i,count($_SESSION['cart']));
  	    }	
	    }
	    	/*else{
	    		if($cart[$i][0]==0)
	    	}

	    	if(isset($_SESSION['identifier'])){
	    		if($cart[$i][0]==$_SESSION['identifier']){
	    			$flag++;
	    			addItemCart($cart[$i][1],$cart[$i][2],$cart[$i][3],$cart[$i][4],$cart[$i][5],$i);
	    		}
	    	}
	    	else{
	    		if (($cart[$i][0]==0)) {
	    			$flag++;
	    			addItemCart($cart[$i][1],$cart[$i][2],$cart[$i][3],$cart[$i][4],$cart[$i][5],$i);
	    		}
	    	}*/
    }
      /*unset($_SESSION['cart']);*/
      header("Location: shopping-cart.php");
  }
    
  for ($i=0; $i<count($cart); $i++) { 
    if(isset($_SESSION['identifier'])){
      if($_SERVER["REQUEST_METHOD"] === 'POST'){
        if($cart[$i][0]==$_SESSION['identifier']){        
          //echo $cart[$i][2];
        }
      }
    }
  }
  
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Carrinho</title>    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Denk+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rambla:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="https://kit.fontawesome.com/4b44bf342d.js" crossorigin="anonymous"></script>
    <style type="text/css">

      body{
        background-color: rgb(235,235,235);
      }

      h3{
        color: #48926A; 
        margin-top: 5%;
        margin-bottom: 5%;
        font-weight: 700;
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

      a.deleteItem{
      	text-decoration: none;
      	background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 500;
        color: white;
        border-radius: 5px;
        margin-left: 15%;
        margin-top: 5%;
        height: 18%;
        width: 40%;
        text-align: center;
        float: left;
        outline: none;
      }

      .d-flex{
      	width: 40vw;
      	margin-left: 20%;
      	height: 30%;
      }

      .d-block{
      	height: 55vh;
      }

      .row{
        width: 100vw;
        z-index: 0;
      }

      .fa-search{
      	color: #387755;
      }

      .fa-trash-alt{
      	margin-right: 5%;
      	color: white;
      }

      .fa-broom{
      	margin-right: 5%;
      }

      .fa-shipping-fast{
        color: #48926A;
        margin-left: 5%;
        margin-top: 0%;
        margin-bottom: 10%;
      }

      .fa-sad-tear{
      	color: #bababa;
      	float: left;
      	margin-top: 25vh;
      	margin-left: 25%;
      }

      .bottomnavitem{
        margin-left: 5%;
      }

      .shoppingCart{
      	background-color: white;
      	width: 65%;
      	margin-left: 5%;
      	margin-right: 5%;
      	margin-top: 2%;
      	float: left;
      	border-radius: 5px;
      }

      .cartProdImg{
      	width: 27%;
      	height: 90%;
      	border-radius: 5px;
      	float: left;
      }

      .cartItem{
      	margin-bottom: 5%;
      	margin-top: 2%;
      	width: 92%;
      	margin-left: 4%;
      	height: 25vh;
      	border-style: solid;
      	border-width: 2px;
      	border-color: #E5E5E5;
      	border-right: 0;
      	border-left: 0;
      	border-top: 0;
      }

      .finishPurchase{
      	float: left;
      	width: 20%;
      	margin-right: 5%;
      	margin-top: 2%;
      	background-color: white; 
      	border-radius: 5px;
      }

      .cartText{
      	background-color: white;
      	outline: none;
      	border: 0;
      }

      .finishPurchaseText{
        font-size: 80%;
        margin-left: 5%;
        margin-bottom: 1%;
        color: #636363;
      }

      #cartPlant{
      	float: left;
      	width: 58%;
      	padding: 1%;
      	padding-left: 2%;
      	padding-bottom: 0;
      	font-weight: 700;
      	font-size: 150%;
      	color: #48926A; 
      }

      #qtde{
      	width: 15%;
      	margin-top: 2%;
      	float: right;
      }

      #purchaseQtd{
      	float: right;
      	margin-right: 20%;
      	width: 60%;
      	background-color: rgb(235,235,235);
      	border-radius: 5px;
      	outline: none;
      }

      #cartShop{
      	padding: 0;
      	padding-left: 2%;
      	font-weight: 200;
      	font-size: 90%;
      }

      #purchaseValue{
        margin-bottom: 5%;
        margin-left: 5%;
        margin-right: 5%;
	      border: 0;
	      width: 90%;
	      font-size: 200%;
        color: #636363;
        font-weight: 200;
	      outline: none;
      }

      #btnFinishPurchase{
        text-decoration: none;
      	background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 500;
        color: white;
        border-radius: 5px;
        margin-left: 5%;
        margin-top: 5%;
        margin-bottom: 5%;
        width: 90%;
        text-align: center;
        outline: none;
      }

      .deleteItem:hover{
      	box-shadow: 0px 0px 5px gray;
      }

      .cleanCart{
      	background-image: linear-gradient(to bottom right, #56B07F, #387755);
        border: none;
        cursor: pointer;
        font-weight: 700;
        font-size: 110%;
        color: white;
        border-radius: 5px;
        margin-left: 10%;
        margin-top: 6%;
        height: auto;
        width: 80%;
        text-align: center;
        padding: 1%;
      }

      .cleanCart:hover{
      	box-shadow: 0px 0px 5px gray;
      }

      .emptyCart{
      	margin-top: 24vh;
      	margin-bottom: 24vh;
      	color: #bababa;
      	float: left;
      	font-weight: 600;
      	font-size: 170%;
      	height: 14vh;
      	width: 39%;
      	margin-left: 2%;
      	padding: 0;
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
    <div class="row">
    	<div class="col-md-12 col-sm-12" style="padding: 0; margin-bottom: 7%;">
    		<div class='shoppingCart' id='shoppingCart'>
	    		<?php 
	    			$flag = 0;
            echo "<form method = 'post' id='purchaseForm' action = 'finishPurchase.php'>";
	    			for ($i=0; $i<count($cart); $i++) { 
	    				if(isset($_SESSION['identifier'])){
	    					if($cart[$i][0]==$_SESSION['identifier']){
	    						$flag++;
	    						addItemCart($cart[$i][1],$cart[$i][2],$cart[$i][3],$cart[$i][4],$cart[$i][5],$i);
	    					}
	    				}
	    				else{
	    					if (($cart[$i][0]==0)) {
	    						$flag++;
	    						addItemCart($cart[$i][1],$cart[$i][2],$cart[$i][3],$cart[$i][4],$cart[$i][5],$i);
	    					}
	    				}
	    			}
	    			if($flag == 0){
	    				echo "<script>
	    						document.getElementById('shoppingCart').style.width='66%';
	    						document.getElementById('shoppingCart').style.marginLeft='17%';
	    					</script>";
	    				echo "<i class='fas fa-5x fa-sad-tear'></i><div class='emptyCart'><p>Você ainda não tem produtos no seu carrinho</p></div>";
	    			}
	    			else
	    				echo "<a href='?clean=1'><p class='cleanCart'><i class='fas fa-broom'></i>Limpar Carrinho</p></a>";
	    		?>

	    	</div>
	    	<?php 
	    	if($flag != 0){
		    	echo "<div class='finishPurchase'>
              <h3 align='center'>Finalizar Compra</h3><hr>
              <p class='finishPurchaseText'>Transportadora:</p>
              <i class='fas fa-shipping-fast' style='margin-right: 3%;'></i><select style='width: 30%;border-radius: 5px;'><option value='1'>SEDEX</option></select>
              <p class='finishPurchaseText'>Preço final:</p>
              <input type='text' name='purchaseValue' id='purchaseValue' readonly value=''>
              <input type='text' name='purchaseValueAux' id='purchaseValueAux' readonly value='' hidden>
              <input type='submit' name='btn1' id='btnFinishPurchase' value='Finalizar Compra' form='purchaseForm'>
            </form>
					</div>";
			}
			?>
		</div>
	</div>		
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

  <?php
    echo "<script>";
    echo "function purchaseValueUpdate(){";
      echo "var totalPrice = 0;";
      for ($i=0; $i<count($cart); $i++) {
        $aux = "cartPrice".$i;
        echo "totalPrice += parseFloat(document.getElementById('".$aux."').value);";
      }
      echo "document.getElementById('purchaseValue').value = 'R$ '+totalPrice.toFixed(2);";
      echo "document.getElementById('purchaseValueAux').value = totalPrice.toFixed(2);";
    echo "}";
    echo "purchaseValueUpdate();";
    echo "</script>";
  ?>
</body>

</html>