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
//Populate destination drop down list
function configureDropDownLists(orig,dest) {
    var points = ['BAGUIO', 'BONTOC, MT. PROVINCE', 'FAIRVIEW, QC'];
    dest.options.length = 1;
    if(orig.value == '') {
        dest.options.length = 1;
    } else {
        for (i = 0; i < points.length; i++) {
            if(orig.value != points[i]) {
                createOption(dest, points[i], points[i]);
            }
        }
    }
}
function createOption(dest, text, value) {
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    dest.options.add(opt);
}
//Set input number to two decimal places
function setTwoNumberDecimal(fare) {
    fare.value = parseFloat(fare.value).toFixed(2);
}
//Show Search Passenger Form
function showPassengerSearchForm(){
    document.getElementById('passenger-search-form').style.display = "block";
    document.getElementById('passenger-table').style.display = "none";
}
function showPassengerTable(){
    document.getElementById('passenger-search-form').style.display = "none";
    document.getElementById('passenger-table').style.display = "block";
}
function confirmationPassenger(pId){
    if(confirm('Are you sure to confirm this passenger?')){
        window.location.href='dashboard.php?view_panel=reservation&passengerId='+pId+'&confirmation=true';
    }
}

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}