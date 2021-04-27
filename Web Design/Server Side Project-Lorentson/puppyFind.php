<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Find Puppy by Number</title>
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
                    <a href="puppyFind.php"class="active">Find Puppy By Puppy Number</a>
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
              <header class="title">Find Puppy By Puppy Number</header>
              <article>
                  <form name="frmQuery" action="puppyFind.php" method="post">
                    <table>
                        <tr>
                            <td class="label">Enter Puppy Number:</td>
                            <td>
                                <input class="textbox" type="text" name="txtPuppyNumber" />
                            </td>
                            <td>  
                                <input class="button" type="submit" name="Find" value="Find Puppy" />
                            </td>
                        </tr>
                    </table>
                  </form>
                  <p></p>
                  <?php 
                      if (isset($_POST["Find"]) && !empty($_POST["txtPuppyNumber"]))
                      {
                          $puppyNumber = $_POST['txtPuppyNumber'];
                          $dataTable = "";
                          echo getRecord($puppyNumber);
                      }
                    ?>
              </article>
        </section>

        <?php include('include/footer.php'); ?>
    </main>
  </body>
</html>