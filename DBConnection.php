<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<?php
    //-------------------------SETANDO OS COOKIES-------------------------------
        /*setcookie('receiveEmailsPromotions','off',time()+31536000);
        setcookie('darkTheme','off',time()+31536000);
        setcookie('rememberMe','off',time()+31536000);*/
    //---------------------------------------------------------------------------------------------

    $flag = 0;
    $username = 'cl19130';
    $password = 'cl*11122003';
    session_start();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if(isset($_GET['logout']) && ($_GET['logout']==1)){
        /*$_SESSION[] = array();
        session_destroy();*/
        unset($_SESSION['identifier']);
        header("Location: index.php");
    }

    //EXCLUIR CONTA

    $token = md5("deleteAccountConfirmation");
    if(isset($_GET['0f5f5c08aacf51e7855d2d438459cb6c']) && ($_GET['0f5f5c08aacf51e7855d2d438459cb6c']==1))
        deleteAccount($_SESSION['identifier']);
    //conectando ao BD
    /*try {        
        $pdo = new PDO('mysql:host=143.106.241.3:3306;dbname=cl19130', $username, $password);
        //$pdo.setAttribute();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $output = 'Conexão estabelecida. <br>';
    } 
    catch (PDOException $e) {
        $output = 'Impossível conectar BD : ' . $e . '<br>';
    }*/

    function dbConnection(){
        $pdo = new PDO('mysql:host=143.106.241.3:3306;dbname=cl19130', 'cl19130', 'cl*11122003');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    function confirmPassword($identifier,$password){
        $password = md5($password);
        $pdo = dbConnection();

        if(strlen($identifier) == 14){
            $stmt = $pdo->prepare("select senha from UsuarioFloricultura where CNPJ= :cnpj");
            $stmt->bindParam(':cnpj', $identifier);
            $stmt->execute();

            while ($rows = $stmt->fetch()) {
                $dbPassword=$rows['senha'];
            }

            if($dbPassword == $password)
                return true;
            else
                return false;
        }

        else if(strlen($identifier) == 11){
            $stmt = $pdo->prepare("select senha from UsuarioComum where CPF= :cpf");
            $stmt->bindParam(':cpf', $identifier);
            $stmt->execute();

            while ($rows = $stmt->fetch()) {
                $dbPassword=$rows['senha'];
            }

            if($dbPassword == $password)
                return true;
            else
                return false;
        }

        else
            return "CPF/CNPJ Error";
    }

    //------------------ADICIONAR PRODUTO------------------------
    function addProd($idProd){

        try{
            $pdo = dbConnection();
            $stmt = $pdo->prepare("select codigo from Planta where codigo = :codigo");
            $stmt->bindParam(':codigo', $idProd);
            $stmt->execute();
            $ids = $stmt->rowCount();
            if ($ids <= 0) {
              echo "<span style='background-color: pink;'>Planta ainda não cadastrada</span>";
            }
            else {
              $stmt = $pdo->prepare("select codigoPlant from Estoque where codigoPlant = :idProd");
              $stmt->bindParam(':idProd', $idProd);
              $stmt->execute();
              $rows = $stmt->rowCount();
              if($rows <= 0) {
                echo "<span style='background-color: purple;'>Nenhuma planta em estoque</span>";
              }
              else {
                $stmt = $pdo->prepare("select nome, nomeCientifico from Planta where codigo = :idProd");
                $stmt->bindParam(':idProd', $idProd);
                $stmt->execute();
                while ($names = $stmt->fetch()) {
                  $plantName = utf8_encode($names['nome']);
                  $plantSciName = $names['nomeCientifico'];
                }
                $stmt = $pdo->prepare("select precoUnit from Estoque where codigoPlant = :idProd order by precoUnit");
                $stmt->bindParam(':idProd', $idProd);
                $stmt->execute();
                $menor = 1000000;
                while ($prices = $stmt->fetch()) {
                    if ($prices['precoUnit']<$menor) {
                        $menor = $prices['precoUnit'];
                    }
                }
                $plantLink = strtolower($plantSciName);
                $plantLink = str_replace(' ', null, $plantLink).".php";
                //-------RETIRAR OS ACENTOS--------
                $caracteres_sem_acento = array('Š'=>'S', 'š'=>'s', 'Ð'=>'Dj',''=>'Z', ''=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A','Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I','Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U','Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a','å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i','ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u','ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f','ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T');

                $plantImg = strtolower($plantName);
                $plantImg = strtr($plantImg, $caracteres_sem_acento);
                $plantImg = "img/".$plantImg."Index.jpg";
                echo "<div class='col-md-3 col-sm-12' id='indexCards'>
                        <div class='card'>
                            <a href='".$plantLink."'>
                                <img src='".$plantImg."' class='card-img-top' alt='".$plantName."'>
                                <div class='card-body'>
                                    <h5 class='card-title'>".$plantName."</h5>
                                    <p class='card-text'> R$ ".$menor."0 </p>
                                </div>
                            </a>
                        </div>
                      </div>";

              }
            }
        } 
        catch(PDOException $e){
          echo $e;
        }

        $pdo = null;
    }


    //-----------------------DETALHES DA PLANTA------------------------
    function details($idProd){

        try{
            $pdo = dbConnection();
            $stmt = $pdo->prepare("select codigo from Planta where codigo = :codigo");
            $stmt->bindParam(':codigo', $idProd);
            $stmt->execute();
            $ids = $stmt->rowCount();
            if ($ids <= 0) {
                echo "<span style='background-color: pink;'>Planta ainda não cadastrada</span>";
            }
            else {
                $stmt = $pdo->prepare("select codigoPlant from Estoque where codigoPlant = :idProd");
                $stmt->bindParam(':idProd', $idProd);
                $stmt->execute();
                $rows = $stmt->rowCount();
                if($rows <= 0) {
                    echo "<span style='background-color: purple;'>Nenhuma planta em estoque</span>";
                }
                else {
                    $stmt = $pdo->prepare("select nome, nomeCientifico,descricao from Planta where codigo = :idProd");
                    $stmt->bindParam(':idProd', $idProd);
                    $stmt->execute();
                    while ($names = $stmt->fetch()) 
                    {
                        $plantName = utf8_encode($names['nome']);
                        $plantSciName = $names['nomeCientifico'];
                        $desc = utf8_encode($names['descricao']);
                    }
                    $stmt = $pdo->prepare("select precoUnit from Estoque where codigoPlant = :idProd order by precoUnit");
                    $stmt->bindParam(':idProd', $idProd);
                    $stmt->execute();
                    $menor = 1000000;
                    while ($prices = $stmt->fetch()) {
                        if ($prices['precoUnit']<$menor) {
                            $menor = $prices['precoUnit'];
                    }
                }
                $plantLink = strtolower($plantSciName).".php";
                echo"<h2>".$plantName."</h2>
                    <div id='price'><h5><ins><b> R$ ".$menor."0</b></ins> </h5></div><br>
                    <p><b>Descrição:</b><br>".$desc."</p>";
            }
        }   
        } 
        catch(PDOException $e){
            echo $e;
        }

        $pdo = null;
    }



    //----------------------FLORICULTURAS DISPONÍVEIS--------------------------
    function availableFlowerShops($idProd){
        try {
            $pdo = dbConnection();
            $stmt = $pdo->prepare("select codigo from Planta where codigo = :codigo");
            $stmt->bindParam(':codigo', $idProd);
            $stmt->execute();
            $ids = $stmt->rowCount();
            if ($ids <= 0) {
                echo "<span style='background-color: pink;'>Planta ainda não cadastrada</span>";
            }
            else {
                $stmt = $pdo->prepare("select CNPJ, precoUnit from Estoque where codigoPlant = :codigoPlant order by precoUnit");
                $stmt->bindParam(':codigoPlant', $idProd);
                $stmt->execute();

                echo "<form method='post'>";
                echo "<select name='shop' onchange='updatePrice(this.value)''>";

                while ($avaibleShops = $stmt->fetch()) {
                    $shopsCNPJ=$avaibleShops['CNPJ'];
                    $cnpjValue=$avaibleShops['CNPJ'];
                    $stmt2 = $pdo->prepare("select nome from UsuarioFloricultura where CNPJ = :CNPJ");
                    $stmt2->bindParam(':CNPJ', $shopsCNPJ);
                    $stmt2->execute();
                    $shopsNames = $stmt2->fetch();

                    echo "<option value='".$cnpjValue."'>".utf8_encode($shopsNames['nome'])."</option>";
                }
                echo "</select><br><br>";
                if(flowerShopDetails($idProd,$cnpjValue)==1)
                    echo "</form>";
            }
        }
        catch(PDOException $e){
            echo $e;
        }
        $pdo = null;
    } 


    function flowerShopDetails($idProd,$cnpj){
        try{
            global $flag;
            $flag++;
            if($flag==1){
                $pdo = dbConnection();
                $stmt = $pdo->prepare("select nome,email,telefone,CEP_UF from UsuarioFloricultura where CNPJ = :cnpj");
                $stmt->bindParam(':cnpj', $cnpj);
                $stmt->execute();
                $ids = $stmt->rowCount();
                if ($ids <= 0) 
                    echo "<span style='background-color: pink;'>CNPJ não encontrado</span>";
                else{
                    while ($flowerShops = $stmt->fetch()) {
                        $shopName=$flowerShops['nome'];
                        $shopEmail=$flowerShops['email'];
                        $shopTelefone=$flowerShops['telefone'];
                        $shopCep=$flowerShops['CEP_UF'];
                    }
                    $stmt2 = $pdo->prepare("select qtdEstoque from Estoque where CNPJ = :cnpj AND codigoPlant = :codigo");
                    $stmt2->bindParam(':cnpj', $cnpj);
                    $stmt2->bindParam(':codigo', $idProd);
                    $stmt2->execute();
                    while ($flowerShops = $stmt2->fetch()) {
                        $shopStock=$flowerShops['qtdEstoque'];
                    }
                    echo "<input type='text' id='shopCnpj' name='shopCnpj' value='".$cnpj."' readonly class='shopDetails' hidden>";
                    echo "<b id='shops'>Nome:</b>";
                    echo "<input type='text' id='shopName' name='shopName' value='".utf8_encode($shopName)."' readonly class='shopDetails'>";
                    echo "<b id='shops'>Email:</b>";
                    echo "<input type='text' id='shopEmail' name='shopEmail' value='".$shopEmail."' readonly class='shopDetails'>";
                    echo "<b id='shops'>Telefone:</b>";
                    echo "<input type='text' id='shopTelefone' name='shopTelefone' value='".$shopTelefone."' readonly class='shopDetails'>";
                    echo "<b id='shops'>CEP:</b>";
                    echo "<input type='text' id='shopCEP' name='shopCep' value='".$shopCep."' readonly class='shopDetails'>";
                    echo "<b id='shops'>Quantidade em estoque:</b>";
                    echo "<input type='text' id='shopStock' name='shopStock' value='".$shopStock."' readonly class='shopDetails' style='margin-bottom:5%;'>";
                    echo "<hr><b id='shops'></i>Frete:</b>";
                    echo    "<div id='calcCEP'>
                                <input class='cepValue' id='userCEP' type='text' name='cep' onkeypress='return CEPmask()' minlength='9' maxlength='9' placeholder='Digite seu CEP'>
                                <p id='cepCalc' onclick='freteCalc()' align='center'>Calcular</p>
                            </div>";
                    echo "<h5 id='frete'>R$ 0,00</h5><hr>";
                    echo "<input type='submit' id='btnBuy' value='Comprar'>";
                    if((isset($_SESSION['identifier']))&&(!empty($_SESSION['identifier']))){
                        $followCode = $_SESSION['identifier'].$idProd;
                        echo "<p id='btnFollow' onclick='followCode()' align='center'>Acompanhar</p>";
                        echo "<script>";
                        echo    "function followCode(){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Pronto!',
                                        text: 'Digite o código de acompanhamento abaixo no aplicativo da Webotany para poder acompanhar sua planta!',
                                        footer: 'Código de acompanhamento: ".$followCode."'
                                    })
                                }";
                        echo "</script>";
                    }
                    else{
                        echo "<p id='btnFollow' onclick='requiredLogin()' align='center'>Acompanhar</p>";
                        echo "<script>";
                        echo    "function requiredLogin(){
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'Você precisa estar logado para acompanhar uma planta!',
                                        confirmButtonText: `Efetuar login`,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = 'login.php';
                                        }
                                    })
                                }";


                        echo "</script>";
                    }
                }
            }
            else if($flag>1){
                $pdo = dbConnection();
                $stmt = $pdo->prepare("select nome,email,telefone,CEP_UF from UsuarioFloricultura where CNPJ = :cnpj");
                $stmt->bindParam(':cnpj', $cnpj);
                $stmt->execute();
                $ids = $stmt->rowCount();
                if ($ids <= 0) 
                    echo "<span style='background-color: pink;'>CNPJ não encontrado</span>";
                else{
                    while ($flowerShops = $stmt->fetch()) {
                        $shopName=$flowerShops['nome'];
                        $shopEmail=$flowerShops['email'];
                        $shopTelefone=$flowerShops['telefone'];
                        $shopCep=$flowerShops['CEP_UF'];
                    }
                    /*$stmt4 = $pdo->prepare("select qtdEstoque from Estoque where CNPJ = :cnpj AND codigoPlant = :codigo");
                    $stmt4->bindParam(':cnpj', $cnpj);
                    $stmt4->bindParam(':codigo', $idProd);
                    $stmt4->execute();
                    while ($flowerShops = $stmt4->fetch()) {
                        $shopStock=$flowerShops['qtdEstoque'];
                    }*/
                    echo "<script>";
                    echo "document.getElementById('shopName').value='".$shopName."';";
                    echo "document.getElementById('shopEmail').value='".$shopEmail."';";
                    echo "document.getElementById('shopTelefone').value='".$shopTelefone."';";
                    echo "document.getElementById('shopCEP').value='".$shopCep."';";
                    //echo "document.getElementById('shopStock').value='".$shopStock."';";
                    echo "</script>";
                }
            }
        }
        catch(PDOException $e){
            echo $e;
        }
    }


    //----------------------------CARACTERÍSTICAS DA PLANTA---------------------------
    function plantDetails($idProd,$idDetail){

        try{
            $pdo = dbConnection();
            $stmt = $pdo->prepare("select * from Planta where codigo = :codigo");
            $stmt->bindParam(':codigo', $idProd);
            $stmt->execute();

            while ($plantFeatures = $stmt->fetch()) {
                $plantName=$plantFeatures['nome'];
                $plantSciName=$plantFeatures['nomeCientifico'];
                $climate=$plantFeatures['climaIdeal'];
                $type=$plantFeatures['tipo'];
                $sun=$plantFeatures['tempoSol'];
                $water=$plantFeatures['qtdAgua'];
                $size=$plantFeatures['tamanho'];
                $fertilizer=$plantFeatures['adubo'];
                $cares=$plantFeatures['cuidadosEspec'];
                $hrsSun=0;
                $lWater=0;
                while ($sun>=60) {
                  $sun-=60;
                  $hrsSun++;
                }
                while ($water>=500){
                  $water-=500;
                  $lWater+=0.5;
                }
            }

            if($idDetail==0){
                echo "<b>Nome:</b> <div class=text>".utf8_encode($plantName)."</div>";
            }
            else if($idDetail==1){
                echo "<b>Nome Científico:</b> <div class=text>".utf8_encode($plantSciName)."</div>";
            }
            else if($idDetail==2){
                echo "<b>Tipo:</b> <div class=text>".utf8_encode($type)."</div>";
            }
            else if($idDetail==3){
                echo "<b>Clima Ideal:</b> <div class=text>".utf8_encode($climate)."</div>";
            }
            else if($idDetail==4){
                if($sun<=0) 
                    echo "<b>Tempo de Sol:</b> <div class=text>".$hrsSun."h</div>";
                else
                    echo "<b>Tempo de Sol:</b> <div class=text>".$hrsSun."h".$sun."min</div>";
            }
            else if($idDetail==5){
                if ($lWater>0) {
                    echo "<b>Quantidade de água:</b> <div class=text>".$lWater."L ".$water."mL</div>";
                }
                else
                    echo "<b>Quantidade de água:</b> <div class=text>".$water."mL</div>";
            }
            else if($idDetail==6){
                echo "<b>Tamanho mínimo de vaso:</b> <div class=text>".$size."cm de diâmetro</div>";
            }
            else if($idDetail==7){
                echo "<b>Adubo ideal:</b> <div class=text>".$fertilizer."</div>";
            }
            else if($idDetail==8){
                if ($cares==null){
                    echo "<b>Cuidados Especiais:</b><div class=text>N/D</div>";
                    return 0;
                }
                else
                    echo "<b>Cuidados Especiais:</b> <div class=text>".$cares."</div>";
            }
            else{
                echo "ID não encontrado";
            }
        }
        catch(PDOException $e){
          echo $e;
        }
        $pdo=null;
    }


    //-----------------------------ATUALIZANDO PREÇO DA PLANTA----------------------------------
    function flowerShopPrice($idProd){
        try{
            $stmt = $pdo->prepare("select precoUnit from Estoque where codigoPlant = :idProd order by precoUnit");
            $stmt->bindParam(':idProd', $idProd);
            $stmt->execute();
            $menor = 1000000;
            while ($prices = $stmt->fetch()) {
                if ($prices['precoUnit']<$menor) {
                    $menor = $prices['precoUnit'];
                }
            }
        }
        catch(PDOException $e){
          echo $e;
        }
        $pdo=null;
    }



    //----------------------------VERIFICANDO SE HÁ USUÁRIO----------------------
    function registerCheck($identifier, $pdo){
        $rows=0;
        $stmt = $pdo->prepare("select * from UsuarioComum where CPF= :cpf");
        $stmt->bindParam(':cpf', $identifier);
        $stmt->execute();
        $rows = $stmt->rowCount();
        $stmt2 = $pdo->prepare("select * from UsuarioFloricultura where CNPJ= :cnpj");
        $stmt2->bindParam(':cnpj', $identifier);
        $stmt2->execute();
        $rows += $stmt2->rowCount();
        return $rows;
    }


    //----------------------------CADASTRANDO USUÁRIO----------------------
    function register($identifier, $name, $email, $phone, $cep, $password, $photo){
        $pdo = dbConnection();
        $rows = registerCheck($identifier, $pdo);
        if($rows <= 0)
            //INSERINDO NA TABELA "USUÁRIO FLORICULTURA"
            if(strlen($identifier)==14) {
                $stmt = $pdo->prepare("insert into UsuarioFloricultura (CNPJ,email,nome,senha,telefone,CEP_UF,foto) values(:cnpj, :email, :name, :password, :phone, :cep, :photo)");
                $password = md5($password);
                $stmt->bindParam(':cnpj', $identifier);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':cep', $cep);
                $stmt->bindParam(':photo', $photo);
                $stmt->execute();
                header("Location: index.php");
            }

            //INSERINDO NA TABELA "USUÁRIO COMUM"
            else if(strlen($identifier)==11) {
                $stmt = $pdo->prepare("insert into UsuarioComum (CPF,email,nome,senha,telefone,CEP_UC,foto) values(:cpf, :email, :name, :password, :phone, :cep, :photo)");
                $password = md5($password);
                $stmt->bindParam(':cpf', $identifier);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':cep', $cep);
                $stmt->bindParam(':photo', $photo);
                $stmt->execute();
                header("Location: index.php");
            }

            else
                echo "CPF/CNPJ ERROR";
        else{
            echo "<script>";
            echo "alert('Você ja foi cadastrado!')";
            echo "</script>";
        }
    }

    //----------------------DEIXANDO (OU NÃO) O USUÁRIO ENTRAR-------------------
    function login($identifier, $password){
        $pdo = dbConnection();
        $rows = registerCheck($identifier, $pdo);
        if($rows <= 0){
            echo "<script>";
            echo "alert('Você ainda não está cadastrado');";
            echo "</script>";
        }
        else{
            $password = md5($password);

            if(strlen($identifier) == 14){
                $stmt = $pdo->prepare("select senha from UsuarioFloricultura where CNPJ= :cnpj");
                $stmt->bindParam(':cnpj', $identifier);
                $stmt->execute();

                while ($rows2 = $stmt->fetch()) {
                    $dbPassword=$rows2['senha'];
                }

                if($dbPassword == $password){
                    $_SESSION['identifier'] = $identifier;
                    return true;
                }
                else{
                    echo "<script>";
                    echo "alert('Senha incorreta!');";
                    echo "</script>";
                    return false;
                }
            }

            else if(strlen($identifier) == 11){
                $stmt = $pdo->prepare("select senha from UsuarioComum where CPF= :cpf");
                $stmt->bindParam(':cpf', $identifier);
                $stmt->execute();

                while ($rows2 = $stmt->fetch()) {
                    $dbPassword=$rows2['senha'];
                }

                if($dbPassword == $password){
                    $_SESSION['identifier'] = $identifier;
                    return true;
                }
                else{
                    echo "<script>";
                    echo "alert('Senha incorreta!');";
                    echo "</script>";
                    return false;
                }
            }

            else{
                echo "<h1>erro</h1>";
            }
        }
    }



    //----------------------------------VERIFICANDO SE ESTÁ LOGADO---------------------
    function logged($identifier){
        $pdo = dbConnection();
        $username = array();

        if(strlen($identifier) == 14){
            $stmt = $pdo->prepare("select nome from UsuarioFloricultura where CNPJ= :cnpj");
            $stmt->bindParam(':cnpj', $identifier);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $sessionUsername = $stmt->fetch();
            }

            return $sessionUsername;
        }

        else if(strlen($identifier) == 11){
            $stmt = $pdo->prepare("select nome from UsuarioComum where CPF= :cpf");
            $stmt->bindParam(':cpf', $identifier);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $sessionUsername = $stmt->fetch();
            }

            return $sessionUsername;
        }
    }


    //----------------------INFORMAÇÕES DA CONTA DO USUÁRIO DASHBOARD---------------------
    function userDashboard(){
        $pdo = dbConnection();

        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null))
        {
            $identifier = $_SESSION['identifier'];
            $stmt = $pdo->prepare("select email,telefone,CEP_UC,nome,dataNasc,foto from UsuarioComum where CPF= :cpf");
            $stmt->bindParam(':cpf', $identifier);
            $stmt->execute();

            if($stmt->rowCount()>0)
            {
                while ($rows = $stmt->fetch()) {
                    $name = utf8_encode($rows['nome']);
                    $email = $rows['email'];
                    $phone = $rows['telefone'];
                    $cep = $rows['CEP_UC'];
                    $photo = $rows['foto'];
                    $birth = $rows['dataNasc'];
                }
                if($photo == null || $photo == "")
                    $photo = "img/userDefault.png";

                echo "<form method='post' enctype='multipart/form-data'>";
                echo    "<div style='width: 90%; margin-left: 5%; float: left;'>
                            <div class='photo'>
                                <img src='".$photo."' id='defaultPhoto' onclick='chooseFile()'>            
                            </div><br>
                        </div>";
                echo "<div style='width: 30%; margin-left: 5%; margin-bottom: 5%; float: left;'><b class='inputTitle'>Nome:</b><br>";
                echo "<input type='text' id='newUserName' required name='newUserName' class='userDashboardData' value='".$name."'></div>";
                echo "<div style='width: 30%; margin-left: 30%; margin-bottom: 5%; float: left;'><b class='inputTitle'>Email:</b><br>";
                echo "<input type='email' id='newUserEmail' required name='newUserEmail' class='userDashboardData' value='".$email."'></div>";
                echo "<div style='width: 30%; margin-left: 5%; float: left; margin-bottom: 5%;'><b class='inputTitle'>Telefone:</b><br>";
                echo "<input type='tel' id='newUserPhone' required maxlength='11' minlength='10' name='newUserPhone' class='userDashboardData' value='".$phone."' onkeypress='return Phonemask()'></div>";
                echo "<div style='width: 30%; margin-left: 30%; float: left; margin-bottom: 5%;'><b class='inputTitle'>CEP:</b><br>";
                echo "<input type='text' id='newUserCEP' required maxlength='9' minlength='9' name='newUserCEP' class='userDashboardData' value='".$cep."' onkeypress='return CEPmask()'></div>";
                echo "<input type='file' name='newUserPhoto' id='Photo' accept='image.jpg,image.png,image.JPG' onchange='imagePreview(event)'>";
                echo "<input type='submit' id='btnUpdate' value='Atualizar Dados'>";
                echo "</form>";
                /*echo "<div style='width: 30%; margin-left: 5%; float: left;'><b class='inputTitle'>Data de Nascimento</b><br>";
                echo "<input type='date' id='newUserBirth' name='newUserBirth' class='userDashboardData'></div>";*/
            }

            else
                echo "erro";
        }
    }


    function updateUserData($name,$email,$phone,$cep,$photo){
        $pdo = dbConnection();

        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null)){
            $stmt = $pdo->prepare('update UsuarioComum set nome =:name, email =:email, telefone =:phone, CEP_UC =:cep, foto =:photo where CPF =:cpf');
            $stmt->bindParam(':cpf', $_SESSION['identifier']);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':photo', $photo);
            $stmt->execute();
        }
    }


    //----------------------INFORMAÇÕES DA CONTA DO USUÁRIO COMPRAS---------------------
    function userPurchases(){
        $pdo = dbConnection();
        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null))
        {

            //CONSULTA AO BD
            $identifier = $_SESSION['identifier'];
            $stmt = $pdo->prepare("select CNPJ,nomeProd,valor,servicoEntr,tipoTrans,dataTrans,dataEntrega,recebido,codigoTrans from CompraVenda where CPF= :cpf");
            $stmt->bindParam(':cpf', $identifier);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_BOTH);
            $result = count($rows);

            if($stmt->rowCount() > 0)
            {
                while ($result > 0) {
                    $cnpj = $rows[$result-1]['CNPJ'];
                    $prodName = utf8_encode($rows[$result-1]['nomeProd']);
                    $finalValue = $rows[$result-1]['valor'];
                    $auxFinalValue = strpos($rows[$result-1]['valor'], '.');
                    $auxFinalValue2 = (strlen($rows[$result-1]['valor'])-2);
                    if($auxFinalValue == 0)
                        $finalValue = $rows[$result-1]['valor'].".00";
                    else{
                        if($auxFinalValue == $auxFinalValue2)
                            $finalValue = $rows[$result-1]['valor']."0";
                        else
                            $finalValue = $rows[$result-1]['valor']; 
                    }
                    $finalValue = str_replace(".",",",$finalValue);               
                    $transport = utf8_encode($rows[$result-1]['servicoEntr']);
                    $payment = utf8_encode($rows[$result-1]['tipoTrans']);
                    $transactionID = $rows[$result-1]['codigoTrans'];
                    $purchaseDate = strtotime($rows[$result-1]['dataTrans']);
                    $deliveryDate = strtotime($rows[$result-1]['dataEntrega']);
                    $today = strtotime(date("Y-m-d"));
                    //DEFININDO COR DA BORDA SE JA FOI ENTREGE
                    if($today < $deliveryDate)
                        $borderColor = "#D6C01A";
                    else
                        $borderColor = "#48926A";

                    $purchaseDate = date('d/m/Y', $purchaseDate);
                    $deliveryDate = date('d/m/Y', $deliveryDate);
                    $result--;

                    $stmt2 = $pdo->prepare("select nome,email from UsuarioFloricultura where CNPJ= :cnpj");
                    $stmt2->bindParam(':cnpj', $cnpj);
                    $stmt2->execute();
                    if($stmt2->rowCount()>0){
                        while ($rows2 = $stmt2->fetch()) {
                            $shopName = utf8_encode($rows2['nome']);
                            $shopEmail = $rows2['email'];
                        } 
                    }
                    else
                        $shopName = "N/A";

                    //CRIANDO AS TRANSAÇÕES
                    echo "<div class='transactions' id='".$transactionID."' style='border-color: ".$borderColor."'>";
                    //NOME E CNPJ
                    echo "<div class='purchaseGroup'><b class='inputTitle'>Nome floricultura:</b> <div class=purchasesText style='margin-bottom: 10%;'>".$shopName."</div>";
                    echo "<b class='inputTitle'>CNPJ:</b> <div class=purchasesText>".$cnpj."</div></div>";
                    //PRODUTO E VALOR
                    echo "<div class='purchaseGroup'><b class='inputTitle'>Produto:</b> <div class=purchasesText style='margin-bottom: 10%;'>".$prodName."</div>";
                    echo "<b class='inputTitle'>Valor total:</b> <div class=purchasesText>R$ ".$finalValue."</div></div>";
                    //TRANSPORTADORA E PAGAMENTO
                    echo "<div class='purchaseGroup'><b class='inputTitle'>Transportadora:</b> <div class=purchasesText style='margin-bottom: 10%;'>".$transport."</div>";
                    echo "<b class='inputTitle'>Método de pagamento:</b> <div class=purchasesText>".$payment."</div></div>";
                    //DATA DE COMPRA E DATA DE ENTREGA
                    echo "<div class='purchaseGroup' style='border-right: 0; width: 23%;'><b class='inputTitle'>Data da compra:</b> <div class=purchasesText style='margin-bottom: 10%;'>".$purchaseDate."</div>";
                    echo "<b class='inputTitle'>Data de entrega prevista:</b> <div class=purchasesText>".$deliveryDate."</div></div>";
                    echo "<form method='post' id='report' action='report-problem.php'>
                        <input type='text' name='cnpjReport' value='".$cnpj."' hidden>
                        <input type='text' name='emailReport' value='".$shopEmail."' hidden>
                        <input type='submit' class='btnReport' id='btnReport' name='btnReport' value='Relatar Problema' readonly>
                        </form>";
                    echo "</div>";  
                }
                echo "<form method='post'>";
                echo "<input type='text' name='validator' value='1' hidden>";
                echo "<input type='submit' id='btnRelatory' value='Gerar relatório de compras'>";
                echo "</form>";
            }
            else{
                echo "<div class='noItems'><i class='fas fa-frown fa-5x' style='color: #ebebeb;'></i></div>";
                echo "<p class='noItemsText' align='center'>Você ainda não realizou nenhuma compra!</p>";
            }
        }
    }

    function relatory(){
        $pdo = dbConnection();
        $relatory = "";
        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null))
        {
            //CONSULTA AO BD
            $identifier = $_SESSION['identifier'];
            $stmt = $pdo->prepare("select CNPJ,nomeProd,valor,servicoEntr,tipoTrans,dataTrans,dataEntrega,recebido,codigoTrans from CompraVenda where CPF= :cpf");
            $stmt->bindParam(':cpf', $identifier);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_BOTH);
            $result = count($rows);

            if($stmt->rowCount() > 0)
            {
                while ($result > 0) {
                    $cnpj = $rows[$result-1]['CNPJ'];
                    $prodName = utf8_encode($rows[$result-1]['nomeProd']);
                    $finalValue = $rows[$result-1]['valor'];
                    $auxFinalValue = strpos($rows[$result-1]['valor'], '.');
                    $auxFinalValue2 = (strlen($rows[$result-1]['valor'])-2);
                    if($auxFinalValue == 0)
                        $finalValue = $rows[$result-1]['valor'].".00";
                    else{
                        if($auxFinalValue == $auxFinalValue2)
                            $finalValue = $rows[$result-1]['valor']."0";
                        else
                            $finalValue = $rows[$result-1]['valor']; 
                    } 
                    $finalValue = str_replace(".",",",$finalValue);               
                    $transport = utf8_encode($rows[$result-1]['servicoEntr']);
                    $payment = utf8_encode($rows[$result-1]['tipoTrans']);
                    $transactionID = $rows[$result-1]['codigoTrans'];
                    $purchaseDate = strtotime($rows[$result-1]['dataTrans']);
                    $deliveryDate = strtotime($rows[$result-1]['dataEntrega']);
                    $today = strtotime(date("Y-m-d"));
                    $purchaseDate = date('d/m/Y', $purchaseDate);
                    $deliveryDate = date('d/m/Y', $deliveryDate);
                    $result--;

                    $stmt2 = $pdo->prepare("select nome,email from UsuarioFloricultura where CNPJ= :cnpj");
                    $stmt2->bindParam(':cnpj', $cnpj);
                    $stmt2->execute();
                    if($stmt2->rowCount()>0){
                        while ($rows2 = $stmt2->fetch()) {
                            $shopName = utf8_encode($rows2['nome']);
                            $shopEmail = $rows2['email'];
                        } 
                    }
                    else
                        $shopName = "N/A";
                    $relatory.="Código da Compra: ".$transactionID."\nCNPJ da Floricultura: ".$cnpj."\nNome da Floricultura: ".$shopName."\nNome do Produto: ".$prodName."\nValor da Compra: ".$finalValue."\nTransportadora: ".$transport."\nForma de Pagamento: ".$payment."\nData da Compra: ".$purchaseDate."\nData de Entrega: ".$deliveryDate."\n______________________________________\n\n";
                }
            }
            return $relatory;
        }
    }

    function userPlants(){
        $pdo = dbConnection();
        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null))
        {
            //CONSULTA AO BD
            $identifier = $_SESSION['identifier'];
            $stmt = $pdo->prepare("select idPlant,idAcomp,dataAcomp from Acompanhamento where CPF= :cpf");
            $stmt->bindParam(':cpf', $identifier);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_BOTH);
            $result = count($rows);

            if($stmt->rowCount() > 0)
            {
                while ($result > 0) {
                    $idPlant = $rows[$result-1]['idPlant'];
                    $idAcomp = $rows[$result-1]['idAcomp'];
                    $acompDate = strtotime($rows[$result-1]['dataAcomp']);
                    $acompDate = date('d/m/Y', $acompDate);
                    $result--;

                    $stmt2 = $pdo->prepare("select nome,nomeCientifico from Planta where codigo= :id");
                    $stmt2->bindParam(':id', $idPlant);
                    $stmt2->execute();
                    if($stmt2->rowCount()>0){
                        while ($rows2 = $stmt2->fetch()) {
                            $plantName = utf8_encode($rows2['nome']);
                            $plantImg = "img/".strtolower(utf8_encode($rows2['nomeCientifico']))."Index.jpg";
                        } 
                    }
                    else
                        $shopName = "N/A";
                    echo "<div class='plants'>";
                    echo "<img class='plantImg' src='".$plantImg."'>";
                    echo "<div class='plantGroup'><b class='inputTitle'>Planta:</b><br><p id='plantText'>".$plantName."</p></div>";
                    echo "<div style='margin-left: 3%;'><b class='inputTitle'>Acompanhando desde:</b><br><p id='plantText'>".$acompDate."</p></div>";
                    echo "</div>";
                }
            }
            else{
                echo "<div class='noItems'><i class='fas fa-frown fa-5x' style='color: #ebebeb;'></i></div>";
                echo "<p class='noItemsText' align='center'>Você ainda não tem plantas!</p>";
            }
            echo "<div style='margin-bottom: 1%; float: left; width:100%; height: 1%;'></div>";
        }
    }

    function userSettings(){
        $pdo = dbConnection();
        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null))
        {
            $identifier = $_SESSION['identifier'];
            echo "<form method='POST'>";
            echo "<div class='btnSwitch'><input type='checkbox' value='on1' name='settings[]' ><div class='settingsText'>Receber emails de ofertas</div></div>";
            echo "<div class='btnSwitch'><input type='checkbox' value='on2' name='settings[]' ><div class='settingsText'>Tema escuro</div></div>";
            echo "<div class='btnSwitch'><input type='checkbox' value='on3' name='settings[]' ><div class='settingsText'>Lembrar do meu usuário</div></div><br><br>";
            echo "<input type='submit' value='Salvar'>";
            echo "</form>";
            echo "<br><br><br>(AINDA EM DESENVOLVIMENTO)";
        }
    }

    function userDelete(){
        $pdo = dbConnection();
        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null))
        {
            $identifier = $_SESSION['identifier'];
            echo "<form method='POST'>";
            echo "<div style='width: 30%; margin-left: 5%; margin-right: 40%; float: left; margin-bottom: 5%;'><b class='inputTitle'>Senha:</b><br>";
            echo "<input type='password' id='deletePassword' required name='deletePassword' class='userDeleteAccount'></div>";
            echo "<div style='width: 30%; margin-left: 5%; margin-right: 40%; float: left; margin-bottom: 5%;'><b class='inputTitle'>Confirme Senha:</b><br>";
            echo "<input type='password' id='deleteConfirmPassword' required name='deleteConfirmPassword' class='userDeleteAccount'></div>";
            echo "<input type='submit' id='btnDelete' value='Desativar Conta'>";
            echo "</form>";
        }
    }

    function deleteAccount($identifier){
        $pdo = dbConnection();
        try{
            if(strlen($identifier)==11){
                $stmt = $pdo->prepare("select foto from UsuarioComum where CPF = :cpf");
                $stmt->bindParam(":cpf", $identifier);
                $stmt->execute();
                $row = $stmt->fetch();
                $photo = $row["foto"];

                unset($_SESSION['identifier']);
                $stmt = $pdo->prepare("delete from UsuarioComum where CPF = :cpf");
                $stmt->bindParam(":cpf", $identifier);
                $stmt->execute();
                if ($photo != null)
                    unlink($photo);
                header("Location: index.php");
            }
            else if(strlen($identifier)==14){
                $stmt = $pdo->prepare("select foto from UsuarioFloricultura where CNPJ = :cnpj");
                $stmt->bindParam(":cnpj", $identifier);
                $stmt->execute();
                $row = $stmt->fetch();
                $photo = $row["foto"];

                unset($_SESSION['identifier']);
                $stmt = $pdo->prepare("delete from UsuarioFloricultura where CNPJ = :cnpj");
                $stmt->bindParam(":cnpj", $identifier);
                $stmt->execute();
                if ($photo != null)
                    unlink($photo);
                header("Location: index.php");
            }
            else
                echo "CPF/CNPJ ERROR";
        }
        catch (PDOException $e) {
            echo "Conta não excluída - ERRO: " . $e->getMessage();
        }

    }

    function addItemCart($shopCnpj,$shopName,$shopEmail,$shopStock,$idProd,$index){
        $pdo = dbConnection();
        $stmt = $pdo->prepare("select nome,nomeCientifico from Planta where codigo= :id");
        $stmt->bindParam(':id', $idProd);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while ($rows = $stmt->fetch()) {
                $plantName = utf8_encode($rows['nome']);
                $caracteres_sem_acento = array('Š'=>'S', 'š'=>'s', 'Ð'=>'Dj',''=>'Z', ''=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A','Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I','Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U','Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a','å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i','ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u','ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f','ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T');

                $plantImg = strtolower($plantName);
                $plantImg = strtr($plantImg, $caracteres_sem_acento);
                $plantImg = "img/".$plantImg."Index.jpg";
            }
        }

        $stmt = $pdo->prepare("select precoUnit from Estoque where CNPJ= :cnpj AND codigoPlant= :id");
        $stmt->bindParam(':cnpj', $shopCnpj);
        $stmt->bindParam(':id', $idProd);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while ($rows = $stmt->fetch()) {
                $unitPrice = $rows['precoUnit'];
                $auxFinalValue = strpos($rows['precoUnit'], '.');
                $auxFinalValue2 = (strlen($rows['precoUnit'])-2);
                if($auxFinalValue == $auxFinalValue2)
                    $unitPrice2 = $unitPrice."0";
                else
                    $unitPrice2 = $unitPrice;
            }
        }

        $aux = $index."purchase";
        $aux2 = $index."cartPrice";
        $aux3 = $index."plantName";
        echo "<div class='cartItem'>";
        echo "<div class='cartProdImg'><img src='".$plantImg."' style='width: 100%; height: 100%; border-radius: 5px;'></div>";
        echo "<input type='text' class='cartText' id='cartPlant' name='".$aux3."' value='".$plantName."' readonly>";
        echo "<div class='cartText' id='qtde'><select id='".$index."' name='".$aux."' onchange='totalPrice(this.id,this.value)' style='width: 100%;'>";
        if($shopStock <= 10)
            for ($i=1; $i<=$shopStock; $i++) { 
                echo "<option value='".$i."'>".$i."</option>";
            }
        else if($shopStock > 10)
            for ($i=1; $i<=10; $i++) { 
                echo "<option value='".$i."'>".$i."</option>";
            }
        echo "</select><br><div style='margin: 0; font-weight: 100; font-size: 85%; text-align: center; margin-top: 3%;'>Quantidade</div></div>";
        echo "<input type='text' class='cartText' id='cartShop' name='".$shopCnpj."' value='".$shopName."'readonly>";
        echo "<input type='text' class='cartText' id='cartPriceUnit".$index."' name='cartPriceUnit' value='".$unitPrice."' hidden>";
        echo "<input type='text' class='cartText' id='cartPrice".$index."' name='".$aux2."' value='".$unitPrice2."'readonly style='text-align: center;'>";
        echo "<a id='btnDelete' class='deleteItem' href='?delete=".$index."'><p style='color: white'>Deletar do Carrinho</p></a>";
        echo "</div>";

        echo "<script>";
        echo "function totalPrice(id,value){
            aux = (String(document.getElementById('cartPriceUnit'+id).value*value)).length-2;
            aux2 = (String(document.getElementById('cartPriceUnit'+id).value*value)).indexOf('.');
            if(aux==aux2){
                document.getElementById('cartPrice'+id).value=(((document.getElementById('cartPriceUnit'+id).value*value)+'0'));
            }
            else{
                document.getElementById('cartPrice'+id).value=((document.getElementById('cartPriceUnit'+id).value*value)).toFixed(2);  
            }
            purchaseValueUpdate();
        }";
        echo "</script>";
    }

    function flowerShopData($cnpj){
        $pdo = dbConnection();
        $stmt = $pdo->prepare("select email,nome,telefone,CEP_UF from UsuarioFloricultura where CNPJ = :cnpj");
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while ($rows = $stmt->fetch()) {
                $name = utf8_encode($rows['nome']);
                $email = utf8_encode($rows['email']);
                $phone = utf8_encode($rows['telefone']);
                $cep = utf8_encode($rows['CEP_UF']);
            }
        }
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $url = "https://viacep.com.br/ws/$cep/json";
        $url = curl_init($url);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($url);
        curl_close($url);
        $data = json_decode($response, true);

        echo    "<div class='flowerShopData'>
                    <i class='fas fa-store'></i>Nome: ".$name."<br>
                    <i class='fas fa-envelope'></i>Email: ".$email."<br>
                    <i class='fas fa-phone-square-alt'></i>Telefone: ".$phone."<br>
                    <i class='fas fa-map-marker-alt'></i>CEP: ".$data['cep']."<br>
                    <div style='font-size: 90%; border-style: solid; border-width: 2px; border-top: 0; border-bottom: 0; border-right: 0; padding-left: 1%; margin-left: 1%; border-color: rgb(235,235,235);'>
                    Rua: ".$data['logradouro']."<br>
                    Bairro: ".$data['bairro']."<br>
                    Cidade: ".$data['localidade']."</div><hr>                    
                </div>";
    }

    function consultUser($select){
        if((strlen($_SESSION['identifier'])==11) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null)){
            $pdo = dbConnection();
            $stmt = $pdo->prepare("select ".$select." from UsuarioComum where CPF = :cpf");
            $stmt->bindParam(':cpf', $_SESSION['identifier']);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                while ($rows = $stmt->fetch())
                    return utf8_encode($rows[$select]);
            }
            else
                return null;
        }
        else if((strlen($_SESSION['identifier'])==14) && (isset($_SESSION['identifier'])) && ($_SESSION['identifier'] != null)){
            $pdo = dbConnection();
            $stmt = $pdo->prepare("select ".$select." from UsuarioFloricultura where CNPJ = :cnpj");
            $stmt->bindParam(':cnpj', $_SESSION['identifier']);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                while ($rows = $stmt->fetch())
                    return utf8_encode($rows[$select]);
            }
            else
                return null;
        }
        else
            return null;
    }
?>