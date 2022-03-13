$(document).ready(function() {
    $('#formSignIn').submit(function (e) {
        e.preventDefault();
        var login = $('#loginIn').val();
        var password = $('#passwordIn').val();

        $(".error").remove();

        var data = {};

        data["login"] = login;
        data["password"] = password;

        if (login !== '' && password !== '') {
            $.ajax({
                type: 'post',
                url: '../ajax_validationForm.php',
                data: {
                    key: 'in',
                    data: data
                },
                dataType: 'text',
                success:function(response) {
                    var resp = JSON.parse(response);

                    if (resp.msg === 'signIn') {
                        window.location.reload()
                    } else if (resp.msg === 'error') {
                        $('#formSignIn').after('<span style="color: red" class="error">Username/Password incorrect.</span>');
                    }
                }
            })
        }
    });

    $('#formRegistration').submit(function (e) {
        e.preventDefault();
        var login = $('#loginUp').val();
        var password = $('#passwordUp').val();
        var email = $('#emailUp').val();

        $(".error").remove();

        if (login.length < 4) {
            $('#loginUp').after('<span style="color: red" class="error">Login must be atleast 4 characterslong.</span>');
        }

        if (password.length < 6) {
            $('#passwordUp').after('<span style="color: red" class="error">Password must be atleast 6 characterslong.</span>');
        }

        var data = {};

        data["login"] = login;
        data["password"] = password;
        data["email"] = email;

        if (login.length < 4 || password.length < 6) {
            $('#formRegistration').after('<span style="color: red" class="error">Incorrect login or password. </span>');
        } else {
            $.ajax({
                type: 'post',
                url: '../ajax_validationForm.php',
                data: {
                    key: 'up',
                    data: data
                },
                dataType: 'text',
                success:function(response) {
                    var resp = JSON.parse(response);

                    if (resp.msg) {
                        window.location.reload()
                    } else if (resp.error) {
                        $('#formRegistration').after('<span style="color: red" class="error">This user already exists.</span>');
                    }
                }
            })
        }
    });

    // $('#logout').submit(function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         type: 'post',
    //         url: '../includes/validationForm.php',
    //         data: {
    //             key: 'logout',
    //         },
    //         success:function() {
    //             window.location.reload()
    //         }
    //     })
    // });
});