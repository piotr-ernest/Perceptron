
$(document).ready(function () {

    $('form input').keypress(function (e) {
        if (e.which !== 45 && e.which !== 13 && e.which !== 44 && 
                e.which !== 46 && e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
            console.log(e.which);
            e.preventDefault();
        }

    });


});