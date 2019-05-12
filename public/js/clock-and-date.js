$(document).ready(function () {
    /*Current date script credit: 
    JavaScript Kit (www.javascriptkit.com)
    Over 200+ free scripts here!
    */

    var mydate = new Date()
    var year = mydate.getYear()
    if (year < 1000)
        year += 1900
    var day = mydate.getDay()
    var month = mydate.getMonth()
    var daym = mydate.getDate()
    if (daym < 10)
        daym = "0" + daym
    var dayarray = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")
    var montharray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
    $("#date").text(dayarray[day] + ", " + montharray[month] + " " + daym + ", " + year)

    $(function () {
        setInterval(function () {
            var date = new Date(),
                time = date.toLocaleTimeString();
            $("#clock").text(time);
        }, 1000);
    });})
