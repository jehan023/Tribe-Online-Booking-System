//Check if password and confirm password matched.
var check = function () {
    if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = '*password matched.';
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = '*password not match!';
    }
}

function showDiv (dashContent) {
    //document.getElementById(dashContent).style.display = 'block';
    if (document.getElementById(dashContent).className == "unhidden") {
        document.getElementById(dashContent).className = "hidden"
    } else {
        document.getElementById(dashContent).className = "unhidden";
    }
}

/*var unhiddenDiv = document.getElementsByClassName("unhidden");
var i;
for (i = 0; i < unhiddenDiv.length; i++) { unhiddenDiv[i].style.display = 'block'; } */
