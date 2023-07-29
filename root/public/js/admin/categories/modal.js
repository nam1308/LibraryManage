$(document).ready(function () {
  $(document).on("submit", "form", function (e) {
    e.preventDefault();
    var formId = e.target.id;
    $("#" + formId + " button[type=submit]").prop('disabled', true);
    var form = this;
    $.ajax({
      url: e.target.getAttribute("action"),
      type: "POST",
      processData: false,
      dataType: "json",
      contentType: false,
      data: new FormData(form),
      success: function (res) {
        !res.status ? showMessageToast(res, "bg-gradient-warning") : createSuccess(res, e);
        $("#" + formId + " button[type=submit]").prop('disabled', false);
      },
      error: function (err) {
        var errors = err.responseJSON;
        showValidateErrorMessage(errors.errors, formId);
        $("#" + formId + " button[type=submit]").prop('disabled', false);
      },
    });
  });
  $("#create-update-modal").on("hide.bs.modal", (e)=> {
    resetForm(e.target.id);
  });
  $('form input, form select, form textarea').on("input", (e)=> {
    $("#" + e.target.closest('form').getAttribute('id') + " #" + e.target.getAttribute('name') + "-error").empty();
  });
  $(document).on("click", "#btn-create, .btn-update, .btn-delete", function (e) {
    const modalId = $(this).data('bs-target');
    var url = $(this).data('action');
    $(modalId + ' form').attr('action', url);
    if(e.target.id){
      $(modalId + " .modal-header h1").empty();
      $(modalId + ' .modal-header h1').html('Thêm thể loại');
    }
    const name = $(this).data('name');
    if(name){
      $(modalId + ' #name-span').empty();
      $(modalId + ' #name-span').append(name);
    }
  });
});

function showValidateErrorMessage(errors, formId) {
  $("span.error").remove();
  for (var error in errors) {
    $("#" + formId + " #" + error + "-group").addClass("is-invalid");
    $("#" + formId + " #" + error + "-error").append(
      '<span class="error text-danger"> <small>' +
        errors[error][0] +
        "</small></span>"
    );
  }
}

function resetForm(modalId) {
  $("span.error").remove();
  $(".input-group").removeClass("is-invalid");
  $("#" + modalId + " form")[0].reset();
}

function createSuccess(data, e) {
  $("#" + e.target.closest('.modal').getAttribute('id')).modal("hide");
  showMessageToast(data, "bg-gradient-success");
  setTimeout(() => location.reload(), 2000);
}


async function getData(id) {
  await $.ajax({
    url: '/admin/categories/show/' + id,
    type: 'GET',
    processData: false,
    dataType: "json",
    contentType: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: (data) => {
      $.each(data.category, function (key, value) {
        $('#create-update-modal form #' + key + '-input').val(value);
      });
      $('#create-update-modal .modal-header h1').html("Chỉnh sửa thể loại");
      $('#create-update-modal').modal('show');
    },
    error: (xhr) => {
      showMessageToast({status: 0, message: "Đã xảy ra lỗi!"}, "bg-gradient-warning")
    }
  });
};