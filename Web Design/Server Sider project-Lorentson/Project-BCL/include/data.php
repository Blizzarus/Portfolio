<?php      

function userLogin($uName,$uPass)
    {
        // Perform Database Query
        require_once('admin/database.php');
        $dbConnection = db_connect();
        $query = "Select User_ID, User_Name, User_Password, First_Name, Last_Name, Role_ID from project_bcl.users where User_Name = '" . 
            $uName . "' and User_Password = '" . $uPass . "'";
        //echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();
        $stat->store_result();
        $stat->bind_result($UserID, $UserName, $UserPassword, $FirstName, $LastName, $RoleID);
        //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
        // Use Returned Data (if any)
        $Data = "";

        while($stat->fetch()) 
        {
            if ($stat->num_rows == 1)
            {
              $Data = $Data . "Logged in as <i>" . $FirstName. " " . $LastName . ".</i>";
              //echo $Data;
            }
        }

        // Release returned data
        $stat->free_result();

        //Close Database Connectiom
        db_disconnect($dbConnection);
        //echo "Closed";
        //mysqli_close($dbConnection);

        return $Data;
    }

    function Admin()
    {      
      if (isset($_SESSION['userStatus']))
      {
          if ($_SESSION['userStatus'] == 1)
          {
            $editMenu =  "" . 
            "<header>Edit Data</header>" .
            "<a href='addConsole.php'>Add New Console</a>" . 
            "<a href='editConsole.php'>Update Existing Console</a>" . 
            "<a href='deleteConsole.php'>Delete Console Data</a>" . 
            "<a href='addConsoleGame.php'>Add New Console-Game</a>" . 
            "<a href='deleteConsoleGame.php'>Delete Console-Game Data</a>";
          }
      }
      else
      {
          $editMenu =  "";
      }
      return $editMenu;
      
    }


    function get_Cookie($cookie_name)
    {
          if(!isset($_COOKIE[$cookie_name])) 
          {
              echo "Cookie named '" . $cookie_name . "' is not set!";
          } 
          else 
          {
              //echo "Cookie '" . $cookie_name . "' is set!<br>";
              //echo "Value is: " . $_COOKIE[$cookie_name];
              return $_COOKIE[$cookie_name];
          }
          
    }

    function getCompanies()
        {
            // Perform Database Query
            include('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Company_Code, Company_Name, Phone, Website from project_bcl.companies order by Company_Code;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Company_Code, $Company_Name, $Phone, $Website);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Companies</div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Company Code</td>" . 
                "<td class='label'>Company Name</td>" .    
                "<td class='label'>Phone</td>" .  
                "<td class='label'>Website</td>" .  
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td><i>" . $Company_Code . "</i></td>" .
                        "<td><i><b>" . $Company_Name . "</i></b></td>" .
                        "<td>" . $Phone . "</td>" .
                        "<td><a href='" . $Website . "' target='_blank'>" . $Website . "</a></td>" .
                    "</tr>";
                //echo $Data;
            }
            $Data = $Data . "</table><p></p>";
    
            // Release returned data - free up memory
            $stat->free_result();
    
            //Close Database Connectiom
            db_disconnect($dbConnection);
            //echo "Closed";
            //mysqli_close($dbConnection);
            return $Data;
        }

        function getGames()
        {
            // Perform Database Query
            include('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Game_ID, Game_Name, Rating from project_bcl.game order by Game_ID;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Game_ID, $Game_Name, $Rating);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Games</div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Game ID #</td>" . 
                "<td class='label'>Game Title</td>" .    
                "<td class='label'>ESRB Rating</td>" .   
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td><i>" . $Game_ID . "</i></td>" .
                        "<td><i><b>" . $Game_Name . "</i></b></td>" .
                        "<td>" . $Rating . "</td>" .
                    "</tr>";
                //echo $Data;
            }
            $Data = $Data . "</table><p></p>";
    
            // Release returned data - free up memory
            $stat->free_result();
    
            //Close Database Connectiom
            db_disconnect($dbConnection);
            //echo "Closed";
            //mysqli_close($dbConnection);
            return $Data;
        }

        function getConsoles()
      {
          // Perform Database Query
          include('admin/database.php');
          $dbConnection = db_connect();
          $query = "Select Console_Number, Console_Name, Description, ReleaseDate, Logo, Price from project_bcl.console;";
        //echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();
        $stat->store_result();
        $stat->bind_result($Console_Number, $Console_Name, $Description, $ReleaseDate, $Logo, $Price);
        //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";

          // Use Returned Data (if any)
          $Data = "";
          $Data = $Data = "<div class='title'>All Consoles</div>";
          $Data = $Data . "<table style='width:100%;'>";
          $Data = $Data . "<tr><td class='label'><i>Display</i></td><td class='label'>Console ID #</td><td class='label'>Console Name</td></tr>";
          
          
          while($stat->fetch()) 
          {
            $dateTimeObj = date_create($ReleaseDate);
            if ($Logo == "" or $Logo == null)
            {
              $Logo = "nologo.png";
            }
            $Data = $Data . 
                "<tr>" .
                    "<td><a href='#' onclick='showData(" . $Console_Number . ")'> <i>Click to Display Data</i></a></td>" .
                    "<td>" . $Console_Number . "<button class='hideData' id='" . $Console_Number . "number' value='" . $Console_Number . "'></button></td>" .
                    "<td>" . $Console_Name . "<button class='hideData' id='" . $Console_Number . "name' value='" . $Console_Name . "'></button></td>" .
                    "<td class='hideData'><textarea id='" .  $Console_Number . "desc'>" . $Description . "</textarea></td>" .
                    "<td class='hideData'><button id='" .  $Console_Number . "logo' value='" . $Logo . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Console_Number . "price' value='$" . $Price . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Console_Number . "releaseDate' value='" . date_format($dateTimeObj, 'm-d-Y')  . "'/></td></tr>";
            //echo $Data;



          }
          $Data = $Data . "</table><p></p>";
         
          // Release returned data
          $stat->free_result();

          //Close Database Connectiom
          db_disconnect($dbConnection);
          //echo "Closed";

          return $Data;

        }

        function getConsoleGames()
        {
            // Perform Database Query
            include('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Console_Name, Game_Name, Players, Capabilities from project_bcl.cg_view_bynum;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Console_Name, $Game_Name, $Players, $Capabilities);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Games by Console</div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Title</td>" . 
                "<td class='label'>Available Console</td>" .    
                "<td class='label'>Maximum Players</td>" .  
                "<td class='label'>Network Capabilities</td>" .  
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td><i><b>" . $Game_Name . "</i></b></td>" .
                        "<td><i>" . $Console_Name . "</i></td>" .
                        "<td>" . $Players . "</td>" .
                        "<td>" . $Capabilities . "</td>" .
                    "</tr>";
                //echo $Data;
            }
            $Data = $Data . "</table><p></p>";
    
            // Release returned data - free up memory
            $stat->free_result();
    
            //Close Database Connectiom
            db_disconnect($dbConnection);
            //echo "Closed";
            //mysqli_close($dbConnection);
            return $Data;
        }

        function getConsoleGamesbyTime()
        {
            // Perform Database Query
            include('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Console_Name, Game_Name, Players, Capabilities from project_bcl.cg_view_bytime order by Timestamp desc;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Console_Name, $Game_Name, $Players, $Capabilities);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Games by Console (Ordered by Most Recent Update)</div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Title</td>" . 
                "<td class='label'>Available Console</td>" .    
                "<td class='label'>Maximum Players</td>" .  
                "<td class='label'>Network Capabilities</td>" .  
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td><i><b>" . $Game_Name . "</i></b></td>" .
                        "<td><i>" . $Console_Name . "</i></td>" .
                        "<td>" . $Players . "</td>" .
                        "<td>" . $Capabilities . "</td>" .
                    "</tr>";
                //echo $Data;
            }
            $Data = $Data . "</table><p></p>";
    
            // Release returned data - free up memory
            $stat->free_result();
    
            //Close Database Connectiom
            db_disconnect($dbConnection);
            //echo "Closed";
            //mysqli_close($dbConnection);
            return $Data;
        }

  function loadCompanyListBox()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Company_Code, Company_Name from project_bcl.companies;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Company_Code, $Company_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<select class='verticalCenter' id='lbCompanies' name='lbCompanies'><option id='' value='' ></option>";
        
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<option id='". $Company_Code . "' value='" . $Company_Code . "'>" . $Company_Name . "</option>";
          //echo $Data;
      }
      $Data = $Data . "</select><p></p>";
        //echo $Data;

      // Release returned data - free up memory
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);
      return $Data;
  }

  function loadConsoleListBox()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Console_Number, Console_Name from project_bcl.console;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Console_Number, $Console_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<select class='verticalCenter' id='lbConsoles' name='lbConsoles'><option id='' value='' ></option>";
        
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<option id='". $Console_Number . "' value='" . $Console_Number . "'>" . $Console_Name . "</option>";
          //echo $Data;
      }
      $Data = $Data . "</select><p></p>";
        //echo $Data;

      // Release returned data - free up memory
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);
      return $Data;
  }

  function loadGameListBox()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Game_ID, Game_Name from project_bcl.game;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Game_ID, $Game_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<select class='verticalCenter' id='lbGames' name='lbGames'><option id='' value='' ></option>";
        
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<option id='". $Game_ID . "' value='" . $Game_ID . "'>" . $Game_Name . "</option>";
          //echo $Data;
      }
      $Data = $Data . "</select><p></p>";
        //echo $Data;

      // Release returned data - free up memory
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);
      return $Data;
  }
  

  function getConsoleAddList()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Console_Number, Console_Name, ReleaseDate, Price, Logo from project_bcl.console order by Timestamp desc LIMIT 10;";
      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Console_Number, $Console_Name, $ReleaseDate, $Price, $Logo);
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";



      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data = "<div class='title'>Recently Added Consoles...</div>";
      $Data = $Data . "<table style='width:100%;>";
      $Data = $Data . "<tr>" .
              "<td class='label'></td>" . 
              "<td class='label'>Console #</td>" . 
              "<td class='label'>Console Name</td>" . 
              "<td class='label'>Release Date</td>" . 
              "<td class='label'>Price</td>" . 
              "<td class='label'>Logo File</td>" . 
              
              "</tr>";
      
      
      while($stat->fetch()) 
      {
          $dateTimeObj = date_create($ReleaseDate);
          // echo $Description;
          if ($Logo == "" or $Logo == null)
            {
              $Logo = "nologo.png";
            }
          $Data = $Data . 
              "<tr>" .
                  "<td>" . $Console_Number . "</td>" .
                  "<td>" . $Console_Name . "</td>" .
                  "<td>" . date_format($dateTimeObj, 'm-d-Y') . "</td>" .
                  "<td>$" . $Price . "</td>" .
                  "<td>" . $Logo . "</td>" .
              "</tr>";

          //echo $Data;
      }
      $Data = $Data . "</table><p></p>";

      // Release returned data
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);

      return $Data;
  }

  function addConsole($consoleName, $consoleDescription, $consoleReleaseDate, $consolePrice, $consoleLogo, $lbCompanies)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Insert into project_bcl.console (Console_Name, Description, ReleaseDate, Price, Logo, Company_Code) " . 
        "values (" .
        "'" . $consoleName . "', " . 
        "'" . $consoleDescription . "', " . 
        "STR_TO_DATE('" . $consoleReleaseDate . "','%Y-%m-%d'), " .
        $consolePrice . ", " . 
        "'" . $consoleLogo . "', " . 
        $lbCompanies . ");";
       // echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();

        $rowsAffected = mysqli_affected_rows($dbConnection);
       // echo $rowsAffected;
        if ($rowsAffected == 1)
        {
          $message =  "Data for " . $consoleName . " was added successfully";
        }
        else
        {
          $message = "Error: " . $query . "<br>" . mysqli_error($dbConnection);
        }


      // Release returned data
     // $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      return $message;
      //echo "Closed";
      //mysqli_close($dbConnection);

  }

  function getConsoleDeleteList()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Console_Number, Console_Name, Description, ReleaseDate, Logo, Price from project_bcl.console order by Console_Number;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Console_Number, $Console_Name, $Description, $ReleaseDate, $Logo, $Price);
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data = "<div class='title'>Select Console to Delete</div>";
      $Data = $Data . "<table style='width:100%;'>";
      $Data = $Data . "<tr><td class='label'><i>Display</i></td><td class='label'>Console ID #</td><td class='label'>Console Name</td></tr>";
      
      
      while($stat->fetch()) 
      {
          $dateTimeObj = date_create($ReleaseDate);
          if($Logo == null || $Logo = "")
          {
            $Logo = "nologo.png";
          }
          
         
          $Data = $Data . 
              "<tr>" .
                  "<td style='width:33%;'><input class='formFont' type='submit' name='" . $Console_Number . "', id='Select' value='Select'></td>" .
                  "<td style='width:33%;'>" . $Console_Number . "</td>" .
                  "<td style='width:25%;'>" . $Console_Name . "</td>" .
              "</tr>";
                  
          //echo $Data;
      }
      $Data = $Data . "</table><p></p>";

      // Release returned data
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);

      return $Data;
  }

  function getConsoleRecord($consoleSelected)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Console_Number, Console_Name, Description, ReleaseDate, Logo, Price from project_bcl.console where Console_Number = " . $consoleSelected . ";";
      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Console_Number, $Console_Name, $Description, $ReleaseDate, $Logo, $Price) ;
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)

      $Data = "";
      while($stat->fetch()) 
      {
        $dateTimeObj = date_create($ReleaseDate);
        
        if ($Logo == "" or $Logo == null)
        {
          $Logo = "nologo.png";
        }

        $Data = $Data . "<div class='title'>Are you sure you want to delete <i class='text-danger'>" . $Console_Name . "</i>?</div><br><table>";
        
        $Data = $Data . 
              "<tr><td colspan='2' class='label'>Description:</td><td class='label'>Logo:</td></tr>" . 
              "<tr><td colspan='2'>" . $Description . "</td>" . 
                "<td rowspan='5' class='center'><img id='console' src='images/" . $Logo . "' alt='Console Photo' /></td></tr>" .
              "<tr><td class='label'>Release Date:</td><td>" . date_format($dateTimeObj, 'm-d-Y') . "</td></tr>" .
              "<tr><td class='label'>Price:</td><td>" . $Price . "</td></tr>" .
              "<tr></tr>" .
              "<tr> <td class='noBG'>&nbsp;</td>" .
              "<td class='noBG'><input class='formFont' type='submit' name='" . $Console_Number . "', id='Delete' value='Yes, Delete'></td>" .
            "</tr>";

        //echo $Data;
      }
      $Data = $Data . "</table><p></p>";

      // Release returned data
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";

      return $Data;
  }



  function deleteConsole($consoleNumber)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Delete from project_bcl.console where Console_Number = " . $consoleNumber . ";";

      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();

      $rowsAffected = mysqli_affected_rows($dbConnection);
      if ($rowsAffected == 1)
      {
         $error = "Console #<i>" . $consoleNumber . "</i> deleted successfully";
      }
      else
      {
        $error =  "Error: " . $query . "<br>" . mysqli_error($dbConnection);
      }

      // Release returned data
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      return $error;
      //echo "Closed";
      //mysqli_close($dbConnection);
  }

  function getUpdateConsole($consoleNumber)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Console_Number, Console_Name, Description, ReleaseDate, Logo, Price, Company_Code from project_bcl.console where Console_Number = " . $consoleNumber . ";";
      // echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      
      $stat->bind_result($Console_Number, $Console_Name, $Description, $ReleaseDate, $Logo, $Price, $lbCompanies );
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<table>";
      if ($stat->fetch()) 
      {
        $CompaniesList = loadCompanyListBox();
        $companyName = getCompanyName($lbCompanies);
        $dateTimeObj = date_create($ReleaseDate);
        if($Logo == null || $Logo == "")
          {
            $Logo = "nologo.png";
          }

        $Data = $Data .
        "<tr>" . 
            "<td class='label'>Console Number:</td>" . 
            "<td><input class='formFont' type='text' id='consoleNumber' name='consoleNumber' value='" . $Console_Number . "'></td>" . 
            "<td rowspan='7' class='center'><img id='console' class='consoleImg' src='images/" . $Logo . "' alt='Console Logo' /></td></tr>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Console Name:</td>" . 
            "<td><input class='formFont' type='text' id='consoleName' name='consoleName' value='" . $Console_Name . "'></td>" . 
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Description:</td>" . 
            "<td><textarea class='formFont' id='description' name='description' rows=2 cols=50>" . $Description . "</textarea></td>" . 
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Release Date:</td>" . 
            "<input style='display:none;' type='text' id='cDate' name='cDate' value='" . date_format($dateTimeObj, 'Y-m-d') . "'>" .
            "<td><input class='formFont' type='date' id='releaseDate' name='releaseDate' value='" . date_format($dateTimeObj, 'm-d-Y') . "'> Current Date: " . date_format($dateTimeObj, 'm-d-Y') . "</td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Logo:</td>" . 
            "<td><input class='formFont' type='file' name='f' value='' /> Current: " . $Logo . "</td>" .
            "<td><input style='display:none;' type='text' id='cLogo' name='cLogo' value='" . $Logo . "'/></td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Price: $</td>" . 
            "<td>$<input class='formFont' type='text' id='price' name='price' value='" . $Price . "'></td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Developing Company:</td>" . 
            "<td><input style='display:none;' type='text' id='cCompany' name='cCompany' value='" . $lbCompanies . "'> Current: " . $companyName . "<br />" .
            $CompaniesList . "</td>" .
        "</tr><tr><td colspan='2' class='noBG'>&nbsp;&nbsp;</td></tr>" .
        "<tr><td class='noBG'><i>All fields are required...</i></td><td class='noBG'><input class='formFont' type='submit' id='Update' name='Update' value='Update'/></td></tr>";
      }
      $Data = $Data . "</table><p></p>";


      // Release returned data - free up memory
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);
      return $Data;
    }

    function getCompanyName($lbCompanies)
    {
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Company_Code, Company_Name from project_bcl.companies WHERE companies.Company_Code = " . $lbCompanies . ";";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Company_Code, $Company_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
        
      while($stat->fetch()) 
      {
          $Data = $Company_Name;
          //echo $Data;
      }
        //echo $Data;

      // Release returned data - free up memory
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);
      return $Data;
    }



    function updateConsole($consoleNumber, $consoleName, $description, $releaseDate, $price, $consoleLogo, $lbCompanies)
    {
        // Perform Database Query
        require_once('admin/database.php');
        $dbConnection = db_connect();
        $query = "Update project_bcl.console set " . 
            "Console_Name = '" . $consoleName . "', " .
            "Description = '" . $description . "', " . 
            "ReleaseDate = STR_TO_DATE('" . $releaseDate . "','%Y-%m-%d'), " .
            "Price = " . $price . ", " .
            "Logo = '" . $consoleLogo . "', " .
            "Company_Code = " . $lbCompanies .
            " WHERE Console_Number = " . $consoleNumber . ";";

        // echo $query;
         $stat = $dbConnection->prepare($query);
         $stat->execute();

        $rowsAffected = mysqli_affected_rows($dbConnection);
       // echo "Rows affected " . $rowsAffected;

        if ($rowsAffected == 1)
        {
           $message =  $consoleName . " updated successfully";
        }
        else if ($rowsAffected == 0)
        {
          $message =  " No changes found for" . $consoleName;
        }
        else
        {
           $message =  "Error: " . $query . "<br>" . mysqli_error($dbConnection);
        }
        
        // Release returned data
        $stat->free_result();

        //Close Database Connectiom
        db_disconnect($dbConnection);
        return $message;
        //echo "Closed";
        //mysqli_close($dbConnection);
    }

    function uploadFile($file)
    {
      $f = $file;
      $message = "";
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
              $message .= '<label class="text-danger">Logo file is too large.</label><br />';
            }
          }
          else
          {
              $message .= '<label class="text-danger">Error uploading logo file.</label><br />';
          }

      }
      else
      {
          $message .= '<label class="text-danger">Invalid logo file type.</label><br />';
      }

      return $message;
    }

    function addConsoleGame($lbConsoles, $lbGames, $lbCapabilities, $players)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Insert into project_bcl.console_games (Console_Number, Game_ID, Capabilities, Players) " . 
        "values (" .
        "'" . $lbConsoles. "', " . 
        "'" . $lbGames . "', " . 
        "'" . $lbCapabilities . "', " . 
        $players . ");";
       // echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();

        $rowsAffected = mysqli_affected_rows($dbConnection);
       // echo $rowsAffected;
        if ($rowsAffected == 1)
        {
          $message =  "Console-Game Relationship Data added successfully.";
        }
        else
        {
          $message = "Error: " . $query . "<br>" . mysqli_error($dbConnection);
        }


      // Release returned data
     // $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      return $message;
      //echo "Closed";
      //mysqli_close($dbConnection);

  }

    function getAddConsoleGameList()
        {
            // Perform Database Query
            require_once('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Console_Name, Game_Name, Players, Capabilities from project_bcl.cg_view_bytime order by Timestamp desc LIMIT 10;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Console_Name, $Game_Name, $Players, $Capabilities);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Games by Console <i>(In Order of Most Recent Update)</i></div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Title</td>" . 
                "<td class='label'>Available Console</td>" .    
                "<td class='label'>Maximum Players</td>" .  
                "<td class='label'>Network Capabilities</td>" .  
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td><i><b>" . $Game_Name . "</i></b></td>" .
                        "<td><i>" . $Console_Name . "</i></td>" .
                        "<td>" . $Players . "</td>" .
                        "<td>" . $Capabilities . "</td>" .
                    "</tr>";
                //echo $Data;
            }
            $Data = $Data . "</table><p></p>";
    
            // Release returned data - free up memory
            $stat->free_result();
    
            //Close Database Connectiom
            db_disconnect($dbConnection);
            //echo "Closed";
            //mysqli_close($dbConnection);
            return $Data;
        }

  function getDeleteConsoleGameList()
  {
      // Perform Database Query
      include('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Console_Number, Game_ID, Console_Name, Game_Name, Players, Capabilities from project_bcl.cg_view_bytime order by Timestamp;";

      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Console_Number, $Game_ID, $Console_Name, $Game_Name, $Players, $Capabilities);
    //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)

      $Data = "";
      $Data = $Data = "<div class='title'>Select Entry to Delete <i>(Listed by Oldest Entry First)</i></div>";
      $Data = $Data . "<table style='width:100%;'>";
      $Data = $Data . "<tr><td class='label'>Delete Entry</td><td class='label'>Title</td><td class='label'>Available Console</td><td class='label'>Maximum Players</td><td class='label'>Network Capabilities</td></tr>";
      
      
      while($stat->fetch()) 
      {

          $Data = $Data . 
              "<tr>" .
                  "<td style='width:20%;'><input class='formFont' type='submit' name='" . $Console_Number . "-" . $Game_ID . "', id='Delete' value='Delete'></td>" .
                  "<td style='width:20%;'><i><b>" . $Game_Name . "</i></b></td>" .
                  "<td style='width:20%;'><i>" . $Console_Name . "</i></td>" .
                  "<td style='width:20%;'>" . $Players . "</td>" .
                  "<td>" . $Capabilities . "</td>" .
              "</tr>";
                  
          //echo $Data;
      }
      $Data = $Data . "</table><p></p>";

      // Release returned data
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      //echo "Closed";
      //mysqli_close($dbConnection);

      return $Data;
  }

  function deleteConsoleGame($consoleNumber, $Game_ID)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Delete from project_bcl.console_games where Console_Number = " . $consoleNumber . " AND Game_ID = " . $Game_ID . ";";

      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();

      $rowsAffected = mysqli_affected_rows($dbConnection);
      if ($rowsAffected == 1)
      {
         $error = "Entry deleted successfully.";
      }
      else
      {
        $error =  "Error: " . $query . "<br>" . mysqli_error($dbConnection);
      }

      // Release returned data
      $stat->free_result();

      //Close Database Connectiom
      db_disconnect($dbConnection);
      return $error;
      //echo "Closed";
      //mysqli_close($dbConnection);
  }

?>