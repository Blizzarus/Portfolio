<?php      
    function getRecord($parm1)
    {
        // Perform Database Query
        include('admin/database.php');
        $dbConnection = db_connect();
        $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, 
          Color, BirthDate, Photo, Fee from labdb_bcl.puppy where Puppy_Number = " . $parm1 . ";";
        //echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();
        $stat->store_result();
        $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $Gender, $Breed, 
          $Color, $BirthDate, $Photo, $Fee) ;
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


        // Use Returned Data (if any)

        $Data = "";
        $Data = $Data . "<table>";
        while($stat->fetch()) 
        {
          $dateTimeObj = date_create($BirthDate);
          
          if ($Photo == "" or $Photo == null)
          {
            if ($Gender == "M")
            {
              $Photo = "nophoto.png";
              $PupGender = "Male";
            }
            elseif ($Gender == "F")
            {
              $Photo = "nophoto.png";
              $PupGender = "Female";
            }
          }
          else
            {
              if ($Gender == "M")
              {
                $PupGender = "Male";
              }
              elseif ($Gender == "F")
              {
                $PupGender = "Female";
              }
            }

          $Data = $Data . 
                "<tr><td class='label'>Puppy Number:</td><td>" . $Puppy_Number . "</td>" . 
                "<td rowspan='9' class='center'><img id='puppy' class='puppyImg' src='images/" . $Photo . "' alt='Puppy Photo' /></td></tr>" .
                "<tr><td class='label'>Puppy Name:</td><td>" . $Puppy_Name . "</td></tr>" .
                "<tr><td class='label'>Description:</td><td>" . $Description . "</td></tr>" .
                "<tr><td class='label'>Gender:</td><td>" . $PupGender . "</td></tr>" .
                "<tr><td class='label'>Breed:</td><td>" . $Breed . "</td></tr>" .
                "<tr><td class='label'>Color:</td><td>" . $Color . "</td></tr>" .
                "<tr><td class='label'>Birth Date:</td><td>" . date_format($dateTimeObj, 'm-d-Y') . "</td></tr>" .
                "<tr><td class='label'>Photo:</td><td>" . $Photo . "</td></tr>" .
                "<tr><td class='label'>Fee:</td><td>$" . $Fee . "</td></tr>";
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


      function getBreedPuppies($parm1)
      {
          // Perform Database Query
        //  include('admin/database.php');
          $dbConnection = db_connect();
          $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, 
          Color, BirthDate, Photo, Fee from labdb_bcl.puppy where Breed = '" . $parm1 . "';";
          //echo $query;
          $stat = $dbConnection->prepare($query);
          $stat->execute();
          $stat->store_result();
          $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $Gender, $Breed, 
          $Color, $BirthDate, $Photo, $Fee) ;
         // echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


  
          // Use Returned Data (if any)
          $Data = "";
         // echo "t=" . $Team_ID;
          $Data = $Data = "<div class='title'>" . $Breed . " Puppy List</div>";
          $Data = $Data . "<table style='width:100%;'>";
          $Data = $Data . "<tr><td class='label'>Action</td><td class='label'>Puppy Name</td><td class='label'>Fee</td></tr>";
          while($stat->fetch()) 
          {
            $dateTimeObj = date_create($BirthDate);
            if ($Photo == "" or $Photo == null)
            {
                $Photo = "nophoto.png";
            }

            $Data = $Data . 
                "<tr>" .
                    "<td><a href='#' onclick='showData(" . $Puppy_Number . ")'> Select</a></td>" .
                    "<td>" . $Puppy_Name . "<button class='hideData' id='" . $Puppy_Number . "name' value='" . $Puppy_Name. "'></button></td>" .
                    "<td>" . $Fee . "<button class='hideData' id='" . $Puppy_Number. "fee' value='" . $Fee. "'></button></td>" .
                    "<td class='hideData'><textarea id='" .  $Puppy_Number . "desc'>" . $Description . "</textarea></td>" .
                    "<td class='hideData'><button id='" .   $Puppy_Number . "gender' value='" . $Gender . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number. "breed' value='" . $Breed . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number . "photo' value='" . $Photo . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number. "color' value='" . $Color . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number . "birthDate' value='" . date_format($dateTimeObj, 'm-d-Y')  . "'/></td></tr>";
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


      function getDistinctBreeds()
      {
          // Perform Database Query
          include('admin/database.php');
          $dbConnection = db_connect();
          $query = "Select distinct puppy.Breed from labdb_bcl.puppy;";
          //echo $query;
          $stat = $dbConnection->prepare($query);
          $stat->execute();
          $stat->store_result();
          $stat->bind_result($Breed);      
  
          $Data = "<select id='lbBreed' name='lbBreed' class='dropdown'>";
          while($stat->fetch()) 
          {
              $Data = $Data . "<option label='" . $Breed . "' value='" . $Breed . "'>" . $Breed . "</option>";
          }
          $Data = $Data . "</select>";
          
          // Release returned data
          $stat->free_result();
  
          //Close Database Connectiom
          db_disconnect($dbConnection);
          //echo "DB - Closed";

          return $Data;
      }

      function getDataGender($parm1)
      {
          // Perform Database Query
          include('admin/database.php');
          $dbConnection = db_connect();
          $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, 
          Color, BirthDate, Photo, Fee from labdb_bcl.puppy where Gender = '" . $parm1 . "';";
        //echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();
        $stat->store_result();
        $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $Gender, $Breed, 
          $Color, $BirthDate, $Photo, $Fee) ;
        //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
          if ($_POST['gender'] == "M")
          {
            $GenderName = "Male";
          }
          else if ($_POST['gender'] == "F")
          {
            $GenderName = "Female";
          }

          // Use Returned Data (if any)
          $Data = "";
          $Data = $Data = "<div class='title'>" . $GenderName . " Puppy List</div>";
          $Data = $Data . "<table style='width:100%;'>";
          $Data = $Data . "<tr><td class='label'>Action</td><td class='label'>Puppy Name</td><td class='label'>Fee</td></tr>";
          
          
          while($stat->fetch()) 
          {
            $dateTimeObj = date_create($BirthDate);
            if ($Photo == "" or $Photo == null)
            {
              if ($Gender == "M")
              {
                $Photo = "nophoto.png";
               // $Gender = "M";
              }
              else if ($Gender == "F")
              {
                $Photo = "nophoto.png";
                //$Gender = "Fe";
              }
            }
            $Data = $Data . 
                "<tr>" .
                    "<td><a href='#' onclick='showData(" . $Puppy_Number . ")'> Select</a></td>" .
                    "<td>" . $Puppy_Name . "<button class='hideData' id='" . $Puppy_Number . "name' value='" . $Puppy_Name. "'></button></td>" .
                    "<td>" . $Fee . "<button class='hideData' id='" . $Puppy_Number. "fee' value='" . $Fee. "'></button></td>" .
                    "<td class='hideData'><textarea id='" .  $Puppy_Number . "desc'>" . $Description . "</textarea></td>" .
                    "<td class='hideData'><button id='" .   $Puppy_Number . "gender' value='" . $Gender . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number. "breed' value='" . $Breed . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number . "photo' value='" . $Photo . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number. "color' value='" . $Color . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number . "birthDate' value='" . date_format($dateTimeObj, 'm-d-Y')  . "'/></td></tr>";
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


        function getDataAll()
      {
          // Perform Database Query
          include('admin/database.php');
          $dbConnection = db_connect();
          $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, 
          Color, BirthDate, Photo, Fee from labdb_bcl.puppy;";
        //echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();
        $stat->store_result();
        $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $Gender, $Breed, 
          $Color, $BirthDate, $Photo, $Fee) ;
        //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";

          // Use Returned Data (if any)
          $Data = "";
          $Data = $Data = "<div class='title'>All Puppies</div>";
          $Data = $Data . "<table style='width:100%;'>";
          $Data = $Data . "<tr><td class='label'>Action</td><td class='label'>Puppy Name</td><td class='label'>Fee</td></tr>";
          
          
          while($stat->fetch()) 
          {
            $dateTimeObj = date_create($BirthDate);
            if ($Photo == "" or $Photo == null)
            {
              $Photo = "nophoto.png";
            }
            $Data = $Data . 
                "<tr>" .
                    "<td><a href='#' onclick='showData(" . $Puppy_Number . ")'> Select</a></td>" .
                    "<td>" . $Puppy_Name . "<button class='hideData' id='" . $Puppy_Number . "name' value='" . $Puppy_Name. "'></button></td>" .
                    "<td>" . $Fee . "<button class='hideData' id='" . $Puppy_Number. "fee' value='" . $Fee. "'></button></td>" .
                    "<td class='hideData'><textarea id='" .  $Puppy_Number . "desc'>" . $Description . "</textarea></td>" .
                    "<td class='hideData'><button id='" .   $Puppy_Number . "gender' value='" . $Gender . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number. "breed' value='" . $Breed . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number . "photo' value='" . $Photo . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number. "color' value='" . $Color . "'/></td>" .
                    "<td class='hideData'><button id='" .  $Puppy_Number . "birthDate' value='" . date_format($dateTimeObj, 'm-d-Y')  . "'/></td></tr>";
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






        function getTricks()
        {
            // Perform Database Query
            include('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Trick_ID, Trick_Name, Difficulty from labdb_bcl.trick;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Trick_ID, $Trick_Name, $Difficulty);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Tricks</div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Trick ID</td>" . 
                "<td class='label'>Trick Name</td>" .   
                "<td class='label'>Difficulty</td>" .  
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td>" . $Trick_ID . "</td>" .
                        "<td>" . $Trick_Name . "</td>" .
                        "<td>" . $Difficulty . "</td>" .
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

        function getKennels()
        {
            // Perform Database Query
            include('admin/database.php');
            $dbConnection = db_connect();
            $query = "Select Kennel_Code, Kennel_Name, Street, City, State, Zipcode, Phone, Website from labdb_bcl.kennels;";
            //  echo $query;
            $stat = $dbConnection->prepare($query);
            $stat->execute();
            $stat->store_result();
            $stat->bind_result($Kennel_Code, $Kennel_Name, $Street, $City, $State, $Zipcode, $Phone, $Website);
            //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";
    
    
            // Use Returned Data (if any)
            $Data = "";
            $Data = $Data = "<div class='title'>Kennels</div>";
            $Data = $Data . "<table style='width:100%;'>";
            $Data = $Data . "<tr><td class='label'>Kennel Code</td>" . 
                "<td class='label'>Kennel Name</td>" .   
                "<td class='label'>Street</td>" .  
                "<td class='label'>City</td>" .  
                "<td class='label'>State</td>" .  
                "<td class='label'>Zip Code</td>" .  
                "<td class='label'>Phone</td>" .  
                "<td class='label'>Website</td>" .  
                "</tr>";
            
            
            while($stat->fetch()) 
            {
                $Data = $Data . 
                    "<tr>" .
                        "<td>" . $Kennel_Code . "</td>" .
                        "<td>" . $Kennel_Name . "</td>" .
                        "<td>" . $Street . "</td>" .
                        "<td>" . $City . "</td>" .
                        "<td>" . $State . "</td>" .
                        "<td>" . $Zipcode . "</td>" .
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

















         // ---- Lab 6 ------
  function getPuppyRecord($parm1)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, 
      Color, BirthDate, Photo, Fee from labdb_bcl.puppy where Puppy_Number = " . $parm1 . ";";
      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $pupGender, $Breed, 
      $Color, $BirthDate, $Photo, $Fee) ;
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)

      $Data = "";
      while($stat->fetch()) 
      {
        $dateTimeObj = date_create($BirthDate);
        
        if ($Photo == "" or $Photo == null)
        {
          if ($pupGender == "M")
          {
            $Photo = "nophoto.png";
            $Gender = "Male";
          }
          else if ($pupGender == "F")
          {
            $Photo = "nophoto.png";
            $Gender = "Female";
          }
          $Data = $Data . "<div class='title'>Delete Puppy - " . $Puppy_Name . "</div><table>";
        }

        $Data = $Data . 
              "<tr><td colspan='2' class='label'>Description:</td><td class='label'>Photo:</td></tr>" . 
              "<tr><td colspan='2'>" . $Description . "</td>" . 
                "<td rowspan='5' class='center'><img id='puppy' src='images/" . $Photo . "' alt='Puppy Photo' /></td></tr>" .
              "<tr><td class='label'>Gender:</td><td>" . $Gender . "</td></tr>" .
              "<tr><td class='label'>Breed:</td><td>" . $Breed. "</td></tr>" .
              "<tr><td class='label'>Color:</td><td>" . $Color . "</td></tr>" .
              "<tr><td class='label'>Birth Date:</td><td>" . date_format($dateTimeObj, 'm-d-Y') . "</td></tr>" .
              "<tr></tr>" .
              "<tr> <td>&nbsp;</td>" .
              "<td><input class='formFont' type='submit' name='" . $Puppy_Number . "', id='Delete' value='Delete'></td>" .
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




  function loadKennelListBox()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Kennel_Code, Kennel_Name from labdb_bcl.kennels;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Kennel_Code, $Kennel_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<select class='formFont' id='lbKennels' name='lbKennels'><option id='' value='' ></option>";
        
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<option id='". $Kennel_Code . "' value='" . $Kennel_Code . "'>" . $Kennel_Name . "</option>";
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


  function getPuppyList()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Puppy_Number, Puppy_Name, Gender, BirthDate, Fee from labdb_bcl.puppy order by Timestamp desc LIMIT 10;";
      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Puppy_Number, $Puppy_Name, $Gender, $BirthDate, $Fee);
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";



      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data = "<div class='title'>Puppy List </div>";
      $Data = $Data . "<table style='width:100%;>";
      $Data = $Data . "<tr>" .
              "<td class='label'></td>" . 
              "<td class='label'>Puppy ID</td>" . 
              "<td class='label'>Puppy Name</td>" . 
              "<td class='label'>Gender</td>" . 
              "<td class='label'>BirthDate</td>" . 
              "<td class='label'>Fee</td>" . 
              
              "</tr>";
      
      
      while($stat->fetch()) 
      {
          $dateTimeObj = date_create($BirthDate);
          // echo $Description;
          $Data = $Data . 
              "<tr>" .
                  "<td>" . $Puppy_Number . "</td>" .
                  "<td>" . $Puppy_Name . "</td>" .
                  "<td>" . $Gender . "</td>" .
                  "<td>" . date_format($dateTimeObj, 'm-d-Y') . "</td>" .
                  "<td>" . $Fee . "</td>" .
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

  function addPuppy($puppyName, $puppyDescription, $puppyGender, $puppyBreed, $puppyColor, $puppyBirthDate, $puppyFee, $puppyPhoto, $lbKennels)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Insert into labdb_bcl.puppy (Puppy_Name, Description, Gender, Breed, Color, BirthDate, Fee, Photo, Kennel_Code) " . 
        "values (" .
        "'" . $puppyName. "', " . 
        "'" . $puppyDescription . "', " . 
        "'" . $puppyGender . "', " . 
        "'" . $puppyBreed . "', " . 
        "'" . $puppyColor . "', " . 
        "STR_TO_DATE('" . $puppyBirthDate . "','%Y-%m-%d'), " .
        "'" . $puppyFee. "', " . 
        "'" . $puppyPhoto. "', " . 
        $lbKennels . ");";
       // echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();

        $rowsAffected = mysqli_affected_rows($dbConnection);
       // echo $rowsAffected;
        if ($rowsAffected == 1)
        {
          $message =  $puppyName . " added successfully";
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

  function getPuppyDeleteList()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, Color, BirthDate, Photo, Fee from labdb_bcl.puppy order by Puppy_Number;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $Gender, $Breed, $Color, $BirthDate, $Photo, $Fee);
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data = "<div class='title'>Select Puppy to Delete</div>";
      $Data = $Data . "<table style='width:100%;'>";
      $Data = $Data . "<tr><td class='label'>Action</td><td class='label'>Puppy #</td><td class='label'>Puppy Name</td><td class='label'>Fee</td></tr>";
      
      
      while($stat->fetch()) 
      {
          $dateTimeObj = date_create($BirthDate);
          if($Photo == null || $Photo = "")
          {
            $Photo = "nophoto.png";
          }
          
         // echo ("P=" . $Player_Photo);
          // echo $Description;
          $Data = $Data . 
              "<tr>" .
                  "<td style='width:15%;'><input class='formFont' type='submit' name='" . $Puppy_Number . "', id='Select' value='Select'></td>" .
                  "<td style='width:15%;'>" . $Puppy_Number . "</td>" .
                  "<td style='width:15%;'>" . $Puppy_Name . "</td>" .
                  "<td>" . "$" . $Fee . "</td>" .
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



  function deletePuppy($puppyNumber)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Delete from labdb_bcl.puppy where Puppy_Number = " . $puppyNumber . ";";

      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();

      $rowsAffected = mysqli_affected_rows($dbConnection);
      if ($rowsAffected == 1)
      {
         $error = "Puppy Number:" . $puppyNumber . " deleted successfully";
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

  function getTrickDeleteRecord($parm1)
  {
      // Perform Database Query
      include('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select puppy_tricks.Puppy_Number, puppy_tricks.Trick_ID, puppy_tricks.Skill_level, puppy.Puppy_Name, trick.Trick_Name, puppy_tricks.Trick_School
      from labdb_bcl.puppy_tricks, labdb_bcl.puppy, labdb_bcl.trick
      where puppy_tricks.Trick_ID = trick.Trick_ID and puppy_tricks.Puppy_Number = puppy.Puppy_Number and puppy_tricks.Puppy_Number = " . $parm1 . ";";
      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Puppy_Number, $Trick_ID, $Skill_Level, $Puppy_Name, $Trick_Name, $Trick_School);
    //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)

      $Data = "";
      $Data = $Data = "<div class='title'>Select Puppy Trick to Delete</div>";
      $Data = $Data . "<table style='width:100%;'>";
      $Data = $Data . "<tr><td class='label'>Action</td><td class='label'>Puppy #</td><td class='label'>Puppy Name</td><td class='label'>Trick ID</td><td class='label'>Trick Name</td><td class='label'>Trick School</td><td class='label'>Skill Level</td></tr>";
      
      
      while($stat->fetch()) 
      {

          $Data = $Data . 
              "<tr>" .
                  "<td style='width:15%;'><input class='formFont' type='submit' name='" . $Puppy_Number . "-" . $Trick_ID . "', id='Delete' value='Delete'></td>" .
                  "<td style='width:15%;'>" . $Puppy_Number . "</td>" .
                  "<td style='width:15%;'>" . $Puppy_Name . "</td>" .
                  "<td style='width:15%;'>" . $Trick_ID . "</td>" .
                  "<td style='width:15%;'>" . $Trick_Name . "</td>" .
                  "<td style='width:15%;'>" . $Trick_School . "</td>" .
                  "<td>" . $Skill_Level . "</td>" .
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

  function deletePuppyTrick($puppyNumber, $Trick_ID)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Delete from labdb_bcl.puppy_tricks where Puppy_Number = " . $puppyNumber . " AND Trick_ID = " . $Trick_ID . ";";

      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();

      $rowsAffected = mysqli_affected_rows($dbConnection);
      if ($rowsAffected == 1)
      {
         $error = "Puppy Trick ID: " . $Trick_ID . " deleted successfully";
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

  function getPuppyAddTrickList()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select puppy_tricks.Puppy_Number, puppy_tricks.Trick_ID, puppy_tricks.Skill_level, puppy.Puppy_Name, trick.Trick_Name, puppy_tricks.Trick_School
      from labdb_bcl.puppy_tricks, labdb_bcl.puppy, labdb_bcl.trick
      where puppy_tricks.Trick_ID = trick.Trick_ID and puppy_tricks.Puppy_Number = puppy.Puppy_Number
      order by puppy_tricks.Timestamp desc LIMIT 10;";
      //echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Puppy_Number, $Trick_ID, $Skill_Level, $Puppy_Name, $Trick_Name, $Trick_School);
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";



      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data = "<div class='title'>Puppy Tricks List</div>";
      $Data = $Data . "<table style='width:100%;>";
      $Data = $Data . "<tr>" .
              "<td class='label'></td>" . 
              "<td class='label'>Puppy Name</td>" . 
              "<td class='label'>Trick Name</td>" . 
              "<td class='label'>Trick School</td>" . 
              "<td class='label'>Skill Level</td>" . 
              "</tr>";
      
      
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<tr>" .
                  "<td>" . $Puppy_Name . "</td>" .
                  "<td>" . $Trick_Name . "</td>" .
                  "<td>" . $Trick_School . "</td>" .
                  "<td>" . $Skill_Level . "</td>" .
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

  function loadPuppyListBox()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Puppy_Number, Puppy_Name from labdb_bcl.puppy order by Puppy_Name;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Puppy_Number, $Puppy_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<select class='formFont' id='lbPuppies' name='lbPuppies'><option id='' value='' ></option>";
        
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<option id='". $Puppy_Number . "' value='" . $Puppy_Number . "'>" . $Puppy_Number . " - " . $Puppy_Name . "</option>";
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

  function loadTrickListBox()
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Trick_ID, Trick_Name from labdb_bcl.trick;";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Trick_ID, $Trick_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<select class='formFont' id='lbTricks' name='lbTricks'><option id='' value='' ></option>";
        
      while($stat->fetch()) 
      {
          $Data = $Data . 
              "<option id='". $Trick_ID . "' value='" . $Trick_ID . "'>" . $Trick_Name . "</option>";
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

  function addPuppyTrick($lbPuppies, $lbTricks, $trickSchool, $lbSkills)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Insert into labdb_bcl.puppy_tricks (Puppy_Number, Trick_ID, Trick_School, Skill_Level) " . 
        "values (" .
        "'" . $lbPuppies. "', " . 
        "'" . $lbTricks . "', " . 
        "'" . $trickSchool . "', " . 
        $lbSkills . ");";
       // echo $query;
        $stat = $dbConnection->prepare($query);
        $stat->execute();

        $rowsAffected = mysqli_affected_rows($dbConnection);
       // echo $rowsAffected;
        if ($rowsAffected == 1)
        {
          $message =  "Trick ID: " . $lbTricks . " added successfully";
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

  function getUpdatePuppy($puppyNumber)
  {
      // Perform Database Query
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Puppy_Number, Puppy_Name, Description, Gender, Breed, Color, BirthDate, Photo, Fee, Kennel_Code from labdb_bcl.puppy where Puppy_Number = " . $puppyNumber . ";";
      // echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      
      $stat->bind_result($Puppy_Number, $Puppy_Name, $Description, $Gender, $Breed, $Color, $BirthDate, $Photo, $Fee, $lbKennels );
      //  echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
      $Data = $Data . "<table style='border:1px solid black;'>";
      if ($stat->fetch()) 
      {
        $KennelsList = loadKennelListBox();
        $kennelName = getKennelName($lbKennels);
        $dateTimeObj = date_create($BirthDate);
        if($Photo == null || $Photo == "")
          {
            $Photo = "nophoto.png";
          }

        $Data = $Data .
        "<tr>" . 
            "<td class='label'>Puppy Number:</td>" . 
            "<td><input class='formFont' type='text' id='puppyNumber' name='puppyNumber' value='" . $Puppy_Number . "'></td>" . 
            "<td rowspan='9' class='center'><img id='puppy' class='puppyImg' src='images/" . $Photo . "' alt='Puppy Photo' /></td></tr>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Puppy Name:</td>" . 
            "<td><input class='formFont' type='text' id='puppyName' name='puppyName' value='" . $Puppy_Name . "'></td>" . 
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Description:</td>" . 
            "<td><textarea class='formFont' id='description' name='description' rows=2 cols=50>" . $Description . "</textarea></td>" . 
        "</tr>" .
        "<tr>" . 
          "<td class='label'>Gender:</td>" . "<td>" .
              "<input style='display:none;' type='text' id='cGender' name='cGender' value='" . $Gender . "'>" . 
              "<input type='radio' id='male' name='puppyGender' value='Male'>" . 
              "<label for='male'>Male </label> " . 
              "<input type='radio' id='female' name='puppyGender' value='Female'>" .
              "<label for='female'>Female </label> Current Gender: " 
              . $Gender . "</td>" . 
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Breed:</td>" . 
            "<td><input class='formFont' type='text' id='breed' name='breed' value='" . $Breed . "'></td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Color:</td>" . 
            "<td><input class='formFont' type='text' id='color' name='color' value='" . $Color . "'></td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>BirthDate:</td>" . 
            "<input style='display:none;' type='text' id='cDate' name='cDate' value='" . date_format($dateTimeObj, 'Y-m-d') . "'>" .
            "<td><input class='formFont' type='date' id='birthdate' name='birthdate' value='" . date_format($dateTimeObj, 'm-d-Y') . "'> Current Date: " . date_format($dateTimeObj, 'm-d-Y') . "</td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Photo:</td>" . 
            "<td><input class='formFont' type='file' name='f' value='' /> Current: " . $Photo . "</td>" .
            "<td><input style='display:none;' type='text' id='cPhoto' name='cPhoto' value='" . $Photo . "'/></td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Fee:</td>" . 
            "<td>$<input class='formFont' type='text' id='fee' name='fee' value='" . $Fee . "'></td>" .
        "</tr>" .
        "<tr>" . 
            "<td class='label'>Kennel:</td>" . 
            "<td><input style='display:none;' type='text' id='cKennel' name='cKennel' value='" . $lbKennels . "'> Current: " . $kennelName . "<br />" .
            $KennelsList . "</td>" .
        "</tr>" .
        "<tr><td>&nbsp;</td><td><input class='formFont' type='submit' id='Update' name='Update' value='Update'/></td></tr>";
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

    function getKennelName($lbKennels)
    {
      require_once('admin/database.php');
      $dbConnection = db_connect();
      $query = "Select Kennel_Code, Kennel_Name from labdb_bcl.kennels WHERE kennels.Kennel_Code = " . $lbKennels . ";";
      //  echo $query;
      $stat = $dbConnection->prepare($query);
      $stat->execute();
      $stat->store_result();
      $stat->bind_result($Kennel_Code, $Kennel_Name );
      //echo "<p>Number of rows found: " . $stat->num_rows . "</p>";


      // Use Returned Data (if any)
      $Data = "";
        
      while($stat->fetch()) 
      {
          $Data = $Kennel_Name;
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



    function updatePuppy($puppyNumber, $puppyName, $description, $gender, $breed, $color, $birthdate, $fee, $puppyPhoto, $lbKennels)
    {
        // Perform Database Query
        require_once('admin/database.php');
        $dbConnection = db_connect();
        $query = "Update labdb_bcl.puppy set " . 
            "Puppy_Name = '" . $puppyName . "', " .
            "Description = '" . $description . "', " . 
            "Gender = '" . $gender . "', " . 
            "Breed = '" . $breed . "', " . 
            "Color = '" . $color . "', " . 
            "BirthDate = STR_TO_DATE('" . $birthdate . "','%Y-%m-%d'), " .
            "Fee = '" . $fee . "', " .
            "Photo = '" . $puppyPhoto . "', " .
            "Kennel_Code = " . $lbKennels .
            " WHERE Puppy_Number = " . $puppyNumber . ";";

        //echo $query;
         $stat = $dbConnection->prepare($query);
         $stat->execute();

        $rowsAffected = mysqli_affected_rows($dbConnection);
       // echo "Rows affected " . $rowsAffected;

        if ($rowsAffected == 1)
        {
           $message =  $puppyName . " updated successfully";
        }
        else if ($rowsAffected == 0)
        {
          $message =  $puppyName . " No changes found - update successfull";
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
              $message .= '<label class="text-danger">Photo file is too large.</label><br />';
            }
          }
          else
          {
              $message .= '<label class="text-danger">Error uploading photo file.</label><br />';
          }

      }
      else
      {
          $message .= '<label class="text-danger">Invalid photo file type.</label><br />';
      }

      return $message;
    }

?>