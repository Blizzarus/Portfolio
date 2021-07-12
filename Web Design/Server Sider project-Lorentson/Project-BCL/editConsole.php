<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Edit Console</title>
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body class='backgroundImage'>
  <?php 
        $error = "";
        $consoleNumber = "";
        $consoleName = "";
        $description = "";
        $releaseDate = "";
        $price = "";
        $filename = "";
        $companyCode = "";


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


        if(isset($_POST["Update"]))
        {

            $consoleNumber = $_POST["consoleNumber"];
            $consoleName = $_POST["consoleName"];
            $description = $_POST["description"];
            $releaseDate = $_POST["releaseDate"];
            $price = $_POST["price"];
            $companyCode = $_POST["lbCompanies"];
            

            if(empty($_POST["consoleNumber"]))
            {
                $error .= '<br/><label class="text-danger">Console Number is required.</label><br />';
            }
            else
            {
                $consoleNumber = clean_text($_POST["consoleNumber"]);
            }
          
            if(empty($_POST["consoleName"]))
            {
                $error .= '<br/><label class="text-danger">Console Name is required.</label><br />';
            }
            else
            {
                $consoleName = clean_text($_POST["consoleName"]);
            }

            if(empty($_POST["description"]))
            {
                $error .= '<br/><label class="text-danger">Description is required.</label><br />';
            }
            else
            {
                $description = clean_text($_POST["description"]);
            }


            if(empty($_POST["releaseDate"]))
            {
                $releaseDate = clean_text($_POST["cDate"]);
            }
            else
            {
                $releaseDate = clean_text($_POST["releaseDate"]);
            }

            if(empty($_POST["price"]))
            {
                $error .= '<label class="text-danger">Price is required.</label><br />';
            }
            else
            {
                $price = clean_text($_POST["price"]);
            }

            if(empty($_POST["lbCompanies"]))
            {
                $companyCode = clean_text($_POST["cCompany"]);
            }
            else
            {
                $companyCode = clean_text($_POST["lbCompanies"]);
            }

            if($error == "")
            {

                $f = $_FILES['f'];
                $filename = $_FILES['f']['name'];
                if (!empty($filename))
                {
                    $message = uploadFile($f);
                    if ($message == "" || $message == null)
                    {
                        $error = updateConsole($consoleNumber, $consoleName, $description, $releaseDate, $price, $filename, $companyCode);
                    }
                    else
                    {
                        $error = "Entry failed to update.";
                    }
                }
                else
                {
                    $filename = $_POST["cLogo"];
                    $error = updateConsole($consoleNumber, $consoleName, $description, $releaseDate, $price, $filename, $companyCode);
    
                }
            }
            
        }

    ?>


<main>
        <header>
            <h1>Admin Page - Update Game Console Entries.</h1>
            <h3>Proceed with caution; the entry will be changed permanently!</h3>
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
              <header class="title">Update Console Data</header>
              <article>
                  <form name="frmQuery" action="editConsole.php" method="post" enctype="multipart/form-data">
                        <?php echo $error; ?>
                            <table>
                                <tr>
                                    <td class="label">Enter a Console ID #:</td>
                                    <td>
                                        <input class="textbox" type="text" name="txtConsoleNumber"  />
                                    </td>
                                    <td>  
                                        <input class="button" type="submit" name="Find" value="Find Console" />
                                    </td>
                                </tr>
                            </table>
                        
                        <p></p>
                        <?php 
                            if (isset($_POST["Find"]) && !empty($_POST["txtConsoleNumber"]))
                            {
                                $consoleNumber = $_POST['txtConsoleNumber'];
                                $dataTable = "";
                                echo getUpdateConsole($consoleNumber);
                                //echo $error;
                            } 
                        ?>
                  </form>
              </article>
        </section>
        
        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>