<?php

// * IMPORTANT * Set your email information here
define('DESTINATION_EMAIL','joeeckloff@yahoo.com');
define('MESSAGE_SUBJECT','form Demo');
define('REPLY_TO', 'joeeckloff@yahoo.com');
define('FROM_ADDRESS', 'joeeckloff@yahoo.com');
define('REDIRECT_URL', 'index.php');

require_once('inc/config.php');
require_once('inc/validation.php');

//get all content related to this page
  $sql = "SELECT * FROM site_content WHERE page_name='contact'";
  $myData = $db->query($sql);
  
  //create container for each piece of data
  while($row = $myData->fetch_assoc())
  {
	if($row['section_name'] === 'intro')
	{
		$intro = $row['content'];
	}
	elseif($row['section_name'] === 'blurb')
	{
		$blurb = $row['content'];
	}
	  
  }

mysqli_close($db);

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Palma Rhoades - Contact</title>
<link href="newsgothic/stylesheet.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css"><!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body id="contact_page">

<div class="container">
  
  <?php include_once('inc/header.php'); ?>
    
    <?php require_once('inc/nav.php'); ?>
    
  <article class="content">
    <h1>Contact</h1>
    <section>
     <h2>Want more info?</h2>
      <p><?php echo $intro; ?></p>
    </section>
    <section>
		<div class="errors">
		<ul>
			<?php 
			echo '<li>' . @$name_error . '</li>'; 
			echo '<li>' . @$email_error . '</li>'; 
			echo '<li>' . @$message_error . '</li>'; 
			?>
		</ul>
		</div>
		
      	<form id="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<fieldset>
				<legend><h2>Contact Us</h2></legend>
				<ul>
				<li><label for="name">Name:</label>
				<input type="text" name="name" placeholder="type name here" 
				class="required" value="<?php echo @$name; ?>" />
				<br class="clearfloat"></li>
				
				<li><label for="email">Email:</label>
				<input type="text" name="email" placeholder="type email here" 
				class="required email" value="<?php echo @$email; ?>" />
				<br class="clearfloat"></li>
				
				<li><label for="message">Comments:</label>
				<textarea name="message" cols="30" rows="5" 
				placeholder="type comments here"><?php echo @$message; ?></textarea>
				<br class="clearfloat"></li>
				
				<li><label>&nbsp;</label>
					<input type="submit" name="submitted" value="submit comments now »" 
					class="button large orange awesome submit" />
				<br class="clearfloat">
				</li>
				</ul>
			</fieldset>
		</form>
    </section>
   
    </section>
  </article><!-- end .content -->

  
  <?php include_once('inc/footer.php'); ?>
  
  </div><!-- end .container -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.9.0.min.js"><\/script>')</script>

<script src="js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(){
		var errors = $('.errors');
		$('#myform').validate({
			errorContainer: errors,
			errorLabelContainer: $("ul", errors),
			validClass: "success",
			wrapper: 'li',
			messages: {
				name: "Please enter your full name.",
				email:"Please enter a valid email address.",
			}
		});

	});
</script>
</body>
</html>
