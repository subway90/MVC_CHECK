<div class="container d-flex justify-content-center align-items-center">
    <div class="card col-4 shadow p-5">
        <h5 class="fw-bold mt-3 text-primary">Kiểm tra thông tin phòng</h5>
        <div class="mb-1 text-muted">
            <strong>Loại kiểm tra :</strong> <?= $type_choose == 'personal' ? 'Cá nhân' : 'Đại lí' ?>
        </div>
        <form action="\ket-qua" method="post">
            <div class="form-floating my-3">
                <input name="phone" type="text" class="form-control" id="phone" placeholder="">
                <label for="phone">Số điện thoại</label>
            </div>
            <button name="check" type="submit" class="btn btn-primary mt-2 w-100">
                Kiểm tra
            </button>
            <div class="text-center mt-3">
                <a class="nav-link" href="\">Quay lại</a>
            </div>
        </form>
    </div>
</div>