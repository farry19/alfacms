<!DOCTYPE html>
<html>
<head>
	<title>Installation</title>
	<link href="<?php echo url('/admin/css/bootstrap.css'); ?>" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="card" style="margin-top: 10px;">
		  <div class="card-body">
		  	<form method="POST" action="<?php echo url('install/step-three.php'); ?>">
			    <h5 class="card-title">Installation - Step 2</h5>
			    <p class="card-text">
			    	<p>All <code>database tables</code> are migrated successfully.</p>
			    	<h6>Web Application Information</h6>
			    	<p>Please fill in required information.</p>
			    </p>    
			    <button class="btn btn-primary float-right" type="submit">Next</button>
		    </form>
		</div>
	</div>
</body>
</html>

