window.fbAsyncInit = function() {
	FB.init({
		appId : '126120344478319',
		cookie : true, // enable cookies to allow the server to access the session
		xfbml : true, // parse social plugins on this page
		version : 'v2.5' // use graph api version 2.5
	});

	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});	
};

//Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
		return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function statusChangeCallback(response) {
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		testAPI();
	} else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		$.ajax({
			url : b + 'index.php/welcome/logout',
			success : function(response) {}
		});
	} else {
		$.ajax({
			url : b + 'index.php/welcome/logout',
			success : function(response) {}
		});
	}
}

function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
	if(l == 1){
		FB.logout(function(response){});	
		window.location.href=b;
	}
	else{
		FB.api('/me?fields=id,email,name', function(response) {
			window.location.href=b + 'index.php/welcome/signedin?name=' + response.name + '&email=' + response.email;
		});
	}
}