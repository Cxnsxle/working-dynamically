<?php
include("header.php");
#echo "<br>";

if ($_GET){
	#include($_GET['page'].".php");
	echo "<br><br><br><br>
 	<div class=jumbotron>";
	include($_GET['page']);
	echo "</div>";
}else {

?>

<br><br><br><br>
 <div class="jumbotron">
        <h1>Learn to Create Websites</h1>
        <p>In today's world internet is the most popular way of connecting with the people. At <a href="http://www.tutorialrepublic.com" target="_blank">tutorialrepublic.com</a> you will learn the essential of web development technologies along with real life practice example, so that you can create your own website to connect with the people around the world.</p>
        <p><a href="http://www.tutorialrepublic.com" target="_blank" class="btn btn-success btn-lg">Get started today</a></p>
    </div>

<div class="jumbotron">
        <h1>Learn to Create Websites</h1>
        <p>In today's world internet is the most popular way of connecting with the people. At <a href="http://www.tutorialrepublic.com" target="_blank">tutorialrepublic.com</a> you will learn the essential of web development technologies along with real life practice example, so that you can create your own website to connect with the people around the world.</p>
        <p><a href="http://www.tutorialrepublic.com" target="_blank" class="btn btn-success btn-lg">Get started today</a></p>
    </div>


<?php
}
#include("/etc/passwd");
echo "<br>";
include("footer.php");

?>
