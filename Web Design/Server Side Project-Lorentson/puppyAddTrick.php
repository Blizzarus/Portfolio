<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Add Puppy Trick</title>
      <script type="text/javascript" src="js/functions.js"></script> 
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body>
  <?php 
        $error = "";
        $puppy = "";
        $trick = "";
        $trickSchool = "";
        $skillLevel = "";

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

          if(empty($_POST["trickSchool"]))
          {
              $error .= '<label class="text-danger">Trick School is required.</label><br />';
          }
          else
          {
              $trickSchool = clean_text($_POST["trickSchool"]);
          }

          if(empty($_POST["lbPuppies"]))
          {
              $error .= '<label class="text-danger">Puppy selection is required.</label></br>';
          }
          else
          {
              $puppy = clean_text($_POST["lbPuppies"]);
          }

          if(empty($_POST["lbTricks"]))
          {
              $error .= '<label class="text-danger">Trick selection is required.</label></br>';
          }
          else
          {
              $trick = clean_text($_POST["lbTricks"]);
          }

          if(empty($_POST["lbSkills"]))
          {
              $error .= '<label class="text-danger">Skill Level is required.</label></br>';
          }
          else
          {
              $skillLevel = clean_text($_POST["lbSkills"]);
          }



          if($error == "")
          {
              $puppy = $_POST["lbPuppies"];
              $trick = $_POST["lbTricks"];
              $trickSchool = $_POST["trickSchool"];
              $skillLevel = $_POST["lbSkills"];
              //echo "Code=" . $_POST["lbKennels"];

            $error = addPuppyTrick($puppy, $trick, $trickSchool, $skillLevel);
            // $error = "<label class='text-success'>" . $pName . " has been added.</label>";
            $puppy = "";
            $trick = "";
            $trickSchool = "";
            $skillLevel = "";
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
                    <a href="puppyEdit.php">Edit Puppy</a>
                    <a href="puppyDelete.php">Delete Puppy</a>
                    <a href="puppyAddTrick.php"class="active">Add Puppy Trick</a>
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
                  <form id="formInsert" action="puppyAddTrick.php" method="post">
                      <?php echo $error; ?>
                      <div class='title'>Add Puppy Trick</div>
                      <table class="table100">
                        <tr>
                            <td>*Select Puppy:</td>
                            <td>&nbsp;</td>
                            <td>*Select Trick:</td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    $PuppiesList = loadPuppyListBox();
                                    echo $PuppiesList;
                                    //echo $error;
                                ?>        
                            </td>
                            <td></td>
                            <td>
                                <?php
                                    $TricksList = loadTrickListBox();
                                    echo $TricksList;
                                    //echo $error;
                                ?>        
                            </td>
                        </tr>
                        <tr><br /></tr>
                        <tr>
                            <td>*Trick School:</td>
                            <td></td>
                            <td>Select a Skill Level:</td>
                        </tr>
                        <tr>
                          <td>
                              <input class="formFont" type="text" name="trickSchool" value="<?php echo $trickSchool; ?>" />
                          </td>
                          <td></td>
                          <td>
                              <select class='formFont' id='lbSkills' name='lbSkills'>
                                <option id='' value='' ></option>
                                <option id='1' value='1'>1</option>
                                <option id='2' value='2'>2</option>
                                <option id='3' value='3'>3</option>
                              </select>
                          </td>
                        </tr>
                        <tr><br /></tr>
                        <tr>
                            <td>
                                <input class="formFont" type="Submit" name="Add" value="Add Trick">
                                <input class="formFont" type="Submit" name="Reset" value="Cancel">
                            </td>
                        </tr>                                              
                      </table>

                  </form>

              </article>
              <article class="article50">
                 <div id="divPanelRight">
                    <?php 
                       echo getPuppyAddTrickList();
                    ?>
                  </article>
              </div>
        </section>
        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>