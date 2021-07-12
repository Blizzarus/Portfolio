<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Logout</title>
      <script type="text/javascript" src="js/functions.js"></script> 
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body class='backgroundImage'>
      <?php
            unset($_SESSION['userStatus']);
            unset($_SESSION['userName']);
            session_destroy();
      ?>       
    <main>
        <header>
            <h1>Logout Complete!</h1>
            <h3>Visit again soon!</h3>
        </header>
        <nav class="navbar">
            <a href="index.php"class="active">Home</a>
            <div class="dropdown">
              <button class="dropbtn">Gaming
                <i class="fa fa-caret-down"></i>
              </button>
              <div class="dropdown-content">
                <div class="header">
                  <div>Game Console Information</div>
                </div>   
                <div class="row">
                  <div class="column">
                    <header>View Data</header>
                    <a href="listCompanies.php">List of Companies</a>
                    <a href="listConsoles.php">List of Consoles</a>
                    <a href="listGames.php">List of Titles</a>
                    <a href="listConsoleGames.php">List Games by Console</a>
                    <a href="listConsoleGamesbyTime.php">List Games by Console <br>
                    <i>(Ordered by most recent update)</i></a>
                  </div>
                  <div class="column">
                  <?php
                      echo Admin();
                  ?>
                  </div>
                  <div class="column">

                  </div>
                  <div class="column">

                  </div>
                </div>
              </div>
            </div> 
            <a href="listCompanies.php">Companies</a>
            <div style="position:relative;float:right;margin-right:50px;">
                <a href='login.php'>Login</a>
            </div>
        </nav>
        <section>

        </section>
        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>