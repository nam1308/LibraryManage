$(document).ready(function() {
    $('.uploadFile_btn').on('click', function() {
        var parent = $(this).closest('.uploadFile');
        parent.find('.ipt-avatar').click();
        parent.find('.ipt-avatar').on('change', function() {
            var parentimg = $(this).closest('.uploadFile');
            if (this.files[0]) {
                var reader = new FileReader();
                reader.onload = function () {
                    var result = reader.result;
                    parentimg.find('img').attr('src', result);
                    parentimg.find('.wrapper').addClass('active');
                };
                reader.readAsDataURL(this.files[0]);
                parentimg.find('input[name="avatar_old"]').val(parentimg.find('input[name="image"]').val());
                parentimg.addClass('active');
            }
            $('#avatar-error').text('');
            $('#avatar_err').text('');
        });
    });
});
