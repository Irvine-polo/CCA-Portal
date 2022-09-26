var validNumber = [
	"0",
	"1",
	"2",
	"3",
	"4",
	"5",
	"6",
	"7",
	"8",
	"9",
	"ArrowLeft",
	"ArrowRight",
	"Backspace",
	"Tab",
	"Enter",
];

let numbersOnly = document.querySelectorAll("input[data-type='number']");

for (let i = 0; i < numbersOnly.length; i++) {
	if (numbersOnly.length != 0) {
		numbersOnly[i].onkeydown = (e) => {
			if (!(e.ctrlKey && e.key == "a")) {
				if (!(validNumber.includes(e.key))) {
					e.preventDefault();
				}
			}		
		}
	}
}

var validDecimal = [
	"-",
	"0",
	"1",
	"2",
	"3",
	"4",
	"5",
	"6",
	"7",
	"8",
	"9",
	".",
	"ArrowLeft",
	"ArrowRight",
	"Backspace",
	"Tab",
	"Enter",
];

let decimalsOnly = document.querySelectorAll("input[data-type='decimal']");

for (let i = 0; i < numbersOnly.length; i++) {
	if (decimalsOnly.length != 0) {
		decimalsOnly[i].onkeydown = (e) => {
			if (!(e.ctrlKey && e.key == "a")) {
				if (!(validDecimal.includes(e.key))) {
					e.preventDefault();
				}
			}
		}
	}
}

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
})

var url = new URL(window.location.href);
var error = url.searchParams.get("error");
var success = url.searchParams.get("success");
var session = url.searchParams.get("session");
var fbclid = url.searchParams.get("fbclid");


if (error !== null) {
	Swal.fire(
		'Error!',
		error + '.',
		'error'
	).then(function() {
	   window.location.replace(removeUrlParameter(url, "error"));
	});
}

if (success !== null) {
	Swal.fire(
		'Success!',
		success + '.',
		'success'
	).then(function() {
	   window.location.replace(removeUrlParameter(url, "success"));
	});
}

if (session !== null) {
	Swal.fire(
		'Session Expired!',
		session + '.',
		'error'
	).then(function() {
	   window.location.replace(url.toString().split('?')[0]);
	});
}

if (fbclid !== null) {
    window.location.replace(url.toString().split('?')[0]);
}

function removeUrlParameter(url, parameter) {
  var urlParts = url.toString().split('?');

  if (urlParts.length >= 2) {
    var urlBase = urlParts.shift();

    var queryString = urlParts.join('?');

    var prefix = encodeURIComponent(parameter) + '=';
    var parts = queryString.split(/[&;]/g);

    for (var i = parts.length; i-- > 0; ) {
      if (parts[i].lastIndexOf(prefix, 0) !== -1) {
        parts.splice(i, 1);
      }
    }

    url = urlBase + '?' + parts.join('&');
  }

  return url;
}