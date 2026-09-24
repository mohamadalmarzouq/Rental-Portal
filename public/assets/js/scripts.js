

function setUnitType(value) {

    var selected_text = $("#type_id :selected").data('value');
    if (selected_text == "Residential" || selected_text == "Investment") {

        var html = '<option id="residential_type"' +
            'value="residential">' +
            'Residential </option>';


        $('#unit_select_type').append(html);

    } else {


    }
}

function removeAjaxMsgs() {
    let errorDiv = $('.ajax-error-div');
    let errorMsgElm = $('.ajax-error-msg');
    $('.text-danger').remove();
    $('.text-success').remove();

    errorDiv.css('display', 'none');
    console.log('removeAjaxMsgs');
    errorMsgElm.html('');
}

function formSuccessAction(form_elm, modal_elm, datatable_elm) {
    form_elm.before('<p class="text-success">Form Submitted Successfully!</p>');
    setTimeout(function () {
        if (form_elm.length) {
            modal_elm.modal('hide');
            form_elm[0].reset();
        }
    }, 1500);

    setTimeout(function () {
        datatable_elm.DataTable().ajax.reload();
    }, 2000);

}

function showErrorMsgs(errs) {
    var response = errs.responseJSON;
    if (!response || !response.errors) {
        var form = $('#addForm, #editForm, #commentForm').filter(':visible').first();
        var message = (response && response.message) ? response.message : 'Something went wrong. Please try again.';
        form.prepend('<p class="text-danger">' + message + '</p>');
        return;
    }
    $.each(response.errors, function (key, value) {

        let msg = value[0].replace(" id", "");
        key = key.replace(/\./g, '_');
        // console.log(key)
        $("#" + key).parent().append('<p class="text-danger">' + msg + '</p>');
    });
}

function show_amount(val){
    var enable = document.getElementById('yes');
    if (enable.checked == true){
        var html = '<div class="form-group m-0 "><label for="" class="mb-1 tx-medium">Deposit</label><input type="text" name="deposit" id="deposit" class="form-control" placeholder="Enter Amount"></div>';
        $('.deposit_info').html(html);
    }
    else{
        $('.deposit_info').html('');
    }
}

function deleteRow(id, module, elm) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value
        ) {
            let request_url = base_url + '/' + module + '-delete/' + id;

            removeAjaxMsgs();
            $.get(request_url).done(function () {

                let table = elm.closest('table').DataTable();
                table.ajax.reload(null, false);

                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                )
            }).fail(function (err) {
                console.log(err);
            });
        }
    })
}

$(document).on('submit', '#addForm,#commentForm', function (event) {
    event.preventDefault();
    removeAjaxMsgs();
    let form = $(this);
    let btn = form.find('.btn');
    btn.attr("disabled", true);
    //btn.addClass('loader');
    var formData = new FormData(this);
    // $('.btn_loader').css('display','block');
    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            // console.log(data);
           location.reload();
        }, error: function (err) {
            btn.attr("disabled", false);
            //  $('.btn_loader').css('display','none');
            btn.removeClass('loader');
            showErrorMsgs(err);
        },
        // complete: function () {
        //     btn.attr("disabled", false);
        // }
    });
});

$(document).on('submit', '#editForm', function (event) {
    event.preventDefault();
    removeAjaxMsgs();
    let form = $(this);
    let btn = form.find('.btn');
    btn.attr("disabled", true);
   // btn.addClass('loader');
   // $('.btn_loader').css('display','block');
    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            //console.log(data);
            history.go(-1);
        }, error: function (err) {
            btn.attr("disabled", false);
   //         btn.removeClass('loader');
           // $('.btn_loader').css('display','none');
            showErrorMsgs(err);
        }
    });
});

$('#addModal').on('hidden.bs.modal', function () {
    removeAjaxMsgs();
});

let search_elm = $('#global_search');
let search_results_elm = $('#search_results');

search_elm.on('keypress', function (e) {

    if (e.which == 13) {
        search_results_elm.html('');

        e.preventDefault();

        let url = base_url + '/search';
        let value = $(this).val();

        $.get(url, {query: value})
            .then((data) => {
                if (data) {
                    console.log(data)
                    console.log("On Key Press");
                    search_results_elm.css('display', 'block');
                    search_results_elm.html(data);
                }
            });
    }
    if (!$(this).val()) {
        console.log("On Key next if");
        search_results_elm.css('display', 'none');
        search_results_elm.html('');
    }
});

function search() {
    search_results_elm.html('');


    let url = base_url + '/search';
    let value = search_elm.val();

    $.get(url, {query: value})
        .then((data) => {
            if (data) {
                console.log(data)
                search_results_elm.css('display', 'block');
                search_results_elm.html(data);
            }
        });
}


$('#modal_body').on('click', function (e) {
    e.stopPropagation();
})



// $('#modalClose').on('click',function(){
//    // $('#viewModal').hide();
//    // $('.viewModal').html('');
//     //$('#exampleModalLabel2').html('View ' + header);
//    // $('#viewModal').modal('hide');
//
// });

$("#modalClose").on('click',function(){
    $('#viewModal').modal('hide');
})
$(document).on('focusout','#monthly_rent',function(){
    var estimated_rent = parseInt($('#estimated_rent').val());
    if(estimated_rent)
        {
            var month_rent = $(this).val();
            var numberWithoutComma = month_rent.replace(/,/g, '');
                month_rent = parseInt(numberWithoutComma, 10);
            if(month_rent < estimated_rent)
            {
                alert('Monthly rent must be greater than or equal to estimated rent.');
                $(this).val('');
                return;
            }
        }
});
function ReplaceNumberWithCommas(yourNumber, elm) {

  let number = yourNumber.replace('KWD ', '');

    number = parseInt(number.replace(/\D/g, ''));

    if (!$.isNumeric(number)) {
        return;
    }

    let value = number.toLocaleString();

    elm.val(value);

}

setInterval(function () {
    getNotificationCount()
}, 5000);

function getNotifications(count) {

    $.get(base_url + '/get-notifications/' + count)
        .done(function (data) {
            if (count) {
                $('.be-notifications').html(data);
            }
        })
        .fail(function (err) {
            console.log(err);
        })

}

function getNotificationCount() {
    $('#notification-counter').remove();
    $.get(base_url + '/get-notification-count')
        .done(function (data) {
            console.log(data)
            if (data > 0) {
                $('.new-indicator').append('<span id="notification-counter">' + data + '</span>');
                ion.sound.play("button_tiny");
            }
        })
        .fail(function (err) {
            console.log(err)
        })
}

function printDiv(divID) {
    $('#' + divID).printThis();
}

/*function checkResidenceType(value){

    if(value=='residential'){
        $("#res_type_status").append('<div id="res_status" class="col-sm-6">' +
            '<label for="" class="mb-1 tx-medium">Choose Status</label>\n' +
            '                            <div>\n' +
            '                                <label for="" class="mb-1">Family</label>\n' +
            '                                <input type="radio" name="marriage_status" value="family"'+name+'/></div>\n' +
            '                                <div><label for="" class="mb-1">Single</label>\n' +
            '                                <input type="radio" name="marriage_status" value="single"/>\n' +
            '                            </div>\n' +
            '                        </div>');
        //$('#res_status').css('display','block');
        //alert("you selected res");

    }
    else if(value=="commercial"){
        $("#res_status").remove();
    }

}*/


function changeUnitType(value){
    let id = value;

    if (!id) {
        return;
    }

            let requested_url = base_url + '/properties-get-residence-units-type/' + id;
            $.get(requested_url).done(function (data) {
                if (typeof data === 'object' && data && data.error) {
                    alert(data.error);
                    return false;
                }
                $('#unit_residence_type').html(data);
                if ($('#residence_type').val()) {
                    checkResidenceType($('#residence_type').val());
                }
                var esti_rent = parseInt($('#estimated_rent').val())
                var month_rent = ($('#monthly_rent').val());

                var numberWithoutComma = month_rent ? month_rent.replace(/,/g, '') : '';
                month_rent = parseInt(numberWithoutComma, 10);

                if(esti_rent && month_rent)
                {
                    if(month_rent < esti_rent)
                        {
                            alert('Monthly rent must be greater than or equal to estimated rent.');
                            $('#monthly_rent').val('');
                            return;
                        }
                }
                $("#res_type_status").html('');

            }).fail(function (error) {

            });
}

function checkResidenceType(value) {
    if (value == "residential") {
        $("#res_type_status").append(' ' +
            '                            <div class="form-group" id="res_status">\n' +
            '                                <label for="" class="mb-1 tx-medium">Choose Status</label>\n' +
            '                                <select  class="custom-select mr-0 font-weight-500"\n' +
            '                                        name="marriage_status">\n' +
            '\n' +
            '                                    <option \n' +
            '                                            value="family">\n' +
            '                                        Family\n' +
            '                                    </option>\n' +
            '                                    <option \n' +
            '                                            value="single">\n' +
            '                                        Single\n' +
            '                                    </option>\n' +
            '                                </select>\n' +
            '                            </div>\n' +
            '                        </div>');
    } else if (value == "commercial") {
        $("#res_status").remove();
    }
}



function show_options(value) {
    var enable = document.getElementById('enable_notifications');
    if (enable.checked == true) {
        $("#notification_types_box").append('<div id="notification_type" class="col-sm-6">' +
            '<label for="" class="mb-1 tx-medium">Choose Type</label>\n' +
            '                            <div>\n' +
            '                                <input type="checkbox" id="tenant-email" name="notification[]" value="email"/>\n' +
            '                                 <label htmlFor="" className="mb-1">Email</label></div>\n' +
            '                                <div><input  type="checkbox" id="notification" name="notification[]" value="sms"/>\n' +
            '                                <label for="notification" class="mb-1">SMS</label>\n' +
            '                            </div>\n' +
            '                        </div>');
        enable.value = "1";
    } else {
        $("#notification_type").remove();
        enable.value = "0";
    }
}

function setUnitType() {
    var selected_text = $("#rental :selected").data('value');

    $('#unit_type').text(selected_text);
}


function view(id, module, header = '') {

    let request_url = base_url + '/' + module + '-view/' + id;

    $.get(request_url).done(function (data) {
        $('.viewModal').html(data);
        $('#exampleModalLabel2').html('View ' + header);
        //$('#viewModal').modal('show');
    }).fail(function (err) {
        console.log(err);
    });
}

function addComment(id) {

    let request_url = base_url + '/leases-comment-view/' + id;

    $.get(request_url).done(function (data) {
        $('.commentModal').html(data);
        $('#commentModal').modal('show');
    }).fail(function (err) {
        console.log(err);
    });
}



