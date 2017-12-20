$(document).ready(function () {


    function calendarGenerate(year,  month) {
        var months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        $('#monthAndYear').text(months[month-1]+' '+year);

        var numberOfDaysInMonth = daysInMonth(month, year);
        var calendrierHTML;
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth()+1;
        var currentDay = currentDate.getDate();

        for (var i = 1; i <= numberOfDaysInMonth; i++){
            var dayInTheWeek = daysInWeek(month, year, i);
            // on met le dimanche en dernier jour de la semaine
            if (dayInTheWeek === 0){
                dayInTheWeek = 7;
            }

            var clickable = isClickable(dayInTheWeek, i, month, year, currentDate);

            // on genere le calendrier dans le tableau
            if (i === 1){
                calendrierHTML = '<tr>';
                for (var j = 1; j <  dayInTheWeek; j++){
                    calendrierHTML += '<td></td>';
                }
                if (clickable === true){
                    calendrierHTML += '<td id="'+i+'" class="clickable">'+i+'</td>';
                } else {
                    calendrierHTML += '<td id="'+i+'" class="notClickable">'+i+'</td>';
                }
                if (dayInTheWeek === 7){
                    calendrierHTML += '</tr>';
                }
            } else if (i === numberOfDaysInMonth){
                if (dayInTheWeek === 1){
                    calendrierHTML += '<tr>';
                }
                if (clickable === true){
                    calendrierHTML += '<td id="'+i+'" class="clickable">'+i+'</td></tr>';
                } else {
                    calendrierHTML += '<td id="'+i+'" class="notClickable">'+i+'</td></tr>';
                }
            } else {
                if (dayInTheWeek === 1){
                    calendrierHTML += '<tr>';
                }
                if (clickable === true){
                    calendrierHTML += '<td id="'+i+'" class="clickable">'+i+'</td>';
                } else {
                    calendrierHTML += '<td id="'+i+'" class="notClickable">'+i+'</td>';
                }
                if(dayInTheWeek === 7){
                    calendrierHTML += '</tr>';
                }
            }
        }
        $('#allDays').html(calendrierHTML);

        // on distingue le jour courant
        if (currentYear === year && currentMonth === month){
            $('#'+currentDay).addClass("currentDay");
        }
    }
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    calendarGenerate(year, month);


    // Nombre de jours dans un mois
    function daysInMonth(month, year){
        return new Date(year, month, 0).getDate();
    }

    // Nombre de jour dans la semaine
    function daysInWeek(month, year, day) {
        var myDate = new Date(year, month-1, day);
        return myDate.getDay();
    }

    function isClickable(dayInTheWeek, day, month, year, currentDate) {
        var clickable;
        if ((dayInTheWeek === 2) || (day === 1 && month === 5) || (day === 1 && month === 11) || (day === 25 && month === 12)){
            clickable = false;
        } else {
            clickable = true;
        }
        var date = new Date(year, month, day,14,0);
        var date2 = new Date(currentDate.getFullYear(), currentDate.getMonth()+1, currentDate.getDate());
        if (date.getTime() < date2.getTime()){
            clickable = false;
        }
        return clickable;
    }

    $("#prev").click(function () {
        month--;
        if (month < 1){
            year--;
            month = 12;
        }
        calendarGenerate(year, month);
    });

    $("#next").click(function () {
        month++;
        if (month > 12){
            year++;
            month = 1;
        }
        calendarGenerate(year, month);
    });

    $(".clickable").click(function () {
        var day = $(this).text();
        var formatedDate = year+'-'+month+'-'+day;
        console.log(formatedDate);
        $('#theDate').val(formatedDate);
    });
});
