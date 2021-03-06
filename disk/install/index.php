<link href="url:admin/css/bootstrap.css" rel="stylesheet">
<div class="container">
<div class="card" style="margin-top: 10px;">
  <div class="card-body">
    <h5 class="card-title">Installation</h5>
    <p class="card-text">
    	This wizard will guide you though your new application setup. Please read carefully and select options accordingly.
    	<h6>Changes</h6>
    	<p>Following changes will be made to your <code>database</code>.</p>
    	<ul>
    		<li> <code>options</code> table will be created with basic web application information.</li>
    		<li> <code>users</code> table will be created with master admin user.</li>
    		<li> <code>menus</code> table will be created which will be used for application menu management.</li>
    		<li> <code>pages</code> table will be created which will contain initial welcome page data.</li>
    		<li> <code>plugins</code> table will be created which will manage plugins for your web application.</li>
    		<li> <code>forms</code> table will be created for all kind of forms management inside web application.</li>
    	</ul>
    	<p>There will be no changes made to your <code>files</code>.</p>
    </p>
    <form method="POST" action="index.php?page=install/migrations">
        <button class="btn btn-primary float-right" type="submit">Install</button>
    </form>
  </div>
</div>
</div>