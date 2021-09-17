<?php 
  include_once("DBConnection.php");
  $sessionUsername = array("nome" => "Entrar");
    if(isset($_SESSION['identifier'])){
      $sessionUsername=logged($_SESSION['identifier']);
      if($sessionUsername["nome"]==null)
        echo "erro";
    }

  function navbarUserName(){
    $sessionUsername = array("nome" => "Entrar");
    if(isset($_SESSION['identifier'])){
      $sessionUsername=logged($_SESSION['identifier']);
      if($sessionUsername["nome"]==null)
        echo "erro";
    }
    $simpleUsername = array();
    $flag=0;
    for ($i=0; $i < strlen($sessionUsername["nome"]); $i++) { 
      if($i<10){
        $simpleUsername[$i]=$sessionUsername["nome"][$i];
        echo $simpleUsername[$i];
      }
      else
        $flag=1;
    }
    if ($flag==1) {
      echo "...";
    }
  }

  function verifyAccount(){
    if(isset($_SESSION['identifier']) && $_SESSION['identifier']!=null){
      if(strlen($_SESSION['identifier'])==11)
        echo "uc-account.php";
      else if(strlen($_SESSION['identifier'])==14)
        echo "uf-account.php";
    }
    else
      echo "login.php";
  }

  function navbarUserProfile(){
    if(isset($_SESSION['identifier']) && $_SESSION['identifier']!=null){
      $pdo = dbConnection();
      if(strlen($_SESSION['identifier']) == 14){
        $stmt = $pdo->prepare("select foto from UsuarioFloricultura where CNPJ= :cnpj");
        $stmt->bindParam(':cnpj', $_SESSION['identifier']);
        $stmt->execute();
        if($stmt->rowCount() > 0){
          while ($rows = $stmt->fetch()) {
            if($rows["foto"]!=null)
              $userPhoto = "<img src='".$rows["foto"]."' class='userPhoto'>";
            else
              $userPhoto = "<i class='fas fa-user-circle' style='margin-right: 2%;'></i>";
          }
        }
        else
          $userPhoto = "<i class='fas fa-user-circle' style='margin-right: 2%;'></i>";
      }
      else if(strlen($_SESSION['identifier']) == 11){
        $stmt = $pdo->prepare("select foto from UsuarioComum where CPF= :cpf");
        $stmt->bindParam(':cpf', $_SESSION['identifier']);
        $stmt->execute();
        if($stmt->rowCount() > 0){
          while ($rows = $stmt->fetch()) {
            if($rows["foto"]!=null)
              $userPhoto = "<img src='".$rows["foto"]."' class='userPhoto'>";
            else
              $userPhoto = "<i class='fas fa-user-circle' style='margin-right: 2%;'></i>";
          }
        }
        else
          $userPhoto = "<i class='fas fa-user-circle' style='margin-right: 2%;'></i>";
      }
    }
    else
      $userPhoto = "<i class='fas fa-user-circle' style='margin-right: 2%;'></i>";
    echo $userPhoto;
  }

  function cartItems(){
  	$cart = $_SESSION['cart'];
  	$cartItems=0;
  	$cartItemsNoSession=0;
  	for ($i=0; $i<count($_SESSION['cart']); $i++) {
    	if(isset($_SESSION['identifier'])){
	   		if($cart[$i][0]==$_SESSION['identifier']){
				$cartItems++;
	    	}	
		}
		else{
			if($cart[$i][0]==0){
				$cartItemsNoSession++;
	    	}
		}
  	}
  	if($cartItems>9){
    	$cartItems="9+";
  	}
  	if($cartItemsNoSession>9){
  		$cartItemsNoSession="+9";
  	}
  	if(isset($_SESSION['identifier'])){
  		return $cartItems;
  	}
  	else if(!isset($_SESSION['identifier'])){
  		return $cartItemsNoSession;
  	}
  }

?>

  <style type="text/css">
    .form-control{
      border-bottom-right-radius: 0px;
      border-top-right-radius: 0px;
    }

    .navbar{
      background-color: #387755;
    }

    .cartItemsNumber{
    	position: absolute;
    }

    .userPhoto{
      width: 100%;
      height: 100%;
      width: 18px;
      height: 18px;
      color: #48926A;
      cursor: pointer;
      border-radius: 50%;
      object-fit: cover;
      object-position: center;
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
      height: auto;       
    }

    #signUp{
      margin-left: 1%;
      width: 20%;
      font-family: 'Rambla', sans-serif;
      font-size: 3vh;
    }

    #cart{
      margin-left: 16%;
      width: 16%;
      font-family: 'Rambla', sans-serif;
      font-size: 3vh;
    }
  </style>

    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">
          <h1>WEBOTANY</h1>          
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuCeltop">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuCeltop">
 
        	<ul class="navbar-nav mr-auto" style="width: 100%;"> 
        	  <form class="d-flex">
      				<input class="form-control me-2" type="search" placeholder="Estou buscando por..." name="search">
      				<button class="btn" type="submit" id="search"><i class="fas fa-search"></i></button>
    	  		</form>
    	  		<li class="navbar-item" id="cart">
                <a class="nav-link" href="shopping-cart.php" style="color: white;"><div><div style="position: absolute; color: #48926A; border-radius: 50%; font-size: 60%; font-weight: 900; width: 0.8%; height: 18%; text-align: center; margin-left: 0.55%; margin-top: 0.20%" id="cartItemsNumber"><?php echo cartItems(); ?></div><i class="fas fa-shopping-cart" style="margin-right: 2%;"></i> Carrinho</div></a> 
            </li>
            <li class="navbar-item" id="signUp">
            		<a class="nav-link" href="<?php verifyAccount(); ?>" style="color: white;"><?php navbarUserProfile(); ?> <?php navbarUserName(); ?></a> 
          	</li>
        	</ul>
      	</div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light" id="navbarBottom" style="margin-bottom: 0px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuCelbottom">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuCelbottom">
          <ul class="navbar-nav mr-auto" style="width: 91%; margin-left: 5%;"> 
            <li class="nav-item active" id="idleNav">
              <a class="nav-link" href="index.php" style="color: white;"> <i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item active" id="idleNav">
              <a class="nav-link" href="download.php" style="color: white;"><i class="fas fa-download"></i> Download </a>
            </li>
            <li class="nav-item dropdown" id="idleNav">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                <i class="fas fa-phone-square-alt"></i> Contato
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"><i class="fas fa-phone-volume" style="color: #04B24E;"></i> <b>Tel:</b> (19) 3736-6062</a>
                <a class="dropdown-item"><i class="fas fa-envelope-open-text" style="color: #04B24E;"></i> <b>E-mail: </b>webotanyoficial@gmail.com</a>
                <a class="dropdown-item"><i class="fab fa-twitter" style="color: #04B24E;"></i> <b>Twitter: </b>@webotany</a>
            </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html" style="color: white;"><i class="fas fa-question-circle"></i> Sobre nós</a>
            </li>
          </ul>
        </div>
    </nav>
    <?php
    	if(cartItems()==0){
  			echo "<script>document.getElementById('cartItemsNumber').style.display='none';</script>";
  		}
  		else{
  			echo "<script>document.getElementById('cartItemsNumber').style.display='block';</script>";
  		}
    ?>