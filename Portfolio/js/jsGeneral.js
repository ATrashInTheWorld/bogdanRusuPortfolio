
$(document).ready(function() {

    // set colors
    var colorsArr = ["#FF2D00", "#0093FF", "#00D203", "#DFDC00", "#FF00F5"];
    // red - blue - green - yellow - pink
    $("span.cTxt").each(function() {
        var randomNbr = Math.floor(Math.random() * 5);
        $(this).css("color", colorsArr[randomNbr]);
    });


    //




});



function readMoreLess(el){
        if($(el).hasClass("btn-success")){
            $("#extraTxt").removeClass("collapse").addClass("collapse.show");
            $(el).text("Read Less");
            $(el).removeClass("btn-success").addClass("btn-primary");
        }
        else if($(el).hasClass("btn-primary")){
            $("#extraTxt").removeClass("collapse.show").addClass("collapse");
            $(el).text("Read More");
            $(el).removeClass("btn-primary").addClass("btn-success");
        }
}

function menuAppear(){
    console.log("OKOK");
}

