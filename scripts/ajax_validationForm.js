$(document).ready(function() {
    $('#formSignIn').submit(function (e) {
        e.preventDefault();

        let data = {
                "login": $('#loginIn').val(),
                "password": $('#passwordIn').val()
            };

        $(".error").remove();

        if (data['login'] !== '' && data['password'] !== '') {
            $.ajax({
                type: 'post',
                url: '../ajax_validationForm.php',
                data: {
                    key: 'in',
                    data: data
                },
                dataType: 'text',
                success:function(response) {
                    let resp = JSON.parse(response);

                    if (resp.msg === 'signIn') {
                        document.location.reload();
                    } else if (resp.msg === 'error') {
                        $('#formSignIn').after('<span style="color: red" class="error">Username/Password incorrect.</span>');
                    }
                }
            })
        }
    });

    $('#formRegistration').submit(function (e) {
        e.preventDefault();

        var data = {
                "login": $('#loginUp').val(),
                "password": $('#passwordUp').val(),
                "email": $('#emailUp').val()
            };

        $(".error").remove();

        if (data['login'].length < 4) {
            $('#loginUp').after('<span style="color: red" class="error">Login must be atleast 4 characterslong.</span>');
        }

        if (data['password'].length < 6) {
            $('#passwordUp').after('<span style="color: red" class="error">Password must be atleast 6 characterslong.</span>');
        }

        if (data['login'].length < 4 || data['password'].length < 6) {
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
                    let resp = JSON.parse(response);

                    if (resp.msg === 'signUp') {
                        document.location.reload()
                    } else if (resp.msg === 'error') {
                        $('#formRegistration').after('<span style="color: red" class="error">This login already exists.</span>');
                    }
                }
            })
        }
    });

    $('#logoutBtn').click(function() {
        $.ajax({
            type: 'post',
            url: '../ajax_validationForm.php',
            data: {
                key: 'logout',
            },
            success:function() {
                window.location.reload()
            }
        })
    });
});