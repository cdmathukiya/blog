$(document).ready(function() {

    $('#postModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var action = button.data('action')
      var url    = button.data('url');

          var modal = $(this)
          modal.find('.modal-title').text(action)
        $.ajax({
            type: "Get",
            url: url,
            beforeSend: function() {
                modal.find('.modal-body').html("<h4 class='text-center'>Loading...</h4>");
            },
            success: function(data) {
                modal.find('.modal-body').html(data);

                ClassicEditor
                .create( document.querySelector( '#description' ) )
                .then( editor => {
                    console.log( 'Editor was initialized', editor );
                    myEditor = editor;
                } )
                .catch( error => {
                    console.error( error );
                } );
            },
            error: function(xhr, status, result) {
                modal.find('.modal-body').html(result);
            }
        });
          
    })

    $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('.filter_change').change(function(){
        loadTable();
    });
    loadTable();

    $(document).off('click','#save_post').on('click','#save_post', function(event){
        var ele = $(this);
        var old_txt = ele.text();
        var form = ele.closest('form');
        $('#description').val(myEditor.getData());
        var formData = new FormData(form[0]);
        ele.text("please wait...");
        ele.attr("disabled", "disabled");
        $.ajax({
            url: savePostUrl,
            type: "post",
            // data: form.serialize(),
            dataType: "json",
            data:  formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
                $('.error,.submit_notification').html('');
                form.find(".form-control").removeClass("red_border");
                $('.btn').attr("disabled", "disabled");
                ele.val("Sending...");
            },
            success: function(result) {
                ele.text(old_txt);
                $('.btn').removeAttr("disabled");
                if (result["status"] == "validation") {
                    $.each(result, function(key, val) {
                        if (val != "") {
                            form.find("#" + key + "_error").addClass("error");
                            form.find("#" + key + "_error").html(val);
                        }
                    });
                } else if (result["status"] == "success") {
                    form[0].reset();
                    form.find('.submit_notification').html('<span class="text-success error">' + result.message + '</span>');
                    $('#postModal').modal('close');
                    loadTable();
                }
            },
            error: function(xhr, status, result) {
                ele.text(old_txt);
                $('.btn').removeAttr("disabled");
                form.find('.submit_notification').html('<span class="text-danger error">' + result.message + '</span>');
            }
        });
        return false;
    });

    $("body").off("click", ".btn-delete").on("click", ".btn-delete", function() {
        var ele = $(this);
        var old_txt = ele.text();
        var id   = ele.data('id');
        var url   = ele.data('url');
        if(confirm("Are you sure you want to delete this?")){
            ele.attr("disabled", "disabled");
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                beforeSend: function() {
                    $('.error,.submit_notification').html('');
                    $(".form-control").removeClass("red_border");
                    $('.btn').attr("disabled", "disabled");
                    ele.text("...").val("...");
                },
                success: function(result) {
                    ele.text(old_txt);
                    $('.btn').removeAttr("disabled");
                    if (result["status"] == "success") {
                        $('.submit_notification').html('<span class="text-success error">' + result.message + '</span>');
                        ele.closest(".post-section").remove();
                    } else {
                        $('.submit_notification').html('<span class="text-danger error">' + result.message + '</span>');
                    }
                },
                error: function(xhr, status, result) {
                    ele.text(old_txt);
                    $('.btn').removeAttr("disabled");
                    $('.submit_notification').html('<span class="text-danger error">' + result.message + '</span>');
                }
            });
        }else {
            return false;
        }
        return false;
    });
});

function loadTable() {
    var frm = $("#filter_table").serialize();
    $.ajax({
        type: "POST",
        url: loadPostUrl,
        data: frm,
        beforeSend: function() {
            $("#load_table").html("<h4 class='text-center'>Loading...</h4>");
        },
        success: function(data) {
            $("#load_table").html(data);
        },
        error: function(xhr, status, result) {
            $("#load_table").html(data);
        }
    });
 }