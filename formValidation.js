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
	var error = document.createElement("p");
	error.className = "error-msg";
	var text = document.createTextNode(msg);
	error.appendChild(text);

	el.parentNode.appendChild(error);
}

function removeErrorMsg(el) {
	//Removes the error message
	var par = el.parentNode;
	if (par.childNodes[4])
		par.removeChild(par.childNodes[4]);
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
		else markInvalid(el, "Invalid e-mail");

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
	var dayField = document.getElementById("DOBday");
	var yearField = document.getElementById("DOByear");

	if (day.value == 0 || month.value == 0 || year.value == 0) {
		markRequired(dayField, "Invalid date");
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
		markInvalid(dayField, "Invalid value for day: " + day.value);
		return false;
	}

	markValid(fields);
	return true;
}


function checkFormAge(el) {

	if (!el.checked) {
		alert('You must agree to the terms first.');
		return false;
	}

	return true;

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

	//check required
	var fields = ["Firstname", "Surname", "Email", "Password1", "Password2"];

	for (var i = 0; i < fields.length; i++) {
		var field = document.forms["Registration"][fields[i]];
		if (field.value == "") {
			markRequired(field);
			valid = false;
		}
	}

	return valid;

}
