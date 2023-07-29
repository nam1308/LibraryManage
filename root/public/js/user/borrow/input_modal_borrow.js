document.getElementById("formBorrowBook").addEventListener("submit", function(event) {
  var quantityInput = document.getElementById("quantityInput");
  var quantityError = document.getElementById("quantityError");
  // Kiểm tra điều kiện và hiển thị lỗi nếu cần
  if (quantityInput.value != 1) {
    quantityError.textContent = "Số lượng tối đa là 1 cuốn!";
    quantityError.style.display = "block";
    // Ngăn chặn gửi form submit
    event.preventDefault();
  } else {
    quantityError.textContent = "";
    quantityError.style.display = "none";
  }
});