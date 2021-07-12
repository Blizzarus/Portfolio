<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Add Console Game</title>
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body class='backgroundImage'>
  <?php 
        $error = "";
        $console = "";
        $game = "";
        $capabilities = "";
        $players = "";

        function clean_text($string)
        {
            $string = trim($string);
            $string = stripslashes($string);
            $string = htmlspecialchars($string);
            return $string;
        }

        if(isset($_POST["reset"]))
        {
            $error="";
            
        }

        if(isset($_POST["Add"]))
        {

          if(empty($_POST["lbCapabilities"]))
          {
              $error .= '<label class="text-danger">Capability data is required.</label><br />';
          }
          else
          {
              $capabilities = clean_text($_POST["lbCapabilities"]);
          }

          if(empty($_POST["lbConsoles"]))
          {
              $error .= '<label class="text-danger">Console selection is required.</label></br>';
          }
          else
          {
              $console = clean_text($_POST["lbConsoles"]);
          }

          if(empty($_POST["lbGames"]))
          {
              $error .= '<label class="text-danger">Game selection is required.</label></br>';
          }
          else
          {
              $game = clean_text($_POST["lbGames"]);
          }

          if(empty($_POST["players"]))
          {
              $error .= '<label class="text-danger">Maximum number of players is required.</label></br>';
          }
          else
          {
              $players = clean_text($_POST["players"]);
              if (!is_numeric($players))
              {
                $error .= '<label class="text-danger">Player count must be a number.</label></br>';
              }
          }



          if($error == "")
          {
              $console = $_POST["lbConsoles"];
              $game = $_POST["lbGames"];
              $capabilities = $_POST["lbCapabilities"];
              $players = $_POST["players"];
              //echo "Code=" . $_POST["lbKennels"];

            $error = addConsoleGame($console, $game, $capabilities, $players);
            // $error = "<label class='text-success'>" . $pName . " has been added.</label>";
            $console = "";
            $game = "";
            $capabilities = "";
            $players = "";
          }
            
        }
    ?>
    <main>
        <header>
            <h1>Admin Page - Add New Console-Game Relationships.</h1>
            <h3>Use the links in the menu below to add other data.</h3>
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
              <article class="article100">
                  <form id="formInsert" action="addConsoleGame.php" method="post">
                      <?php echo $error; ?>
                      <div class='title'>Add a Console-Game Relationship</div>
                      <br>
                      <table class="table100">
                        <tr>
                            <td>Select Console:</td>
                            <td>
                                <?php
                                    $ConsolesList = loadConsoleListBox();
                                    echo $ConsolesList;
                                    //echo $error;
                                ?>        
                            </td>
                            <td>Select Game:</td>
                            <td>
                                <?php
                                    $GamesList = loadGameListBox();
                                    echo $GamesList;
                                    //echo $error;
                                ?>        
                            </td>
                            <td>*Local & Network Play Capabilities:</td>
                            <td>
                              <select class='formFont' id='lbCapabilities' name='lbCapabilities'>
                                <option id='' value='' ></option>
                                <option id='Local Only' value='Local Only'>Local Play Only</option>
                                <option id='Online Only' value='Online Only'>Online Play Only</option>
                                <option id='Local & Online' value='Local & Online'>Local Play & Online Play</option>
                              </select>
                          </td>
                            <td>Maximum Number of Players:</td>
                          <td>
                              <input class="formFont" type="text" name="players" value="<?php echo $players; ?>" />
                          </td>
                          </tr>
                          <tr>
                            <td colspan='4' class='noBG'></td>
                            <td class='noBG'>
                                <br>
                                <input style='margin-left: 100px;' class="formFont" type="Submit" name="Add" value="Add Data">
                                <input class="formFont" type="Submit" name="Reset" value="Cancel">
                            </td>
                            <td colspan='3' class='noBG'></td>
                        </tr>                                              
                      </table>

                  </form>

              </article>
              <article class="article100">
                 <div id="divPanelRight">
                    <?php 
                       echo getAddConsoleGameList();
                    ?>
                  </article>
              </div>
        </section>
        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>