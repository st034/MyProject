<?php
  require_once('connectorDatabase.php');
  require_once('validate.php');


function showProduct(){
  $pdo=preparedbuser();
    $query = "SELECT * FROM product";
    $result=$pdo->query($query);

    if ($result->rowCount() > 0){
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="w3-row-padding">
                <div class="w3-row-padding">
                  <div class="w3-col l3 m6 w3-margin-bottom">
                    <div class="w3-display-container">
                    <div class="w3-display-topleft w3-black w3-padding">'.$row["name"].'</div>
                      <img src="'.$row["img"].'"alt="Glasses" style="width:70%">
                      <article> <h1>'.'</h1><p>'.$row["description"].
                     '<br>'.$row["price"].'£<br>'.$row["quantity"].'PZ.</p></article><br>
                    </div>
                  </div>
                <form method="post" action="php/carrello.php">
                  <input type="number" id="quantità" placeholder="Quantità" name="quantità" maxlength="10" required>
                  <input type="hidden" name="idproduct" value='.$row["idp"].'>
                  <button type="submit" name="addBuy" value="addBuy">Aggiungi al carrello</button>
                </form>';
      }
  }
}


function searchproduct($name){
  $a='%';
  $name=$a.$name.$a;
  $pdo=preparedbuser();
    $result = $pdo->prepare("SELECT * FROM product WHERE name LIKE ?");
    $result->bindParam(1, $name, PDO::PARAM_STR);
    $result->execute();

    if ($result->rowCount() > 0){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<img src="'.$row["img"].'" style="width:10%">';
        }
    }else{
      echo 'no results';
      }
}
function showProductById($idp){
  $pdo=preparedbuser();
    $result=$pdo->prepare("SELECT * FROM product WHERE idp = ?");
    $result->bindParam(1, $idp, PDO::PARAM_INT);
    if ($result->rowCount() > 0){
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          return $row;
      }
    }

}
?>
