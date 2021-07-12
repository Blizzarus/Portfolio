<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Index</title>
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body class='backgroundImage'>
    <main>
        <header>
            <h1>Check out all the latest in Gaming Hardware!</h1>
            <h3>Click the links below to see more!</h3>
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
                <?php 
                    if (isset($_SESSION['userStatus']) && isset($_SESSION['userName']))
                    {
                        if ($_SESSION['userStatus'] == 1)
                        {
                          echo "<a href='logout.php'>Logout</a><div style='color:white;width:300px;margin-top:14px'>" . $_SESSION['userName'] . "</div>";
                        }
                    }
                    else
                    {
                        echo "<a href='login.php'>Login</a>";
                    }
                ?>
            </div>
        </nav>
        <section>
 
        </section>
        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>