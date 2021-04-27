<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Add Puppy</title>
      <script src="//code.jquery.com/jquery-2.2.3.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript" src="js/functions.js"></script> 
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body>
    <?php 
        $error = "";
        $puppyName = "";
        $puppyDescription = "";
        $puppyGender = "";
        $puppyBreed = "";
        $puppyColor = "";
        $puppyBirthDate = "";
        $puppyFee = "";
        $puppyPhoto = "";
        $kennelCode = "";

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
                    $error .= '<label class="text-danger">Photo file is too large.</label><br />';
                  }
                }
                else
                {
                    $error .= '<label class="text-danger">Error uploading photo file.</label><br />';
                }

            }
            else
            {
                $error .= '<label class="text-danger">Invalid photo file type.</label><br />';
            }









          if(empty($_POST["puppyName"]))
          {
              $error .= '<br/><label class="text-danger">Puppy Name is required.</label><br />';
          }
          else
          {
              $pName = clean_text($_POST["puppyName"]);
              if(!preg_match("/^[a-zA-Z ]*$/",$puppyName))
              {
                  $error .= '<label class="text-danger">Only letters and white space allowed in Name.</label><br />';
              }
          }

          if(empty($_POST["puppyDescription"]))
          {
              $error .= '<label class="text-danger">Description is required.</label><br />';
          }
          else
          {
              $puppyDescription = clean_text($_POST["puppyDescription"]);
          }

          if(empty($_POST["puppyGender"]))
          {
              $error .= '<label class="text-danger">Gender is required.</label><br />';
          }
          else
          {
              $puppyGender = clean_text($_POST["puppyGender"]);
          }

          if(empty($_POST["puppyBreed"]))
          {
              $error .= '<label class="text-danger">Breed is required.</label><br />';
          }
          else
          {
              $puppyBreed = clean_text($_POST["puppyBreed"]);
          }

          if(empty($_POST["puppyColor"]))
          {
              $error .= '<label class="text-danger">Color is required.</label><br />';
          }
          else
          {
              $puppyColor = clean_text($_POST["puppyColor"]);
          }

          if(empty($_POST["puppyBirthDate"]))
          {
              $error .= '<label class="text-danger">Birth Date is required.</label><br />';
          }
          else
          {
              $puppyBirthDate = clean_text($_POST["puppyBirthDate"]);
          }

          if(empty($_POST["puppyFee"]))
          {
              $error .= '<label class="text-danger">Fee is required.</label><br />';
          }
          else
          {
              $puppyFee = clean_text($_POST["puppyFee"]);
          }

          if(empty($_POST["lbKennels"]))
          {
              $error .= '<label class="text-danger">Kennel Code is required.</label></br>';
          }
          else
          {
              $kennelCode = clean_text($_POST["lbKennels"]);
          }



          if($error == "")
          {
              $puppyName = $_POST["puppyName"];
              $puppyDescription = $_POST["puppyDescription"];
              $puppyGender = $_POST["puppyGender"];
              $puppyBreed = $_POST["puppyBreed"];
              $puppyColor = $_POST["puppyColor"];
              $puppyBirthDate = $_POST["puppyBirthDate"];
              $puppyFee = $_POST["puppyFee"];
              $puppyPhoto = $_FILES['f']['name'];
              $kennelCode = $_POST["lbKennels"];
              //echo "Code=" . $_POST["lbKennels"];

            $error = addPuppy($puppyName, $puppyDescription, $puppyGender, $puppyBreed, $puppyColor, $puppyBirthDate, $puppyFee, $puppyPhoto, $kennelCode);
            // $error = "<label class='text-success'>" . $pName . " has been added.</label>";
            $puppyName = "";
            $puppyDescription = "";
            $puppyGender = "";
            $puppyBreed = "";
            $puppyColor = "";
            $puppyBirthDate = "";
            $puppyFee = "";
            $puppyPhoto = "";
            $kennelCode = "";
          }
            
        }
    ?>
    <main>
        <header>
            <h1>CIS-237 - Lab 7 - Uploading Files</h1>
            <h3>Benjamin Lorentson</h3>
        </header>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <div class="dropdown">
              <button class="dropbtn">Puppies
                <i class="fa fa-caret-down"></i>
              </button>
              <div class="dropdown-content">
                <div class="header">
                  <div>Puppy Information</div>
                </div>   
                <div class="row">
                  <div class="column">
                    <header>View Puppies</header>
                    <a href="puppyFind.php">Find Puppy By Puppy Number</a>
                    <a href="puppyGender.php">List Puppies By Gender</a>
                    <a href="puppyBreed.php">List Puppies By Breed</a>
                    <a href="puppyAll.php">List All Puppies</a>
                    <a href="tricks.php">List Puppy Tricks</a>
                  </div>
                  <div class="column">
                    <header>Maintain Puppies</header>
                    <a href="puppyInsert.php"class="active">Insert Puppy</a>
                    <a href="puppyEdit.php">Edit Puppy</a>
                    <a href="puppyDelete.php">Delete Puppy</a>
                    <a href="puppyAddTrick.php">Add Puppy Trick</a>
                    <a href="puppyDeleteTrick.php">Delete Puppy Trick</a>
                  </div>
                  <div class="column">

                  </div>
                  <div class="column">

                  </div>
                </div>
              </div>
            </div> 
            <a href="kennels.php">Kennels</a>
            <a href="tricks.php">Tricks</a>
        </nav>
        <section>
              <article class="article50">
                  <form id="formInsert" action="puppyInsert.php" method="post" enctype="multipart/form-data">
                      <?php echo $error; ?>
                      <div class='title'>Add Puppy Information</div>
                      <table class="table100">
                        <tr>
                            <td>*Puppy Name:</td>
                            <td>
                              <input class="formFont" type="text" name="puppyName" value="<?php echo $puppyName; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>*Description:</td>
                            <td>
                              <textarea rows="3" cols="50" class="formFont" type="text" name="puppyDescription" value="<?php echo $puppyDescription; ?>"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>*Gender:</td>
                            <td>
                                <input class="formFont" type="radio" id="male" name="puppyGender" value="M">
                                <label for="male">Male </label>
                                <input class="formFont" type="radio" id="female" name="puppyGender" value="F">
                                <label for="female">Female </label>
                            </td>
                        </tr>
                        <tr>
                            <td>*Breed:</td>
                            <td>
                              <input class="formFont" type="text" name="puppyBreed" value="<?php echo $puppyBreed; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>*Color:</td>
                            <td>
                              <input class="formFont" type="text" name="puppyColor" value="<?php echo $puppyColor; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>*BirthDate:</td>
                            <td>
                              <input class="formFont" type="date"  name="puppyBirthDate" value="<?php echo $puppyBirthDate; ?>" />
                            </td>
                        </tr>  
                        <tr>
                            <td>*Fee:</td>
                            <td>
                              <input class="formFont" type="text" name="puppyFee" value="<?php echo $puppyFee; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>*Photo:</td>
                            <td>
                                <input type="file" name="f" value="<?php echo $puppyPhoto; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>*Kennel:</td>
                            <td>
                                <?php
                                    $KennelsList = loadKennelListBox();
                                    echo $KennelsList;
                                    //echo $error;
                                ?>        
                            </td>
                        </tr>   
                        <tr>
                            <td colspan="2">* = Required field</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
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
                       echo getPuppyList();
                    ?>
                  </article>
              </div>
        </section>

        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>