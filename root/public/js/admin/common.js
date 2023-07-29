$(document).ready(() => {
    $(".btn-close-toast").on("click", (e) => {
        var toast = e.target.parentElement.parentElement.id;
        $('#' + toast).fadeOut('300', () => resetmessageToast());
    });
});
function resetImage() {
    var parent = $('.uploadFile');
    parent.find('.ipt-avatar').val('');
    parent.find('input[name="avatar_old"]').val('');
    parent.find('img').attr('src', '');
    $('.uploadFile, .wrapper').removeClass('active');
    $('.uploadFile_content ').removeClass('d-none');
}
function resetmessageToast() {
    $('#messageToast').children('.toast-header')[0].classList.remove("bg-gradient-warning");
    $("#messageToast > .toast-header > strong")[0].innerHTML = '';
    $('#messageToast').children('.toast-body')[0].innerHTML = '';
}

function showMessageToast(data, bg, timeReset = 2000) {
    resetmessageToast();
    $(".toast-header").addClass(bg);
    $(".toast-header > strong").append(((data.status === 1) ? 'Thành công!' : 'Thất bại!'));
    $(".toast-body").append(
        "<p><strong>" + data.message + "</p>"
    );
    $('#messageToast').fadeIn();
    setTimeout(() => $('#messageToast').fadeOut('300', () => resetmessageToast()), timeReset);
}

function scrollTopPaginate() {
    $('html, main').animate({ scrollTop: 0 }, 800);
}
const keyCode = 13;
// bắt sự kiện khi ngừoi dùng nhập dữ liệu ô input hoặc chọn select bấm enter sẽ chặn tự động submit form
$("input, select").on("keypress keydown", function (event) {
    if (event.keyCode === keyCode) {
        event.preventDefault();
    }
});