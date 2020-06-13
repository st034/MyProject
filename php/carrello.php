
<!DOCTYPE html>
<html>
<title>SN Sunglasses.com</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/style.css">
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-wide w3-padding w3-card">
    <a href="#home" class="w3-bar-item w3-button"><b>SN</b> Sunglasses</a>
    <!-- Float links to the right. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
      <a href="../home.php" class="w3-bar-item w3-button">Home</a>
      <a href="carrello.php" class="w3-bar-item w3-button">Carrello</a>
      <a href="dashboard.php" class="w3-bar-item w3-button">PersonalArea</a>
      <?php 
        session_start();
        if (isset($_SESSION['session_user'])) {
        echo'<a href="logout.php" class="w3-bar-item w3-button">Logout</a>';
      }
        else{
          echo'<a href="logineregistration.php" class="w3-bar-item w3-button">Login/Register</a>';
        }
      ?>
    </div>
  </div>
</div>

<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
  <img class="w3-image" src="/w3images/architect.jpg" alt="Architecture" width="1500" height="800">
  <div class="w3-display-middle w3-margin-top w3-center">
    <h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><b>BR</b></span> <span class="w3-hide-small w3-text-light-grey">Architects</span></h1>
  </div>
</header>

<!-- Page content -->
<div class="w3-content w3-padding" style="max-width:1564px">

  <!-- Project Section -->
  <div class="w3-container w3-padding-32" id="models">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Models</h3>
  </div>

      
<?php

require_once('connectorDatabase.php');
require_once('validate.php');
require_once('product.php');

 if(!isset($_SESSION['session_user'])){
    echo'effettua il login o la registrazione prima di acquistare';
    exit;}
else{ if (isset($_POST["addBuy"])) {

  $idProduct = $_POST['idproduct'] ?? '';    //?? is egual to: $foo = $bar ?? 'something'; $foo = isset($bar) ? $bar : 'something'
  $quantità = $_POST['quantità'] ?? '';

  $idProduct=Ceckintvalidate($idProduct);
  $quantità=Ceckintvalidate($quantità);
  echo $idProduct;
  addProduct($idProduct, $quantità);  
}  
}if(isset($_POST['Remove'])){
  $idProduct=$_POST['idproduct'] ?? '';
  removeThis($idProduct);
}

showcarrello();



function removeThis($idProduct){
  $id=searchIdUser();
  $pdo=preparedbuser();
  $result2 = $pdo->prepare("DELETE FROM orders WHERE id_FK=? AND idp_FK=? AND state=0"); 
  $result2->bindParam(1, $id, PDO::PARAM_INT);
  $result2->bindParam(2, $idProduct, PDO::PARAM_INT);
  $result2->execute();
  if ($result2->rowCount() > 0){
    echo '<h3>Rimosso<h3>';
}

}

function searchIdUser(){
    $user=$_SESSION['session_user'];
    $pdo=preparedbuser();
      $result = $pdo->prepare("SELECT id FROM users WHERE username LIKE ?");
      $result->bindParam(1, $user, PDO::PARAM_STR);
      $result->execute();
  
      if ($result->rowCount() > 0){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row["id"];
        }
    else{
       echo 'error!! Retry your login';
    }
}
function showcarrello(){
    $user=searchIdUser();
    $pdo=preparedbuser();
      $result = $pdo->prepare("SELECT * FROM orders,product WHERE id_FK LIKE ? AND state = '0' AND idp_FK=idp"); 
      $result->bindParam(1, $user, PDO::PARAM_STR);
      $result->execute();
      if ($result->rowCount() > 0){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<img src="../'.$row["img"].'" style="width:20%"> <article> <h1>'.$row["name"].'</h1><p>'.$row["description"].
            '<br>'.$total=$row["price"]*$row["number"].'£TOTAL<br>'.$row["number"].'PZ.</p></article><br>
            <form method="post" action="carrello.php">
            <button type="submit" name="Remove" value="Remove">Rimuovi dal carrello</button>
            <input type="hidden" name="idproduct" value='.$row["idp"].'>
            </form>'
            ;  
        }
    }else{
       echo 'carrello vuoto';
       exit;
    }echo'<form method="post" action="buy.php">
         <button type="submit" name="BUYNOW" value="BUYNOW">COMPRA ORA</button>
         </form>';
}


function addProduct($productID, $number){
  $user=searchIdUser();
  $pdo=preparedbuser();
      $result = $pdo->prepare("SELECT * FROM orders WHERE id_FK = ? AND state = '0' AND idp_FK=?"); 
      $result->bindParam(1, $user, PDO::PARAM_INT);
      $result->bindParam(2, $productID, PDO::PARAM_INT);
      $result->execute();
      if ($result->rowCount() > 0){
            echo 'questo prodotto è già presente nel carrello' ;
            exit;
        }
        closedb($pdo);
      
        $pdo2=preparedbuser();
        $result2 = $pdo2->prepare("INSERT INTO orders VALUES (0, ?, ?, ?, 0)"); 
        $result2->bindParam(1, $user, PDO::PARAM_STR);
        $result2->bindParam(2, $productID, PDO::PARAM_STR);
        $result2->bindParam(3, $number, PDO::PARAM_STR);
        $result2->execute();
        if ($result2->rowCount() > 0){
          echo 'inserito!';
      }

    
}

?>


     


    </body>
</html>