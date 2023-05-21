$(document).ready(function() {
    $('#inputForm').submit(function (e) {
        e.preventDefault();

        let data = {
                "amount": parseFloat($('#formAmount').val()),
                "operation": $('#formSelect').val(),
                "comment": $('#formComment').val()
            };

        $(".error").remove();

        if (data['amount'] && data['operation']) {
            $.ajax({
                type: 'post',
                url: '../ajax_operations.php',
                dataType: 'html',
                data: {
                    action: 'add',
                    data: data
                },
                error: function() {
                    alert('Что-то пошло не так!');
                },
                success:function(response) {
                    let resp = JSON.parse(response),
                        row = resp['html'];

                    if ($("#operationBody tr").length < 10) {
                        $("#operationBody").prepend(row);
                    } else if ($("#operationBody tr").length >= 10)  {
                        $("#operationBody").prepend(row);
                        $("#operationTable")[0].deleteRow(-1);
                    }

                    $("#tdSummPrihod").html(resp['summPrihod']);
                    $("#tdSummRashod").html(resp['summRashod']);

                    $('#inputForm').trigger('reset');
                }
            })
        }
    });

    $('#operationBody').on('click', '.deleteOperation', function() {
        let id = $(this).data('id');

        if (id) {
            $.ajax({
                type: "POST",
                url: '../ajax_operations.php',
                dataType: "html",
                data: {
                    action: 'delete',
                    id: id

                },
                error: function() {
                    alert('Что-то пошло не так!');
                },
                success: function(response){
                    let resp = JSON.parse(response),
                        table = resp['html'];

                    $("#operationBody").html(table);
                    $("#tdSummPrihod").html(resp['summPrihod']);
                    $("#tdSummRashod").html(resp['summRashod']);
                }
            });
        }
    });
});

