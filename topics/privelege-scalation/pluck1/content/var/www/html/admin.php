<?php
include("header.php");

echo "<br><br><br>";
if ($_POST){
echo '
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

<div class="alert alert-danger" role="alert">';
 
if(strpos($_POST['email'], '\'') !== false) {
	echo  "<strong>You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''' at line 1</strong>";
}else{
	echo  "<strong>Incorrect Username or Password!</strong>";
}
?>
</div>
</div>
</div>
</div>
<?php
}
?>
<br>
<div class="container">
    <div class="row vertical-offset-100">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Admin</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" action="admin.php" method="post">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="E-mail" name="email" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<div class="checkbox">
			    	    </div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>

<?php
include("footer.php");
?>
