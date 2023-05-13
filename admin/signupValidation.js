const validateEmail = () => {
	var email = document.getElementById("email").value;
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if (!email.match(mailformat)) {
		return true;
	}
	return false;
};

const validateName = () => {
	var name = document.getElementById("name").value.length;
	if (name < 8) {
		return true;
	}
	return false;
};
const validatePass = () => {
	var pass = document.getElementById("pass").value;
	var passFormat = /[a-zA-z0-0][@#!$$%^&?]$/;
	if (!pass.match(passFormat)) {
		return true;
	}
	return false;
};

const validateconfPass = () => {
	var confPass = document.getElementById("confPass").value;
	var pass = document.getElementById("pass").value;
	if (!confPass.match(pass)) {
		return true;
	}
	return false;
};

const check = () => {
	if (validateEmail()) {
		alert("Please Enter a valid Email Address !!");
		return false;
	} else if (validateName()) {
		alert("College Name should be more than 8 characters !!");
		return false;
	} else if (validatePass()) {
		alert("Enter a valid password !!");
		return false;
	} else if (validateconfPass()) {
		alert("Confirm password and Password does not match!!");
		return false;
	}
	return true;
};
