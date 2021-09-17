<?php
    include_once("DBConnection.php");
    $cart = $_SESSION['cart'];
    if ($_SERVER["REQUEST_METHOD"] === 'POST'){
        if(isset($_POST["purchaseValueAux"]) && $_POST["purchaseValueAux"]!=null){
            $flag=0;
            for ($i=0; $i < count($cart); $i++) { 
                if($flag!=0)
                    if($cart[$i][5]==$cart[$i-1][5])
                        if($cart[$i][0]!=$cart[$i-1][0]){
                        /*ADICIONAR CODIGO DE COMPRA*/
                        }
                    else
                        //echo "<script>alert('erro - ".$cart[$i][0]."')</script>";
                    $flag++;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="icon" href="img/logoWeb.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Finalizar Compra</title>    

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

        h3{
            text-align: center;
            color: #387755;
            font-weight: 500;
            padding: 1%;
        }

        .fas,.far{
            color: #387755; 
            margin-right: 1%;
        }
        .formapag{
            float: left;
            width: 28%;
            margin-left: 2%;
            margin-right: 2%;
            background-color: yellow;
        }
        .formapag2{
            justify-content: center;
        }
        .purchaseFinishItems{
            border-style: solid;
            border-width: 1px;
            border-top: 0;
            border-left: 0;
            border-right: 0;
            height: 11%;
            width: 88%;
            margin-left: 6%;
            margin-bottom: 1%;
            padding-left: 2%;
            padding-right: 2%;
            padding-bottom: 1%;
            border-color: rgb(235,235,235)
        }
        .flowerShopData{
            margin-bottom: 2%;
            width: 88%;
            margin-left: 6%;
            padding: 2%;
            padding-bottom: 0;
            padding-top: 0;
            font-size: 90%;
        }
        .userDataFinishPurchase{
	        width: 94%;
            margin-left: 6%;
            padding: 2%;
            padding-top: 0;
            padding-bottom: 0;
            margin-bottom: 1%;
            font-size:  90%;
        }
        #footer{
            width: 100%;
            height: 20%;
            background-color: #48926A; 
        }
        #finishPurchase{
            background-color: white;
            box-shadow: 0px 0px 5px gray;
            border-radius: 10px;
            height: 100%;
            width: 40%;
            margin-left: 30%;
            overflow: auto;
            padding-bottom: 5%;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="loader"></div> 
    </div>
    <div style='height: 80%; padding: 2%;'>
        <div id='finishPurchase'>
            <?php
                if(isset($_POST["purchaseValueAux"]) && $_POST["purchaseValueAux"]!=null){
                    echo"<h3>REVISÃO DO PEDIDO</h3>";
                    echo"<p style='margin-bottom: 1%; margin-left: 5%; font-size: 110%; font-weight: 200;'>Itens da compra:</p>";
                    for ($i=0; $i < count($cart); $i++) { 
                        echo "<div class='purchaseFinishItems'>";
                        echo "<div style='float: left; width: 80%; height: 55%;'>".$_POST[$i."purchase"]." x ";
                        echo $_POST[$i."plantName"]."</div>";
                        echo "<div style='float: right; font-size: 110%; width: 20%; height: 55%; text-align: right;'>".str_replace(".",",",$_POST[$i."cartPrice"])."</div>";
                        echo "<div style='font-size: 80%; width: 100%;'><i class='fas fa-store'></i>".$_POST[$cart[$i][1]]."</div>";
                        echo"</div>";
                    }
                    echo "<hr>";
                    $auxArray= array();
                    for ($i=0; $i < count($cart); $i++)
                        $auxArray[] = $cart[$i][1];
                    $auxArray = array_unique($auxArray);
                    if(count($auxArray)==1)
                        echo "<p style='margin-bottom: 1%; margin-left: 5%; margin-bottom: 2%; font-size: 110%; font-weight: 200;'>Dados do vendedor:</p>";
                    else
                        echo "<p style='margin-bottom: 1%; margin-left: 5%; margin-bottom: 2%; font-size: 110%; font-weight: 200;'>Dados dos vendedores:</p>"; 
                    foreach ($auxArray as $value) {
                        flowerShopData($value);
                    }
                    echo "<hr>";
                    echo "<p style='margin-bottom: 1%; margin-left: 5%; margin-bottom: 2%; font-size: 110%; font-weight: 200;'>Seus dados:</p>";
                    $cep = preg_replace("/[^0-9]/", "", consultUser("CEP_UC"));
                    $url = "https://viacep.com.br/ws/$cep/json";
                    $url = curl_init($url);
                    curl_setopt($url, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($url, CURLOPT_SSL_VERIFYPEER, 0);
                    $response = curl_exec($url);
                    curl_close($url);
                    $data = json_decode($response, true);
                    echo    "<div class='userDataFinishPurchase'>            
                                <div id='userDataFinishPurchase'><i class='fas fa-id-card'></i>CPF: ".consultUser("CPF")."</div>
                                <div id='userDataFinishPurchase'><i class='fas fa-user'></i>Nome: ".consultUser("nome")."</div>
                                <div id='userDataFinishPurchase'><i class='fas fa-envelope'></i>Email: ".consultUser("email")."</div>
                                <div id='userDataFinishPurchase'><i class='fas fa-phone-square-alt'></i>Telefone: ".consultUser("telefone")."</div>
                                <div id='userDataFinishPurchase'><i class='fas fa-map-marker-alt'></i>CEP: ".substr_replace(consultUser("CEP_UC"),'-',-3,0)."</div>
                                <div style='font-size: 90%; border-style: solid; border-width: 2px; border-top: 0; border-bottom: 0; border-right: 0; padding-left: 1%; margin-left: 1%; border-color: rgb(235,235,235);'>
                                Rua: ".$data['logradouro']."<br>
                                Bairro: ".$data['bairro']."<br>
                                Cidade: ".$data['localidade']."</div>
                            </div><hr>";
                    echo "<p style='margin-bottom: 1%; margin-left: 5%; margin-bottom: 2%; font-size: 110%; font-weight: 200;'>Forma de Pagamento:</p>";
                    echo    "<form>
                                <div class='formapag' style='margin-left:4%;'><i class='far fa-2x fa-credit-card'></i><br><input type='radio' class='formapag2' id='debito' name='formapag' value='debito'> <label for='html'>Débito</label></div>
                                <div class='formapag'><i class='far fa-2x fa-credit-card'></i><br><input type='radio' class='formapag2' id='credito' name='formapag' value='credito'> <label for='credito'>Crédito</label></div>
                                <div class='formapag' style='margin-right:4%;'><i class='fas fa-2x fa-money-bill-alt'></i><br><input type='radio' class='formapag2' id='boleto' name='formapag' value='boleto'> <label for='Boleto'>Boleto</label></div>
                            </form>";
                }
            ?>
        </div>
    </div>
    <div id='footer'></div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script> 
    <script src="js/script.js"></script>
</body>
</html>