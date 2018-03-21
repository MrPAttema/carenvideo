
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
    $(".button-slide-next").click(function(){
        $(".reservation-step-two").slideDown("50");
        $(".hidden").css("display", "block", "!important");
        $(".reservation-step-one").slideUp("50");
    });
});

$(document).ready(function(){
    $(".button-slide-next-two").click(function(){
        $(".slide-next-panel-three").slideDown("50");
        $(".hidden-two").css("display", "block", "!important");
        $(".reservation-step-two").slideUp("50");
    });
});

$(document).ready(function(){
    $(".button-slide-prev").click(function(){
        $(".reservation-step-two").slideUp("50");
        $(".reservation-step-one").slideDown("50");
    });
});

$(document).ready(function(){
    $(".button-slide-prev-two").click(function(){
        $(".reservation-step-three").slideUp("50");
        $(".reservation-step-two").slideDown("50");
    });
});

$(document).ready(function(){
    $("#reserv-button").on("click", function(){
        $(".waiting").css('display', 'block');
    });
});

$(document).ready(function(){
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    };
});

// $(document).ready(function(){
//   $('#res_year').change(function(){
//     var res_year = $(this).val();
//     $.ajax({
//       type: 'POST',
//       dataType: 'json',
//       url: '/reservations/new/steptwo',
//       data: {
//         "_token": "{{ csrf_token() }}",
//         "res_year": res_year,
//       },
//       success: function(response) {
//         console.log(response);
//       },
//       error: function(data) {
//         alert('Er kan geen data op worden gehaald.\nNeem contact op met een administrator.\nU kunt niet verder met de reservering.');
//       }
//     });
//   });
// });
$(document).ready(function() {
	$('.submit-btn').click(function() {
	    $(this).addClass('loading');
	    $('.cancable').addClass('disabled');
	    $('.cancable').prop('disabled', true);
	});
});

$(document).ready(function() {
	$('.toast-clear').click(function() {
		$(".toast").fadeOut(400);
	});
});

$(document).ready(function() {
	$('.modal-clear').click(function() {
		$(".modal").removeClass('active');
	});
});

$(document).ready(function() {
	$('.modal-open').click(function() {
	    $('.modal').addClass('active');
	});
});

$(document).ready(function () {
    $(".mobileIcon").click(function () {
        $(".mobile-menu").toggle();
    });
});

// $('input[name="subscribe"]').on('click', function(){
//     if ( $(this).is(':checked') ) {
//         $('input[name="email"]').show();
//     } 
//     else {
//         $('input[name="email"]').hide();
//     }
// });

// $(document).ready(function() {
// 	$('.checkbox-submit').is(':checked'){
// 		console.log('CHECKED');
// 	};
// });

$('#search-admin-reservations').click( function (e) {
    e.preventDefault();
    var keyword = $('#keyword').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: '/search/adminreservations',
        dataType: "JSON",
        cache: false,
        data: {
            keyword: keyword,
        },
        success: function(response) {
            $.each(response, function() {
                console.log(this);
                
            });
            $("#search-results").html(response);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("error: "+ XMLHttpRequest.responseText);
        }
    });
});

//# sourceMappingURL=all.js.map
