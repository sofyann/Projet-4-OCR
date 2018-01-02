$(document).ready(function () {


    var container = $('.js-visitor-wrapper');
    var index = 0;

    if(index ===0){

        addVisitor();
    }
    function addVisitor() {
        var template = container.attr('data-prototype')
            .replace(/__name__label__/g, 'Visiteur n°'+(index+1))
            .replace(/__name__/g, index);
        container.append(template);
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