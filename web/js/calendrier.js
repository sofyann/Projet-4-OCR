$(document).ready(function () {
    var daySelected;
    var currentDate = new Date();

    function calendarGenerate(year,  month) {
        var months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        $('#monthAndYear').text(months[month-1]+' '+year);

        var numberOfDaysInMonth = daysInMonth(month, year);
        var calendrierHTML;

        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth()+1;
        var currentDay = currentDate.getDate();

        if (month === currentMonth){
            $('#prev').hide();
        } else {
            $('#prev').show();
        }
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
        ajaxRequest(month, year);
    }
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    calendarGenerate(year, month);
    var dateVal = $('#app_bundle_commande_type_date').val();
    if (Date.parse(dateVal)){
        var dateExist = new Date(dateVal);

        selectionDay(dateExist.getDate());
    }

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
        var date = new Date(year, month, day);
        var date2 = new Date(currentDate.getFullYear(), currentDate.getMonth()+1, currentDate.getDate());
        if (date.getTime() < date2.getTime()){
            clickable = false;
        }
        return clickable;
    }

    $("#next").click(function () {
        month++;
        if (month > 12){
            year++;
            month = 1;
        }
        calendarGenerate(year, month);
    });

    $("#prev").click(function () {
        month--;
        if (month < 1){
            year--;
            month = 12;
        }
        calendarGenerate(year, month);
    });

    $("#calendar").on("click", ".clickable",function () {
        var day = $(this).text();
        daySelected = day;
        selectionDay(day, month, year);
        if (day < 10){
            day = '0'+day;
        }
        var monthStr;
        if (month < 10){
                monthStr = '0'+ month;
        }
        var formatedDate = year+'-'+monthStr+'-'+day;
        if (new Date(formatedDate).getDate() === currentDate.getDate()){
            is14hpassed(currentDate.getHours());
        } else {
            $('#app_bundle_commande_type_duree_1').prop('disabled', false);
        }
        $('#app_bundle_commande_type_date').val(formatedDate);
    });

    function selectionDay(day) {
        console.log(daySelected);
        $('.daySelected').removeClass('daySelected');

        $('#'+day).addClass('daySelected');
    }

    function is14hpassed(hours){
        if (hours > 14){
            $('#app_bundle_commande_type_duree_1').prop('disabled', true);
            $('#app_bundle_commande_type_duree_0').prop('checked', true);
        }
    }

    function ajaxRequest(month, year){
        if (month < 10){
            month = '0'+month;
        }
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: 'http://localhost:8000/calendar/'+year+'/'+month+'',
            success: function (data) {
                days = data.days;
                for(var i = 0; i < days.length; i++){
                    console.log(days[i]);
                    $('#'+days[i]).addClass('notClickable');
                    $('#'+days[i]).removeClass('clickable');
                }
            },
            error: function () {
                alert('la requête n\'a pas abouti');
            }
        });
    }


});
