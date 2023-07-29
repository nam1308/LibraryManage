$(document).ready(function () {
  $(document).on("submit", "#create-form", function (e) {
    e.preventDefault();
    var form = this;
    $.ajax({
      url: $("#create-form").prop("action"),
      type: "POST",
      processData: false,
      dataType: "json",
      contentType: false,
      data: new FormData(form),
      success: function (res) {
        !res.status ? showMessageToast(res, "bg-gradient-warning") : createSuccess(res) ;
      },
      error: function (err) {
        var errors = err.responseJSON;
        showValidateErrorMessage(errors.errors);
      },
    });
  });

  $("#modal-form").on("hide.bs.modal", function () {
    resetFormModal();
  });

  $("#modal-form").on("show.bs.modal", function () {
    var parent = $(this).find('.uploadFile');
    parent.find('.ipt-avatar').val('');
    parent.find('input[name="avatar_old"]').val('');
    parent.find('img').attr('src', '');
    $('#modal-form .uploadFile,#modal-form .wrapper').removeClass('active');
    $("#create-form")[0].reset();
    formatDate($("#birthday-input"), new Date(), new Date(), null);
    $("#birthday-input").val("dd-mm-yyyy");
  });

  $('#birthday-input').on('change', function() {
    $('#birthday-error').empty();
  });

  $('#name-input, #email-input, #gender-input, #birthday-input, #department_id-input, #address-input, #note-input, #employee_id-input, #file-input').on('input', function () {
    $('#' + $(this).attr('name') + '-error').empty();
  });
});

function showValidateErrorMessage(errors) {
  $("span.error").remove();
  for (var error in errors) {
    $("#" + error + "-group").addClass("is-invalid");
    $("#" + error + "-error").append(
      '<span class="error text-danger"> <small>' +
        errors[error] +
        "</small></span>"
    );
  }
}

function resetFormModal() {
  $("span.error").remove();
  $(".input-group").removeClass("is-invalid");
  $("#create-form")[0].reset();
}

function createSuccess(data){
  $("#modal-form").modal('hide');
  showMessageToast(data, "bg-gradient-success" );
  setTimeout(()=>location.reload(), 2000);
}