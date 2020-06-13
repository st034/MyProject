
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
            }
            else{
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
    <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Login</h1>
  </div>
<form method="post" action="login.php">
            <input type="text" id="username" placeholder="Username" name="username">
            <input type="password" id="password" placeholder="Password" name="password">
            <button type="submit" name="login">Accedi</button>
</form>

<div class="w3-container w3-padding-32" id="models">
    <h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Registration</h1>
</div>

<form method="post" action="register.php">
        <div><input type="text" id="username" placeholder="Username" name="username" maxlength="50" required>
        <input type="password" id="password" placeholder="Password" name="password" required></div>
        <div><input type="text" id="name" placeholder="Name" name="name" maxlength="20" required>
        <input type="text" id="surname" placeholder="Surname" name="surname" required></div>
        <div><input type="text" id="email" placeholder="Email" name="email" maxlength="50" required>
        <input type="date" id="password" placeholder="Date of birth" name="birthday" required></div>
        <button type="submit" name="register">Registrati</button>
</form>

        

    </body>
</html>