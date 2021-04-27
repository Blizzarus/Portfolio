<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Edit Puppy</title>
      <script type="text/javascript" src="js/functions.js"></script> 
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body>
  <?php 
        $error = "";
        $puppyNumber = "";
        $puppyName = "";
        $description = "";
        $gender = "";
        $breed = "";
        $color = "";
        $birthdate = "";
        $fee = "";
        $filename = "";
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


        if(isset($_POST["Update"]))
        {

            $puppyNumber = $_POST["puppyNumber"];
            $puppyName = $_POST["puppyName"];
            $description = $_POST["description"];
            $breed = $_POST["breed"];
            $color = $_POST["color"];
            $birthdate = $_POST["birthdate"];
            $fee = $_POST["fee"];
            $kennelCode = $_POST["lbKennels"];
            

            if(empty($_POST["puppyNumber"]))
            {
                $error .= '<br/><label class="text-danger">Puppy Number is required.</label><br />';
            }
            else
            {
                $puppyNumber = clean_text($_POST["puppyNumber"]);
            }
          
            if(empty($_POST["puppyName"]))
            {
                $error .= '<br/><label class="text-danger">Puppy Name is required.</label><br />';
            }
            else
            {
                $puppyName = clean_text($_POST["puppyName"]);
            }

            if(empty($_POST["description"]))
            {
                $error .= '<br/><label class="text-danger">Description is required.</label><br />';
            }
            else
            {
                $description = clean_text($_POST["description"]);
            }

            if(empty($_POST["puppyGender"]))
            {
                $gender = $_POST["cGender"];
                if ($gender == "Male")
                {
                  $gender = 'M';
                }
                elseif ($gender == "Female")
                {
                  $gender = 'F';
                }
            }
            else
            {
                $gender = $_POST["puppyGender"];
                if ($gender == "Male")
                {
                  $gender = 'M';
                }
                elseif ($gender == "Female")
                {
                  $gender = 'F';
                }
            }

            if(empty($_POST["breed"]))
            {
                $error .= '<label class="text-danger">Breed is required.</label><br />';
            }
            else
            {
                $breed = clean_text($_POST["breed"]);
            }

            if(empty($_POST["color"]))
            {
                $error .= '<label class="text-danger">Color is required.</label><br />';
            }
            else
            {
                $color = clean_text($_POST["color"]);
            }

            if(empty($_POST["birthdate"]))
            {
                $birthdate = clean_text($_POST["cDate"]);
            }
            else
            {
                $birthdate = clean_text($_POST["birthdate"]);
            }

            if(empty($_POST["fee"]))
            {
                $error .= '<label class="text-danger">Fee is required.</label><br />';
            }
            else
            {
                $fee = clean_text($_POST["fee"]);
            }

            if(empty($_POST["lbKennels"]))
            {
                $kennelCode = clean_text($_POST["cKennel"]);
            }
            else
            {
                $kennelCode = clean_text($_POST["lbKennels"]);
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
                        $error = updatePuppy($puppyNumber, $puppyName, $description, $gender, $breed, $color, $birthdate, $fee, $filename, $kennelCode);
                    }
                    else
                    {
                        $error = "Record not updated.";
                    }
                }
                else
                {
                    $filename = $_POST["cPhoto"];
                    $error = updatePuppy($puppyNumber, $puppyName, $description, $gender, $breed, $color, $birthdate, $fee, $filename, $kennelCode);
    
                }
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
                    <a href="puppyInsert.php">Insert Puppy</a>
                    <a href="puppyEdit.php"class="active">Edit Puppy</a>
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
              <header class="title">Update Puppy Data</header>
              <article>
                  <form name="frmQuery" action="puppyEdit.php" method="post" enctype="multipart/form-data">
                        <?php echo $error; ?>
                            <table>
                                <tr>
                                    <td class="label">Enter Puppy Number:</td>
                                    <td>
                                        <input class="textbox" type="text" name="txtPuppyNumber"  />
                                    </td>
                                    <td>  
                                        <input class="button" type="submit" name="Find" value="Find Puppy" />
                                    </td>
                                </tr>
                            </table>
                        
                        <p></p>
                        <?php 
                            if (isset($_POST["Find"]) && !empty($_POST["txtPuppyNumber"]))
                            {
                                $puppyNumber = $_POST['txtPuppyNumber'];
                                $dataTable = "";
                                echo getUpdatePuppy($puppyNumber);
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