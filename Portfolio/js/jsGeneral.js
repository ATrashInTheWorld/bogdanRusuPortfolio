

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

