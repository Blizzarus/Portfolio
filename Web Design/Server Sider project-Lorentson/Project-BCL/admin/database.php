
    <?php
		//echo "<p>database</p>";
		require_once('dbCreditials.php');
		
		function db_connect()
		{
			//$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
			$dbConnection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			//echo "<p>connect: </p>" . DB_NAME;
			if (mysqli_connect_errno()) 
			{
				echo '<p>Error: Could not connect to database.<br/>
				Please try again later.</p>';
				exit;
			}
			return $dbConnection;
		}

		function db_disconnect($db)
		{
			if(isset($dbConnection))
			{
				//mysqli_close($connection);


				//Close Database Connection
				echo "<p>disconnect</p>";
				mysqli_close($dbConnection);
			}
			
		}

     ?>


