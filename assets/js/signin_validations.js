$(document).ready(function () {
    $('#loginbtn').click(function () {
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            type: "POST",
            url: "../fz/assets/php/input_validations_signin.php",
            data: {
                "email": email,
                "password": password
            },
            success: function (response) {
                if (response[0] === '0') {
                    $('#email').removeClass('is-valid');
                    $('#email').addClass('is-invalid');
                }
                if (response[1] === '0') {
                    $('#password').removeClass('is-valid');
                    $('#password').addClass('is-invalid');
                }
            }
        })
    })

    $('#email').keyup(function () {
        var email = $('#email').val();
        if (email.length > 0) {
            $('#email').removeClass('is-invalid');
            $('#email').addClass('is-valid');
        } else {
            $('#email').removeClass('is-valid');
            $('#email').addClass('is-invalid');
        }
    })

    $('#password').keyup(function () {
        var password = $('#password').val();
        if (password.length > 0) {
            $('#password').removeClass('is-invalid');
            $('#password').addClass('is-valid');
        } else {
            $('#password').removeClass('is-valid');
            $('#password').addClass('is-invalid');
        }
    })

})

$(function () {

    $("form").validate({
        rules: {
            email: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Email is required"
            },
            password: {
                required: "Password is required"
            }
        }
    });
})