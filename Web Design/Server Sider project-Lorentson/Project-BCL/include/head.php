<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="//code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="css/megamenu.css" rel=stylesheet />
<link href="css/styles.css" rel=stylesheet />

<?php
   session_cache_expire(1);  // expire session after 1 minute
   $cache_expire = session_cache_expire();
   session_start();
?>

