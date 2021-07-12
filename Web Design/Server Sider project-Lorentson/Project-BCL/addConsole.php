<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Add Console</title>
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body class='backgroundImage'>
    <?php 
        $error = "";
        $consoleName = "";
        $consoleDescription = "";
        $consoleReleaseDate = "";
        $consolePrice = "";
        $consoleLogo = "";
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

        if(isset($_POST["Insert"]))
        {


            $f = $_FILES['f'];
            $filename = $_FILES['f']['name'];
            $fileTmpName = $_FILES['f']['tmp_name'];
            $fileSize = $_FILES['f']['size'];
            $fileError = $_FILES['f']['error'];
            $fileType = $_FILES['f']['type'];
            $fileExt = explode('.', $filename);
            $fileActualExt = strtolower(end($fileExt)); //get lowercase file extension
            //allowable file types to be uploaded store in a array
            $allowed = array('jpg', 'jpeg', 'png', 'pdf' );

            if (in_array($fileActualExt, $allowed))
            {
                if ($fileError === 0)
                {
                  if ($fileSize < 100000000)
                  {
                      $m = "images/" . $_FILES['f']['name'];
                  		// use move_uploaded_file function
                  		move_uploaded_file($_FILES['f']['tmp_name'], $m);  //error is here
                  }
                  else
                  {
                    $error .= '<label class="text-danger">Logo file is too large.</label><br />';
                  }
                }
                else
                {
                    $error .= '<label class="text-danger">Error uploading Logo file.</label><br />';
                }

            }
            else
            {
                $error .= '<label class="text-danger">Invalid Logo file type.</label><br />';
            }









          if(empty($_POST["consoleName"]))
          {
              $error .= '<br/><label class="text-danger">Console Name is required.</label><br />';
          }
          else
          {
              $consoleName = clean_text($_POST["consoleName"]);
          }

          if(empty($_POST["consoleDescription"]))
          {
              $error .= '<label class="text-danger">Description is required.</label><br />';
          }
          else
          {
              $consoleDescription = clean_text($_POST["consoleDescription"]);
          }

          if(empty($_POST["consoleReleaseDate"]))
          {
              $error .= '<label class="text-danger">Release Date is required.</label><br />';
          }
          else
          {
              $consoleReleaseDate = clean_text($_POST["consoleReleaseDate"]);
          }

          if(empty($_POST["consolePrice"]))
          {
              $error .= '<label class="text-danger">Price is required.</label><br />';
          }
          else
          {
              $consolePrice = clean_text($_POST["consolePrice"]);
          }

          if(empty($_POST["lbCompanies"]))
          {
              $error .= '<label class="text-danger">Company is required.</label></br>';
          }
          else
          {
              $companyCode = clean_text($_POST["lbCompanies"]);
          }



          if($error == "")
          {
              $consoleName = $_POST["consoleName"];
              $consoleDescription = $_POST["consoleDescription"];
              $consoleReleaseDate = $_POST["consoleReleaseDate"];
              $consolePrice = $_POST["consolePrice"];
              $consoleLogo = $_FILES['f']['name'];
              $companyCode = $_POST["lbCompanies"];
              //echo "Code=" . $_POST["lbKennels"];

            $error = addConsole($consoleName, $consoleDescription, $consoleReleaseDate, $consolePrice, $consoleLogo, $companyCode);
            // $error = "<label class='text-success'>" . $pName . " has been added.</label>";
            $consoleName = "";
            $consoleDescription = "";
            $consoleReleaseDate = "";
            $consolePrice = "";
            $consoleLogo = "";
            $companyCode = "";
          }
            
        }
    ?>
    <main>
        <header>
            <h1>Admin Page - Add New Game Consoles.</h1>
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
              <article class="article50">
                  <form id="formInsert" action="addConsole.php" method="post" enctype="multipart/form-data">
                      <?php echo $error; ?>
                      <div class='title'>Add New Console Data</div>
                      <table class="table100">
                        <tr>
                            <td>*Console Name:</td>
                            <td>
                              <input class="formFont" type="text" name="consoleName" value="<?php echo $consoleName; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>*Description:</td>
                            <td>
                              <textarea rows="3" cols="50" class="formFont" type="text" name="consoleDescription" value="<?php echo $consoleDescription; ?>"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>*Release Date:</td>
                            <td>
                              <input class="formFont" type="date"  name="consoleReleaseDate" value="<?php echo $consoleReleaseDate; ?>" />
                            </td>
                        </tr>  
                        <tr>
                            <td>*List Price:</td>
                            <td>
                              $<input class="formFont" type="text" name="consolePrice" value="<?php echo $consolePrice; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>*Logo Image File:</td>
                            <td>
                                <input type="file" name="f" value="<?php echo $consoleLogo; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>*Developing Company:</td>
                            <td>
                                <?php
                                    $CompaniesList = loadCompanyListBox();
                                    echo $CompaniesList;
                                    //echo $error;
                                ?>        
                            </td>
                        </tr>   
                        <tr>
                            <td class='noBG' colspan="2">&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td class='noBG'>* = Required field</td>
                            <td class='noBG'>
                                <input class="formFont" type="Submit" name="Insert" value="Insert">
                                <input class="formFont" type="Submit" name="Reset" value="Cancel">
                            </td>
                        </tr>                                              
                      </table>

                  </form>

              </article>
              <article class="article50">
                 <div id="divPanelRight">
                    <?php 
                       echo getConsoleAddList();
                    ?>
                  </article>
              </div>
        </section>

        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>