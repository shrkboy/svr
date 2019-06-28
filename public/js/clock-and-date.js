$(document).ready(function () {
    /*Current date script credit: 
    JavaScript Kit (www.javascriptkit.com)
    Over 200+ free scripts here!
    */
    const mydate = new Date();
    let year = mydate.getYear();
    if (year < 1000)
        year += 1900;
    let day = mydate.getDay();
    const month = mydate.getMonth();
    let daym = mydate.getDate();
    if (daym < 10)
        daym = "0" + daym;
    let dayarray = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    let montharray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $("#date").text(dayarray[day] + ", " + montharray[month] + " " + daym + ", " + year)

    $(function () {
        setInterval(function () {
            let date = new Date(),
                time = date.toLocaleTimeString();
            $("#clock").text(time);
        }, 1000);
    });
});
