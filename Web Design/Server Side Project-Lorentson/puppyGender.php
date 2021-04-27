<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Find Puppy by Gender</title>
      <script type="text/javascript" src="js/functions.js"></script> 
      <?php include('include/head.php'); ?>
      <?php include('include/data.php'); ?>
  </head>
  <body>
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
                    <a href="puppyGender.php"class="active">List Puppies By Gender</a>
                    <a href="puppyBreed.php">List Puppies By Breed</a>
                    <a href="puppyAll.php">List All Puppies</a>
                    <a href="tricks.php">List Puppy Tricks</a>
                  </div>
                  <div class="column">
                    <header>Maintain Puppies</header>
                    <a href="puppyInsert.php">Insert Puppy</a>
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
              <article class="article100">
                  <form name="frmQuery" action="puppyGender.php" method="post">
                    <div class="title">List Puppies by Gender</div><br/>
                    <div class="center30">
                            Select Gender:
                            <input type="radio" id="male" name="gender" value="M">
                            <label for="male">Male </label>
                            <input type="radio" id="female" name="gender" value="F">
                            <label for="female">Female </label>&nbsp;&nbsp;&nbsp;
                            <input class="button" type="submit" name="Submit" value="Submit" />
                    </div>
  
                  </form>
              </article>
              <br />
              <article class="article50">
                  <?php 
                      if (isset($_POST["Submit"]) && !empty($_POST["gender"]))
                      {
                          $puppyGender = $_POST['gender'];
                          $dataTable = "";
                          echo getDataGender($puppyGender);
                      }
                    ?>
              </article>
              <article class="article50">
                 <div id="divPanelRight" style="visibility:hidden;">
                    <div class="title">Puppy Details <span id="puppyName"></span></div>
                    <table>
                          <tr>
                            <td class="label" colspan="2">Description</td>
                            <td class="label">Photo</td>
                          </tr>
                          <tr>
                            <td id="desc" colspan="2" class="data"></td>
                            <td class="label" rowspan="7"> 
                                <img id="puppyPhoto" class="imageSize" src="" alt="Puppy Photo" />
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Gender:</td>
                            <td id="gender" class="data"></td>
                          </tr>
                          <tr>
                            <td class="label">Breed:</td>
                            <td id="breed" class="data"></td>
                          </tr>
                          <tr>
                            <td class="label"> Color:</td>
                            <td id="color" class="data"></td>
                          </tr>
                          <tr>
                            <td class="label"> BirthDate:</td>
                            <td id="birthdate" class="data"></td>
                          </tr>                    
                    </table>
                  </article>
              </div>
        </section>

        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>