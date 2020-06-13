<!DOCTYPE html>
<html>
<title>SN Sunglasses.com</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/style.css">
<body>

<div class="w3-top">
  <div class="w3-bar w3-white w3-wide w3-padding w3-card">
    <a href="#home" class="w3-bar-item w3-button"><b>SN</b> Sunglasses</a>

    <div class="w3-right w3-hide-small">
      <a href="../home.php" class="w3-bar-item w3-button">Home</a>
      <a href="carrello.php" class="w3-bar-item w3-button">Carrello</a>
      <a href="dashboard.php" class="w3-bar-item w3-button">PersonalArea</a>
      
      <?php    
         session_start();
         if (isset($_SESSION['session_user'])) {
             echo'<a href="logout.php" class="w3-bar-item w3-button">Logout</a>';
          }else{
                echo'<a href="logineregistration.php" class="w3-bar-item w3-button">Login/Register</a>';
           }
      ?>

    </div>
  </div>
</div>

<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
  <div class="w3-display-middle w3-margin-top w3-center">
    <h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><b>BR</b></span> <span class="w3-hide-small w3-text-light-grey">Architects</span></h1>
  </div>
</header>

<div class="w3-content w3-padding" style="max-width:1564px">

  <div class="w3-container w3-padding-32" id="models">
  <?php
      if (isset($_SESSION['session_user'])){
         echo'<h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Benvenuto '.$_SESSION['session_user'].'</h3>';
      }
  ?>
  </div>

<?php

require_once('connectorDatabase.php');
if (isset($_SESSION['session_user'])){
    
  actualyAdress();
  actualyCreditCard();
  updateAdress();
  updateCredit();

}else{
    printf("Effettua il login per accedere all'area riservata", '<a href="../home.html">login</a>');
  }


if(isset($_POST["UpdateAdress"])){ 
    $city = $_POST['city'] ?? '';
    $adress = $_POST['adres'] ?? '';
    $number = $_POST['number'] ?? '';
    $postalcode = $_POST['postalcode'] ?? '';
    addAdress($city,$adres,$number,$postalcode);    
}

if(isset($_POST["UpdateCreditcard"])){ 
    $creditcard = $_POST['creditcard'] ?? '';
    $proprietyname = $_POST['proprietyname'] ?? '';
    $proprietysurname = $_POST['proprietysurname'] ?? '';
    creditCard($creditcard,$proprietyname,$proprietysurname);    
}



function actualyAdress(){
    $user=searchIdUser();
    $pdo=preparedbuser();
      $result = $pdo->prepare("SELECT * FROM adress WHERE id_FK=?"); 
      $result->bindParam(1, $user, PDO::PARAM_STR);
      $result->execute();
      if ($result->rowCount() > 0){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '
                  <h2>Actual adress :
                      </h2>City: '.$row["city"].'
                           Adress: '.$row["adres"].
                        'Number: '.$row["number"].'
                           Postalcode: '.$row["postalcode"].'
                  <br>';    

            closedb($pdo);
        }
    }else{
       echo 'Non hai nessun indirizzo salvato';
       echo'<br>';



}}

function actualyCreditCard(){
    $user=searchIdUser();
    $pdo=preparedbuser();
      $result = $pdo->prepare("SELECT * FROM banking WHERE id_FK=? "); 
      $result->bindParam(1, $user, PDO::PARAM_STR);
      $result->execute();
      if ($result->rowCount() > 0){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<h2>Actual Credit Card:</h2>
            Credit card number: '.$row["creditcard"].'   Intestatario:  '.$row["proprietyname"].' '.$row["proprietysurname"] ;
       
       
        }
    }else{
       echo '<h2>Non hai nessuna carta registrata<h2>';


}}
function updateAdress(){
    echo'<form method="post" action="dashboard.php">
             <h1>Add an Adress</h1><br>
                <input type="text" id="City" placeholder="City" name="city" maxlength="50" required>
                <input type="text" id="Adres" placeholder="Adres" name="adres" maxlength="100" required>
                <input type="text" id="Number" placeholder="Number" name="number" required>
                <input type="text" id="Postalcode" placeholder="Postalcode" name="postalcode" maxlength="50" required>
                <button type="submit" name="UpdateAdress" value="adress">Update</button>
                <FORM>
        </form>';
}

function updateCredit(){
    echo'<form method="post" action="dashboard.php">
             <h1>Add an creditCard</h1><br>
                <input type="text" id="creditcard" placeholder="creditcard" name="creditcard" maxlength="50" required>
                <input type="text" id="$proprietyname" placeholder="proprietyname" name="proprietyname" maxlength="100" required>
                <input type="text" id="proprietysurname" placeholder="proprietysurname" name="proprietysurname" required>
                <button type="submit" name="UpdateCreditcard" value="creditcard">Update</button>
        </form>';
}


function addAdress($city,$adres,$number,$postalcode){
        $user=searchIdUser();
        $pdo=preparedbuser();
          $result = $pdo->prepare("SELECT * FROM adress WHERE id_FK=? "); 
          $result->bindParam(1, $user, PDO::PARAM_STR);
          $result->execute();
          if ($result->rowCount() > 0){
            closedb($pdo);
            $pdo=preparedbuser();
            $check = $pdo->prepare('UPDATE adress SET city=?, adres=?, number=?, postalcode=? WHERE id_FK=?');
            $check->bindParam(1, $city, PDO::PARAM_STR);
            $check->bindParam(2, $adres, PDO::PARAM_STR);
            $check->bindParam(3, $number, PDO::PARAM_STR);
            $check->bindParam(4, $postalcode, PDO::PARAM_STR;
            $check->bindParam(5, $user, PDO::PARAM_INT);
            $check->execute();
            if ($check->rowCount() > 0){
              echo'inserito';
            }
            }else{
                 $check = $pdo->prepare('INSERT INTO adress VALUES (?,?,?,?,?)');
                 $check->bindParam(1, $user, PDO::PARAM_INT);
                 $check->bindParam(2, $city, PDO::PARAM_STR);
                 $check->bindParam(3, $adres, PDO::PARAM_STR);
                 $check->bindParam(4, $number, PDO::PARAM_STR);
                 $check->bindParam(5, $postalcode, PDO::PARAM_STR);
                 $check->execute();
            }if($check->rowCount() > 0) {
                 $msg = 'Inserito';
                } else {
                         $msg = 'Errore';
                 }  
                
        
}

function creditCard($creditcard, $proprietyname, $proprietysurname){
    $user=searchIdUser();
        $pdo=preparedbuser();
          $result = $pdo->prepare("SELECT * FROM banking WHERE id_FK=? "); 
          $result->bindParam(1, $user, PDO::PARAM_STR);
          $result->execute();
          if ($result->rowCount() > 0){
            closedb($pdo);
            $pdo=preparedbuser();
            $check = $pdo->prepare('UPDATE banking SET creditcard=?, proprietyname=?, proprietysurname=? WHERE id_FK=?');
            $check->bindParam(1, $creditcard, PDO::PARAM_STR);
            $check->bindParam(2, $proprietyname, PDO::PARAM_STR);
            $check->bindParam(3, $proprietysurname, PDO::PARAM_STR);
            $check->bindParam(4, $user, PDO::PARAM_INT);
            $check->execute();
            if ($check->rowCount() > 0){
              echo'inserito';
            }
            }else{
                 $check = $pdo->prepare('INSERT INTO banking VALUES (?,?,?,?)');
                 $check->bindParam(1, $user, PDO::PARAM_INT);
                 $check->bindParam(2, $creditcard, PDO::PARAM_STR);
                 $check->bindParam(3, $proprietyname, PDO::PARAM_STR);
                 $check->bindParam(4, $proprietysurname, PDO::PARAM_STR);
                 $check->execute();
            }if($check->rowCount() > 0) {
                 echo'Inserito';
                } else {
                         echo'Errore';
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
        
  
?>
    </body>
</html>