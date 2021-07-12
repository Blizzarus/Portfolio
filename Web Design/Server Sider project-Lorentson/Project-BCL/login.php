<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Login</title>
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body class='backgroundImage'>
      <?php
          $error = "";
          $userName = "";
          $userPass = "";
          $txtLoginID = "";
          $txtPassword = "";
          $status = 0;


          function clean_text($string)
          {
              $string = trim($string);
              $string = stripslashes($string);
              $string = htmlspecialchars($string);
            // echo "SB=" . $string;
              $string =  htmlspecialchars($string, ENT_QUOTES);
            // echo "SA=" . $string;
              return $string;
          }

          if(isset($_POST["reset"]))
          {
              $error=""; 
          }

          if(isset($_POST["Login"]))
          {
              
              //echo "CB=" . $_POST["cbRemember"];

              if(empty($_POST["txtLoginID"]))
              {
                  $error .= '<br/><label class="text-danger">Login User Name Required.</label><br />';
              }
              else
              {
                  $txtLoginID = clean_text($_POST["txtLoginID"]);
              }

              if(empty($_POST["txtPassword"]))
              {
                  $error .= '<br/><label class="text-danger">Password is Required.</label><br />';
              }
              else
              {
                $txtPassword = $_POST["txtPassword"];
              }

              if($error == "")
              {
                  $userName = $txtLoginID;
                  $userPass = $txtPassword;
                  $error = userLogin($userName,$userPass);

                  if ($error == "" || $error == null)
                  {
                    $error = "Invalid User Name or password.";
                  }
                  else
                  {
                    $status = 1;  //logged in
                    $_SESSION['userStatus'] = 1;
                    $_SESSION['userName'] = $error;

                    if (isset($_POST["cbRemember"]))
                    {
                        if ($_POST["cbRemember"] == "1")
                        {
                            //echo "1";
                            $cookie_name = "userName";
                            $cookie_value = $userName;
                            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
                           // $_POST["txtLoginID"] = get_Cookie($cookie_name);
                        }
                    }
                    else
                    {
                        
                        setcookie("userName", null, time() - 36000, "/");  //delete cookie
                       // echo "Delete cookie";
                    }
                    
                    //echo "S=" . $_SESSION['userStatus'];
                  }
              }
        }
        ?>       
    <main>
        <header>
            <h1>Login Portal</h1>
            <h3>Please enter your username and password below to login...</h3>
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
            <article class="article33">&nbsp;</article>
            <article class="article33">
                <div id="divLogin" name="divLogin" > 
                    <form id="formLogin" name="formLogin" action="login.php" method="post" class="formFont">
                        <table>
                            <tr>
                                <td style="width:150px;" class="textbox">Username:</td>
                                <td class="textbox">
                                    <input class="formFont" type="data" id="txtLoginID" name="txtLoginID" value="<?php if(isset($_COOKIE["userName"])){ echo get_Cookie("userName"); }?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="textbox">Password:</td>
                                <td class="textbox">
                                    <input class="formFont" type="password" id="txtPassword" name="txtPassword" />
                                </td>
                            </tr>
                            <tr>
                                <td class="textbox">Remember Me:</td>
                                <td class="textbox">
                                    <input class="formFont" type="checkbox" id="cbRemember" name="cbRemember"  value="1" />
                                </td>
                            </tr>
                            <tr>
                                <td class='noBG'>&nbsp;</td>
                                <td class="textbox">
                                    <input class="formFont" type="submit" id="Login" name="Login"  value="Login" />
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="textbox">
                                    <div id="divMessage" name="divMessage">
                                            <?php
                                                echo $error;
                                            ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </article>
            <article class="article33">&nbsp;</article>
        </section>
        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>