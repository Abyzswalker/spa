$(document).ready(function() {
    $('#inputForm').submit(function (e) {
        e.preventDefault();
        var amount = $('#formAmount').val(),
            operation = $('#formSelect').val(),
            comment = $('#formComment').val(),
            data = {};

        $(".error").remove();

        data["amount"] = amount;
        data["operation"] = operation;
        data["comment"] = comment;

        if (amount !== '' && operation !== '') {
            $.ajax({
                type: 'post',
                url: '../ajax_operations.php',
                dataType: 'html',
                data: {
                    key: 'add',
                    data: data
                },
                error: function() {
                    alert('Что-то пошло не так!');
                },
                success:function(response) {
                    var resp = JSON.parse(response);

                    var table = resp[0],
                        summPrihod = resp[1],
                        summRashod = resp[2];

                    if ($("#operationBody tr").length < 10) {
                        $("#operationBody").prepend(table);
                    } else if ($("#tbody tr").length >= 10)  {
                        $("#operationBody").prepend(table);
                        $("#tbody").deleteRow(table);
                    }
                    $("#tdSummPrihod").html(summPrihod);
                    $("#tdSummRashod").html(summRashod);

                    $('#inputForm').trigger('reset');
                }
            })
        }
    });

    $('#operationBody').on('click', '.deleteOperation', function() {
        var id = $(this).data('id');

        if (id) {
            $.ajax({
                type: "POST",
                url: '../ajax_operations.php',
                dataType: "html",
                data: {
                    key: 'delete',
                    id: id

                },
                error: function() {
                    alert('Что-то пошло не так!');
                },
                success: function(response){
                    var resp = JSON.parse(response);

                    var table = resp[0],
                        summPrihod = resp[1] !== null ? resp[1] : 0,
                        summRashod = resp[2] !== null ? resp[2] : 0;

                    $("#operationBody").html(table);
                    $("#tdSummPrihod").html(summPrihod);
                    $("#tdSummRashod").html(summRashod);
                }
            });
        }
    });
});

