$(document).ready(function() {
    const dropArea = $(".drag-area");
    const input = $("#importFileUpload");

    dropArea.on("click", function(e) {
        if (e.target !== input[0] && !$(e.target).hasClass("btn-delete")) {
            if (!input.val()) {
                input.click();
            }
        }
    });

    input.on("change", function() {
        const file = this.files[0];
        if (file && file.type === "text/csv") {
            dropArea.addClass("active");
            const fileInfo = dropArea.find(".file-info");
            fileInfo.find("span").text(file.name);
            $('#fileCsv_err').text('');
        } else {
            alert("Vui lòng chọn một tệp tin CSV.");
            input.val("");
        }
    });

    dropArea.on("dragover", function(event) {
        event.preventDefault();
        dropArea.find(".text-content").text("Thả tệp vào đây");
        dropArea.addClass("drag-drop");
        const allowedTypes = ["text/csv"];
        const file = event.originalEvent.dataTransfer.files[0];
        if (file && allowedTypes.includes(file.type)) {
            dropArea.addClass("active");
        }
    });

    dropArea.on("dragleave", function(event) {
        event.preventDefault();
        dropArea.find(".text-content").text("Kéo và thả hoặc click để chọn tệp");
        const allowedTypes = ["text/csv"];
        const file = event.originalEvent.dataTransfer.files[0];
        if (!file || !allowedTypes.includes(file.type)) {
            dropArea.removeClass("active");
            dropArea.removeClass("drag-drop");
            dropArea.find(".text-content").text("Kéo và thả hoặc click để chọn tệp");
        }
    });

    dropArea.on("drop", function(event) {
        event.preventDefault();
        const file = event.originalEvent.dataTransfer.files[0];
        if (file && file.type === "text/csv") {
            input[0].files = event.originalEvent.dataTransfer.files;
            dropArea.addClass("active");
            const fileInfo = dropArea.find(".file-info");
            fileInfo.find("span").text(file.name);
            dropArea.removeClass("drag-drop");
            $('#fileCsv_err').text('');
        } else {
            alert("Vui lòng chọn một tệp tin CSV.");
            input.val("");
            dropArea.find(".text-content").text("Kéo và thả hoặc click để chọn tệp");
            dropArea.removeClass("drag-drop");
        }
    });

    $(".btn-delete, .importFile").on("click", function (){
        closeFile(input, dropArea);
    });

    // Sự kiện click nút import file
    $('#import-form-book').submit(function (event) {
        event.preventDefault();
        const formData = new FormData($(this)[0]);
        $.ajax({
            url: '/admin/books/import-csv',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.status) {
                    showMessageToast(response, "bg-success");
                    setTimeout(()=> location.reload(), 2000);
                } else {
                    const errors = response.message;
                    if (Array.isArray(errors)) {
                        errors.sort((a, b) => a.row - b.row);
                        let messages = ``;
                        errors.forEach((error) => {
                            messages += `Lỗi dòng ${error?.row}: ${error?.errors[0]}<br>`;
                        });
                        showMessageToast({message: messages}, "bg-warning", 20000);
                    }
                    else showMessageToast(response, "bg-warning");
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        $('#' + key + '_err').text(errors[key][0]);
                    }
                }
            },
        });
    });

});

function closeFile(input, dropArea){
    input.val("");
    dropArea.removeClass("active");
    dropArea.find(".text-content").text("Kéo và thả hoặc click để chọn tệp");
    dropArea.find(".file-info span").text("");
    dropArea.removeClass("drag-drop");
}