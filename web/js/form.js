$(document).ready(function () {


    var container = $('div#app_bundle_commande_type_visiteurs');
    var index = 0;

    if(index ===0){

        addVisitor();
    }
    function addVisitor() {
        var template = container.attr('data-prototype')
            .replace(/__name__label__/g, 'Visiteur n°'+(index+1))
            .replace(/__name__/g, index);
        container.append(template);
        var line = $('div#app_bundle_commande_type_visiteurs > div');
        line.addClass('row');
        line.addClass('rowVisitor');
        line.css('text-align', 'center');
        var line = $('div#app_bundle_commande_type_visiteurs > div > div > div');
        line.addClass('col-md-2');

        $('div#app_bundle_commande_type_visiteurs > div > label').css('float', 'left');
        $('div#app_bundle_commande_type_visiteurs > div > label').addClass('control-label');
        index++;
        changeNumberOfVisitorsValue();
    }

    function deleteVisitor(){
        var nb_row = $('.rowVisitor').length;
        if(nb_row !== 1){
            index--;
            $('.rowVisitor:last').remove();
        }
        changeNumberOfVisitorsValue();
    }

    function changeNumberOfVisitorsValue(){
        $('#numberOfVisitors').text(index);
    }

    $("#addVisitor").click(function(e){
        addVisitor();
        e.preventDefault();

        return false;
    });

    $("#deleteVisitor").click(function(e){
        deleteVisitor();
        e.preventDefault();
        return false;
    });

});