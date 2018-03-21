$(document).ready(function(){
    $("#panel-old-reservations-title").click(function(){
        $("#panel-old-reservations").slideToggle("50");
    });
});

$(document).ready(function(){
    $("#location-details-button").click(function(){
        $("#panel-body-details-lower").slideToggle("50");
    });
});

$(document).ready(function(){
    $(".slide-upper").click(function(){
        $(this).next().slideToggle("50");
        $(this).parent().siblings().children().next().slideUp();
        return false;
    });
});

$(document).ready(function(){
    $(".button-slide-next").click(function(){
        $(".slide-next-panel").slideDown("50");
        $(".reservation-step-one").slideUp("50");
    });
});

$(document).ready(function(){
    $(".button-slide-prev").click(function(){
        $(".slide-next-panel").slideUp("50");
        $(".reservation-step-one").slideDown("50");
    });
});
