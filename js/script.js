window.onscroll = function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("backToTop").style.display = "block";
    } else {
        document.getElementById("backToTop").style.display = "none";
    }
}

function showMenu() {
    var x = document.getElementById("header-topnav");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

function search() {
    var input, filter, ul, li, a;
    input = document.getElementById("movie-search-bar");
    filter = input.value.toUpperCase();
    ul = document.getElementById("movie-list");
    li = ul.getElementsByTagName("li");
    for(var i=0; i<li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if(a.textContent.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

// Validation

var input_id = {
    "username": [/^[a-zA-Z\d_]{4,50}$/, "Il nome utente non è valido."],
    "password": [/^[A-Za-z\d!@#$%^&*]{4,}$/, "La password non è valida."],
    "repeat": [/^[A-Za-z\d!@#$%^&*]{4,}$/, "La password ripetuta non è valida."],
    "new-password": [/^[A-Za-z\d!@#$%^&*]{4,}$/, "La password non è valida."],
    "old-password": [/^[A-Za-z\d!@#$%^&*]{4,}$/, "La password non è valida."],
    "code": [/^[a-zA-Z]{4}$/, "Il codice non è valido."],
    "nome": [/^[a-zA-ZÀ-ú]{1,50}$/, "Il nome non è valido."],
    "cognome": [/^[a-zA-ZÀ-ú]{1,50}$/, "Il cognome non è valido."],
    "email": [/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/, "L'email non è valida."],
    "subject": [/^[a-zA-ZÀ-ú0-9!,.?\s]{1,100}$/, "L'oggetto non è valido."],
    "messaggio": [/^[a-zA-ZÀ-ú0-9~!@#€%^&*()`;':,./?\s]{1,2000}$/, "Il messaggio non è valido."],
    "insert-title": [/^[a-zA-ZÀ-ú0-9!&()`;':,./?\s]{1,100}$/, "Il titolo non è valido."],
    "insert-synopsis": [/^[a-zA-ZÀ-ú0-9!&()`;':,./?\s]{1,500}$/, "La sinossi non è valida."],
    "insert-countries": [/^[a-zA-ZÀ-ú(),.\s]{1,100}$/, "I paesi di produzione non sono validi."],
    "edit-synopsis": [/^[a-zA-ZÀ-ú0-9!&()`;':,./?\s]{1,500}$/, "La sinossi non è valida."],
    "edit-countries": [/^[a-zA-ZÀ-ú(),.\s]{1,100}$/, "I paesi di produzione non sono validi."],
}

function validation() {
    for(var id in input_id) {
        if(document.getElementById(id)) {
            var input = document.getElementById(id);
            input.onblur = function () {
                validate(this);
            };
        }
    }
}

function formValidation(formname) {
    for(var id in input_id) {
        var input = document.getElementById(id);
        if(input.form.name == formname && !validate(input)) {
            return false;
        }
    }
    return true;
}

function validate(input) {
    var regex = input_id[input.id][0];
    var text = input.value;
    if(text.length > 0 && text.search(regex) != 0) {
        error(input);
        return false;
    } else if(document.getElementById(input.id).nextSibling.className == "error") {
        document.getElementById(input.id).nextSibling.remove();
    }
    return true;
}

function error(input) {
    var e = document.createElement("p");
    e.className = "error";
    e.role="alert";
    e.style.marginBottom = "1em";
    e.appendChild(document.createTextNode(input_id[input.id][1]));
    if(document.getElementById(input.id).nextSibling.className != "error") {
        input.after(e);
    }
}

function userValidation() {
    var username = document.getElementById("username").value;
    var requsername = document.getElementsByClassName("requirements")[0].getElementsByTagName("li");
    var green = "rgb(0, 200, 0)";
    
    if(username.search(/^\S{4,}$/) != 0) {
        requsername[0].style.color = "";
        requsername[0].setAttribute("check", "");
    } else {
        requsername[0].style.color = green;
        requsername[0].setAttribute("check", " ✓");
    }

    if(username.search(/^\S{1,50}$/) != 0) {
        requsername[1].style.color = "";
        requsername[1].setAttribute("check", "");
    } else {
        requsername[1].style.color = green;
        requsername[1].setAttribute("check", " ✓");
    }

    if(username.search(/^[a-zA-Z\d_]+$/) != 0) {
        requsername[2].style.color = "";
        requsername[2].setAttribute("check", "");
    } else {
        requsername[2].style.color = green;
        requsername[2].setAttribute("check", " ✓");
    }
}

function pswValidation() {
    var password = document.getElementById("password").value;
    var reqpassword = document.getElementsByClassName("requirements")[1].getElementsByTagName("li");
    var green = "rgb(0, 200, 0)";

    if(password.search(/^\S{4,}$/) != 0) {
        reqpassword[0].style.color = "";
        reqpassword[0].setAttribute("check", "");
    } else {
        reqpassword[0].style.color = green;
        reqpassword[0].setAttribute("check", " ✓");
    }

    if(password.search(/^[A-Za-z\d!@#$%^&*]+$/) != 0) {
        reqpassword[1].style.color = "";
        reqpassword[1].setAttribute("check", "");
    } else {
        reqpassword[1].style.color = green;
        reqpassword[1].setAttribute("check", " ✓");
    }
}