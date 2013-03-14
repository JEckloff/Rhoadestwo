<?php

	require_once('../inc/config.php');
	
	
	//catch user selection from dropdown and sanitze
	$tmp = $_GET['p'];
	if($tmp === 'home' || $tmp === 'about' || $tmp === 'contact')
	{
		$page = $tmp;	
	}
	else
	{
		$page = 'home';
	}
		
  //get all content related to this page (home)
  $sql = "SELECT * 
  FROM site_content 
  WHERE page_name='$page'";

  $myData = $db->query($sql);
  
  //create container for each piece of data
  while($row = $myData->fetch_assoc())
  {
	if($row['section_name'] === 'blurb')
	{
		$blurb = $row['content'];
	}
	
	if($row['section_name'] === 'intro')
	{
		$intro = $row['content'];
	}
	  
  }
  
  if(isset($_POST['submitted']))
  {
	  $user_blurb = mysqli_real_escape_string($db, $_POST['body']);
	  $user_intro = mysqli_real_escape_string($db, $_POST['intro']);
	  $page = mysqli_real_escape_string($db, $_POST['tmp']);
	  

	  $sql1 = "UPDATE site_content
	  SET content='$user_blurb'
	  WHERE page_name='$page'
	  AND section_name='blurb'";

	  $myData = $db->query($sql1);


	  $sql2 = "UPDATE site_content
	  SET content='$user_intro'
	  WHERE page_name='$page'
	  AND section_name='intro'";

	  $myData = $db->query($sql2);

	  mysqli_close($db);
	  
	 header('Location: ../');
  }
  
  
?>





<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Update Page</title>
<style>
	legend, select, label, textarea, input {display:block;}
</style>
</head>

<body>
<h1>Update Page</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<fieldset>
    <legend>Update Page Info</legend>
    <input type="hidden" id="tmp" name="tmp" value="<?php echo $page ?>" />
    <select id="page" onchange="set_page(this)">
    	<option value="">Choose a page to edit</option>
    	<option value="home" id="home">home</option>
        <option value="about" id="about">about</option>
        <option value="contact" id="contact">contact</option>
    </select>
    
    <?php

    if ($intro) {
    	echo'<label for="intro">intro</label>' .
    	'<textarea name="intro" rows="10" cols="30">' . $intro . '</textarea>';
    }
    
    if($blurb){
    	echo '<label for="body">body</label>' . 
    	'<textarea name="body" rows="10" cols="30">' . $blurb . '</textarea>';
	}
	
    ?>
    <input type="submit" name="submitted" value="update now" />
    </fieldset>
</form>

<script>
	window.onload = function(){
		document.getElementById("<?php echo $page; ?>").selected = 'selected';
	};
	
	function set_page(obj)
	{
		window.location = './update.php?p='+ obj.value;
	}
</script>
</body>
</html>
