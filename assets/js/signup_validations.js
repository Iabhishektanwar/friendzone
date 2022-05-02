$(function () {

    $.validator.addMethod("strongPassword", function (value, element) {
        return this.optional(element)
            || value.length >= 8
            && /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})(?=.*[!@#$%^&*])/.test(value);
    }, "")

    $.validator.addMethod("emailCheck", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._]+@[a-zA-Z0-9._]+\.[a-zA-Z]{1,}$/.test(value);
    }, "");

    $.validator.addMethod("validateName", function (value, element) {
        return this.optional(element) || /^[a-zA-Z]{4,}$/.test(value);
    }, "");

    $.validator.addMethod("validateUsername", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._]{6,}$/.test(value);
    }, "");


    $("form").validate({
        rules: {
            firstName: {
                required: true,
                minlength: 4,
                validateName: true
            },
            lastName: {
                required: true,
                minlength: 4,
                validateName: true
            },
            username: {
                required: true,
                minlength: 6,
                validateUsername: true
            },
            email: {
                required: true,
                email: true,
                emailCheck: true
            },
            password: {
                required: true,
                strongPassword: true
            },
            confirmpassword: {
                required: true,
                strongPassword: true,
                equalTo: "#password"
            }
        },
        messages: {
            firstName: {
                required: "First name is required",
                minlength: "First name should contain atleast 4 characters",
                validateName: "First name must begin with a letter and cannot contain spaces"
            },
            lastName: {
                required: "Last name is required",
                minlength: "Last name should contain atleast 4 characters",
                validateName: "Last name must begin with a letter and cannot contain spaces"
            },
            username: {
                required: "Username is required",
                minlength: "Username should contain atleast 6 characters",
                validateUsername: "Username must contain only letters, numbers, period or the underscore character"

            },
            email: {
                required: "Email is required",
                email: "Please enter a <em>valid</em> email address",
                emailCheck: "Please enter a <em>valid</em> email address"
            },
            password: {
                required: "Password is required",
                strongPassword: "Password should have at least 8 characters with a mix of both uppercase and lowercase letters, numbers & special character"
            },
            confirmpassword: {
                required: "Confirm password is required",
                equalTo: "Confirm password should be same as password",
                strongPassword: "Confirm password should have at least 8 characters with a mix of both uppercase and lowercase letters, numbers & special character"
            }
        }
    });
})

$(document).ready(function () {
    $('#firstName').keyup(function () {
        var regexname = /^[a-zA-Z]{4,}$/;
        if (regexname.test($('#firstName').val())) {
            $('#firstName').removeClass('is-invalid');
            $('#firstName').addClass('is-valid');
        } else {
            $('#firstName').removeClass('is-valid');
            $('#firstName').addClass('is-invalid');
        }
    })

    $('#lastName').keyup(function () {
        var regexname = /^[a-zA-Z]{4,}$/;
        if (regexname.test($('#lastName').val())) {
            $('#lastName').removeClass('is-invalid');
            $('#lastName').addClass('is-valid');
        } else {
            $('#lastName').removeClass('is-valid');
            $('#lastName').addClass('is-invalid');
        }
    })

    $('#username').keyup(function () {
        var regexname = /^[a-zA-Z0-9._]{6,}$/;
        if (regexname.test($('#username').val())) {
            $('#username').removeClass('is-invalid');
            $('#username').addClass('is-valid');
        } else {
            $('#username').removeClass('is-valid');
            $('#username').addClass('is-invalid');
        }
    })

    $('#email').keyup(function () {
        var regexname = /^[a-zA-Z0-9._]+@[a-zA-Z0-9._]+\.[a-zA-Z]{1,}$/;
        if (regexname.test($('#email').val())) {
            $('#email').removeClass('is-invalid');
            $('#email').addClass('is-valid');
        } else {
            $('#email').removeClass('is-valid');
            $('#email').addClass('is-invalid');
        }
    })

    $('#password').keyup(function () {
        var regexname = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})(?=.*[!@#$%^&*])/;
        if (regexname.test($('#password').val())) {
            $('#password').removeClass('is-invalid');
            $('#password').addClass('is-valid');
        } else {
            $('#password').removeClass('is-valid');
            $('#password').addClass('is-invalid');
        }
    })

    $('#confirmpassword').keyup(function () {
        var regexname = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})(?=.*[!@#$%^&*])/;
        if (regexname.test($('#confirmpassword').val())) {
            if ($('#confirmpassword').val() == $('#password').val()) {
                $('#confirmpassword').removeClass('is-invalid');
                $('#confirmpassword').addClass('is-valid');
            } else {
                $('#confirmpassword').removeClass('is-valid');
                $('#confirmpassword').addClass('is-invalid');
            }
        } else {
            $('#confirmpassword').removeClass('is-valid');
            $('#confirmpassword').addClass('is-invalid');
        }
    })
})