<?php

require_once('connectorDatabase.php');
require_once('validate.php');
require_once('product.php');
require_once('carrello.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
}


if(isset($_POST["BUYNOW"])){ 
    $check=ceckAdressAndcredit();
    if($check==""){
        goOrder();
    }}


function ceckAdressAndcredit(){
    $user=searchIdUser();
      $pdo=preparedbuser();
        $result1 = $pdo->prepare("SELECT * FROM adress WHERE id_FK=?"); 
        $result1->bindParam(1, $user, PDO::PARAM_INT);
        $result1->execute();
        if ($result1->rowCount() > 0){
          $result1 = $pdo->prepare("SELECT * FROM banking WHERE id_FK=?"); 
          $result1->bindParam(1, $user, PDO::PARAM_INT);
          $result1->execute();
          }else{
            echo 'adressError';
            return "adressError";
           exit;
        } if ($result1->rowCount() > 0){
            return "";
          } else{
            echo 'creditError';
            return "creditError";
          }
}
  
  
  function goOrder(){
    $user=searchIdUser();
    $pdo=preparedbuser();
    $result = $pdo->prepare("SELECT * FROM orders,product WHERE id_FK =? AND idp_FK=idp AND state ='0' AND quantity>=number"); 
          $result->bindParam(1, $user, PDO::PARAM_INT);
          $result->execute();
          if ($result->rowCount() > 0){
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $result1 = $pdo->prepare("UPDATE orders SET state='1' WHERE idorder=?"); 
              //$date=date("d/m/y");

              $result1->bindParam(1, $row['idorder'], PDO::PARAM_INT);

              $result1->execute();
            
            $update=$row['quantity']-$row['number'];
  
            $result2 = $pdo->prepare("UPDATE product SET quantity=? WHERE idp=? " ); 
              $date=date("d/m/y");
              $result2->bindParam(1, $update, PDO::PARAM_INT);
              $result2->bindParam(2, $row['idp_FK'], PDO::PARAM_INT);
              $result2->execute();
          }
        }else {echo'non abbiamo abbastanza prodotti disponibili, riprova in futuro';
                exit;}
            echo 'acquisto effettuato!';
  
  }


?>