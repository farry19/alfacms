<!DOCTYPE html>
<html>
<head>
	<title>Installation</title>
	<link href="/admin/css/bootstrap.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="card" style="margin-top: 10px;">
		  <div class="card-body">
		  	<form method="POST" action="index.php?page=install/seeding">
			    <h5 class="card-title">Installation - Step 2</h5>
			    <p class="card-text">
			    	<p>All <code>database tables</code> are migrated successfully.</p>
			    	<h6>Web Application Information</h6>
			    	<p>Please fill in required information.</p>
			    </p>    
			    <div class="form-group">
    				<label>Application Name</label>
    				<input type="text" class="form-control" name="app_name" placeholder="i.e. MyFirstApp">
  				</div>
  				<div class="form-group">
    				<label>Application Type <code>(You will not be able to change this later on)</code></label>
    				<div class="form-check">
						<input class="form-check-input position-static" type="radio" name="app_type" value="blog" > Blog
					</div>
					<div class="form-check">
						<input class="form-check-input position-static" type="radio" name="app_type" value="ecom" > E-Commerce
					</div>
					<div class="form-check">
						<input class="form-check-input position-static" type="radio" name="app_type" value="stat" checked> Static
					</div>
  				</div>
  				<div class="form-group">
    				<label>Application Url <code>(Needs to be changed according to enviroment)</code></label>
    				<input type="text" class="form-control" name="app_url" placeholder="i.e. http://localhost/myfirstapp">
  				</div>
  				<div class="form-group">
    				<label>Application Theme <code>(Can be changed later or installed)</code></label>
    				<select name="app_theme" class="form-control">
    					
    					<!-- Default theme -->
    					<option value="/themes/default">Default</option>
    					
    					<!-- Loading theme model -->
    					<?php 
    					$themes = resolve('\\Models\\Theme')::all();
    					 ?>

    					<!-- Populating avaiable/active themes -->
    					<?php if($themes){ ?>
	    					<?php foreach($themes as $theme){ ?>
	    						<?php if($theme->status == 'active'){ ?>
		    						<option value="<?php echo $theme->path; ?>"> <?php echo $theme->name; ?> </option>
	    						<?php } ?>
	    					<?php } ?>
    					<?php } ?>

    				</select>
  				</div>
			    <button class="btn btn-primary float-right" type="submit">Next</button>
		    </form>
		</div>
	</div>
</body>
</html>
