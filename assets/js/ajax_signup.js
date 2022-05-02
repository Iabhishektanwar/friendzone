$(document).ready(function () {
    $('.checking_email').keyup(function (e) {
        var em = $('.checking_email').val();
        $.ajax({
            type: "POST",
            url: "../fz/assets/php/check_email_in_db_ajax.php",
            data: {
                "check_submit_btn": 1,
                "email_id": em,
            },
            success: function (response) {
                if (response === "This email is already associated with an account.") {
                    $('#email').removeClass('is-valid');
                    $('#email').addClass('is-invalid');
                }
                $('.email_live_validation').text(response);
            }
        })
    })

    $('#button').click(function () {
        var fname = $('#firstName').val();
        var lname = $('#lastName').val();
        var uname = $('#username').val();
        var ema = $('#email').val();
        var pas = $('#password').val();
        var cpas = $('#confirmpassword').val();
        $.ajax({
            type: "POST",
            url: "../fz/assets/php/add_invalid_class_signup.php",
            data: {
                "fname": fname,
                "lname": lname,
                "uname": uname,
                "ema": ema,
                "pas": pas,
                "cpas": cpas
            },
            success: function (response) {
                if (response[0] === '0') {
                    $('#firstName').removeClass('is-valid');
                    $('#firstName').addClass('is-invalid');
                }
                if (response[1] === '0') {
                    $('#lastName').removeClass('is-valid');
                    $('#lastName').addClass('is-invalid');
                }
                if (response[2] === '0') {
                    $('#username').removeClass('is-valid');
                    $('#username').addClass('is-invalid');
                }
                if (response[3] === '0') {
                    $('#email').removeClass('is-valid');
                    $('#email').addClass('is-invalid');
                }
                if (response[4] === '0') {
                    $('#password').removeClass('is-valid');
                    $('#password').addClass('is-invalid');
                }
                if (response[5] === '0') {
                    $('#confirmpassword').removeClass('is-valid');
                    $('#confirmpassword').addClass('is-invalid');
                }
            }
        })
    })
})