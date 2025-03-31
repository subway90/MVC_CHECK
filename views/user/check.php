<div class="container d-flex justify-content-center align-items-center">
    <div class="card col-12 col-lg-4 shadow p-5">
        <h5 class="fw-bold my-3 text-primary">Kiểm tra thông tin phòng</h5>
        <div class="text-muted mb-2">
            Bạn thuộc khách hàng :
        </div>
        <form action="" method="post" class="form">
            <div class="d-flex flex-column flex-lg-row justify-content-around gap-3 px-lg-2 my-lg-3">
                <div class="form-check p-0 col-12 col-lg-6">
                    <input class="form-check-input" type="radio" value="personal" name="typeCheck" id="typeCheck1">
                    <label class="form-check-label d-block text-center px-2 py-3" for="typeCheck1">
                        Cá nhân
                    </label>
                </div>
                <div class="form-check p-0 col-12 col-lg-6">
                    <input class="form-check-input" type="radio" value="agency" name="typeCheck" id="typeCheck2">
                    <label class="form-check-label d-block text-center px-2 py-3" for="typeCheck2">
                        Đại lí
                    </label>
                </div>
            </div>
            <div class="field-phone">
                <div class="form-floating my-3">
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="">
                    <label for="phone">Số điện thoại</label>
                </div>
                <button name="check" type="submit" class="btn btn-primary mt-2 w-100">
                    Kiểm tra
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const radioButtons = document.querySelectorAll('input[name="typeCheck"]');
    const fieldPhone = document.querySelector('.field-phone');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.checked) {
                fieldPhone.classList.add('show'); // Thêm class show để hiển thị với animation
            }
        });
    });
</script>