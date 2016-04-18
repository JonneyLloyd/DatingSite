function markValid(el) {
	markReset(el);
	el.classList.add("valid");
}

function markInvalid(el, msg) {
	markReset(el);
	el.classList.add("invalid");

	addErrorMsg(el, msg);
}

function markRequired(el) {
	markReset(el);
	el.classList.add("required");

	addErrorMsg(el, "Required")
}

function markReset(el) {
	el.classList.remove("valid");
	el.classList.remove("invalid");
	el.classList.remove("required");

	removeErrorMsg(el);
}

function addErrorMsg(el, msg) {
	//Adds the error message
	if(! el.parentNode.getElementsByClassName('error-msg').length > 0) {
	var error = document.createElement("p");
	error.className = "error-msg";
	var text = document.createTextNode(msg);
	error.appendChild(text);

	el.parentNode.appendChild(error);

	}
}

function removeErrorMsg(el) {
	//Removes the error message
	var par = el.parentNode;
	//alert(par.childNodes.length);
	if (par.childNodes[9]) {
		par.removeChild(par.childNodes[9]);//date
	}
	//else if(par.childNodes[6])
	//	par.removeChild(par.childNodes[6]);//email
}


function checkFormFirstname(el) {

	re = /^[A-Za-z-]{2,}$/;

	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid first name");

		return false;
	}

	markValid(el);
	return true;

}


function checkFormSurname(el) {

	re = /^[A-Za-z-]{2,}$/;

	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid surname");

		return false;
	}

	markValid(el);
	return true;

}


function checkFormEmail(el) {

	re = /^[A-Za-z0-9._]{1,}@[A-Za-z0-9]{1,}(\.[A-Za-z0-9]{2,})+$/;

	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid entry");

		return false;
	}

	markValid(el);
	return true;

}

function checkFormUsername(el) {
	re = /^[A-Za-z0-9._]{3,}$/;
	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid Username");

		return false;
	}

	markValid(el);
	return true;

}


function checkBio(el) {
	re = /^[A-Za-z0-9-]{2,}$/;
	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid Entry");

		return false;
	}

	markValid(el);
	return true;

}



function checkFormPassword1(el) {

	if (el.value.length < 5) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid password (password must be at least 5 characters long)");

		return false;
	}

	markValid(el);
	return true;

}


function checkFormPassword2(el) {

	if (el.value.length < 5) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid password (password must be at least 5 characters long)");

		return false;
	}

	if (el.value != document.getElementById("Password1").value) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Passwords don't match");

		return false;
	}

	markValid(el);
	return true;

}





function checkFormDate(day, month, year) {

	var yearField = document.getElementById("DOByear");

	if (day.value == 0 || month.value == 0 || year.value == 0) {
		markRequired(yearField, "Invalid date");
		return false;
	}
	var daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	if (year.value > (new Date()).getFullYear() - 18) {
        markInvalid(yearField, "Invalid value for year: " + year.value);
		return false;
	}
	if ((!(year.value % 4) && year.value % 100) || !(year.value % 400))
		daysInMonth[1] = 29;
	if (day.value > daysInMonth[month.value - 1]) {
		markInvalid(yearField, "Invalid value for day: " + day.value);
		return false;
	}
	markValid(yearField);
	return true;

}


function checkFormAge(el) {

	if (!el.checked) {
		alert('You must agree to the terms first.');
		return false;
	}

	return true;

}

function checkFormCreditCard(el){
	re = /^[0-9]{16}$/;
	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid Credit Card Number");

		return false;
	}

	markValid(el);
	return true;

}

function checkFormSecurityNum(el){
	re = /^[0-9]{3}$/;
	if (!el.value.match(re)) {
		if (el.value == "") markReset(el);
		else markInvalid(el, "Invalid Security Code");

		return false;
	}

	markValid(el);
	return true;

}

function checkCardDate(month, year) {

	//var dayField = document.getElementById("DOBday");
	var yearField = document.getElementById("year");

	if ( month.value == 0 || year.value == 0) {
		markRequired(yearField, "Invalid date");
		return false;
	}
	if (month.value < (new Date()).getMonth() && year.value <= (new Date()).getFullYear().toString().substr(2,2)) {
		markInvalid(yearField, "Invalid Expiry date");
		return false;
	}
	markValid(yearField);
	return true;

}


function checkLoginForm(form){
	var valid = true;
	if (!checkFormUsername(form.username) && !checkFormEmail(form.username)) {
		valid = false;
	}
	else
		markValid(form.username);
	if (!checkFormPassword1(form.password)) {
		valid = false;
	}
	else
		markValid(form.password);
	var fields = ["username", "password"];
	for (var i = 0; i < fields.length; i++) {
		var field = document.forms["login"][fields[i]];
		if (field.value == "") {
			markRequired(field);
			valid = false;
		}
	}

	return valid;

}


function checkForm(form) {
	var valid = true;
	if (!checkFormFirstname(form.Firstname)) {
		valid = false;
	}


	if (!checkFormSurname(form.Surname)) {
		valid = false;
	}

	if (!checkFormEmail(form.Email)) {
		valid = false;
	}
	if (!checkFormUsername(form.username)) {
		valid = false;
	}

	if (!checkFormPassword1(form.Password1)) {
		valid = false;
	}

	if (!checkFormPassword2(form.Password2)) {
		valid = false;
	}


	if (!checkFormDate(form.DOBday, form.DOBmonth, form.DOByear)) {
		valid = false;
	}

	if (!checkFormAge(form.DOBage)) {
		valid = false;
	}

	if (!checkFormCreditCard(form.ccNumber)) {
		valid = false;
	}

	if (!checkCardDate(form.month, form.year)) {
		valid = false;
	}


	if (!checkFormSecurityNum(form.security)) {
		valid = false;
	}



	//check required
	var fields = ["Firstname", "Surname", "Email", "Password1", "Password2", "username", "ccNumber", "security"];

	for (var i = 0; i < fields.length; i++) {
		var field = document.forms["Registration"][fields[i]];
		if (field.value == "") {
			markRequired(field);
			valid = false;
		}
	}

	return valid;

}
