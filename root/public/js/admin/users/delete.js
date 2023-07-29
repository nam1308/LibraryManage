var modalId = '#delete-modal';
var formId = '#delete-form';
$(document).ready(function () {
  $(document).on("click", "#btn-delete", function (e) {
    var id = $(this).data('id');
    var email = $(this).data('email');
    $('#id-delete-input').val(id);
    $('#email-delete-input').val(email);
  });
  $(document).on("submit", formId, function (e) {
      e.preventDefault();
      var form = this;
      $.ajax({
          url: $(formId).prop("action"),
          type: 'post',
          processData: false,
          dataType: "json",
          contentType: false,
          data: new FormData(form),
          success: function (res) {
              !res.status ? showMessageToast(res, "bg-gradient-warning") : deleteSuccess(res) ;
          },
          error: function (err) {
              var errors = err.responseJSON;
              showValidateErrorMessage(errors.errors);
          }
      });
  });
  $(modalId).on("hide.bs.modal", function () {
    resetDeleteFormModal();
  });
});

function resetDeleteFormModal() {
  $("span.error").remove();
  $(".input-group").removeClass("is-invalid");
  $(formId)[0].reset();
}

function deleteSuccess(res)
{
  $(modalId).modal('hide');
  showMessageToast(res, "bg-gradient-success" );
  setTimeout(()=>location.reload(), 2000);
}
