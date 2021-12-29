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
//Show and Hide div contents in Dashboard Container
function showDiv (dashContent) {
    var unhiddenDiv = document.getElementsByClassName("unhidden");
    var i;
    for (i = 0; i < unhiddenDiv.length; i++) { 
        unhiddenDiv[i].className = 'hidden'; 
    }
    document.getElementById(dashContent).className = "unhidden";
}
//Show and hide '+ New Trip' button and trip form panel
function showTripForm() {
    document.getElementById('add_trip_btn').style.display = "none";
    document.getElementById('insert-new-trip-schedule').style.display = "block";
}
function hideTripForm() {
    document.getElementById('add_trip_btn').style.display = "block";
    document.getElementById('insert-new-trip-schedule').style.display = "none";
}