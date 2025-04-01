<div class="container d-flex justify-content-center align-items-center">
    <div class="card col-12 col-md-10 col-lg-4 shadow px-3 px-md-5 py-5">
        <h5 class="fw-bold mb-3 text-primary">Chi tiết</h5>
        <div class="small my-2">
            <div class="">
                <div class="d-flex justify-content-between align-items-between mb-2">
                    <div class="fw-bold">
                        Họ và tên
                    </div>
                    <div class="">
                        <?= $detail['full_name'] ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-between mb-2">
                    <div class="fw-bold">
                        Số điện thoại
                    </div>
                    <div class="">
                        0<?= $detail['phone'] ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-between mb-2">
                    <div class="fw-bold">
                        Khu vực
                    </div>
                    <div class="">
                        <?= $detail['area'] ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-between mb-2">
                    <div class="fw-bold">
                        Số phòng
                    </div>
                    <div class="">
                        <?= $detail['room'] ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-between mb-2">
                    <div class="fw-bold">
                        Nhà hàng
                    </div>
                    <div class="">
                        <?= $detail['restaurant'] ?>
                    </div>
                </div>
                <?php if ($detail['check_in']): ?>
                    <div class="d-flex justify-content-between align-items-between mb-2">
                        <div class="fw-bold">
                            Thời gian check-in
                        </div>
                        <div class="">
                            <?= $detail['check_in']->format('d/m/Y H:i:s') ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-between mb-2">
                        <div class="fw-bold text-center">
                            <?= $order_checked ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <a href="/" class="btn btn-primary mt-3">
            Tiếp tục kiểm tra
        </a>
    </div>
</div>