
<!DOCTYPE html>
<html>
<title>SN Sunglasses.com</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-wide w3-padding w3-card">
    <a href="#home" class="w3-bar-item w3-button"><b>SN</b> Sunglasses</a>
    <!-- Float links to the right. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
      <a href="home.php" class="w3-bar-item w3-button">Home</a>
      <a href="./php/carrello.php" class="w3-bar-item w3-button">Carrello</a>
      <a href="./php/dashboard.php" class="w3-bar-item w3-button">PersonalArea</a>
      <?php     session_start();
      if (isset($_SESSION['session_user'])) {
        echo'<a href="./php/logout.php" class="w3-bar-item w3-button">Logout</a>';
      }
        else{
          echo'<a href="./php/logineregistration.php" class="w3-bar-item w3-button">Login/Register</a>';
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

    <? 
    include_once('php/product.php');
    showProduct();
    ?>
</body>
</html>
