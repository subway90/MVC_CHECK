<div class="container-fluid section-home d-flex justify-content-center align-items-center">
    <div class="card col-12 col-md-10 col-lg-5 shadow px-3 px-md-5 py-5 rounded-4 border-1 border-primary">
        <h5 class="fw-bold mb-3 text-primary">Kết quả kiểm tra</h5>
        <div class="my-1">
            SĐT Check : <strong><?= $phone_check ?></strong>
        </div>
        <div class="small my-2">
            <?php foreach ($return as $row):
                extract($row); ?>
                <div class="my-4">
                    <div class="d-flex justify-content-between align-items-center my-1">
                        <div class="text-start">
                            <i class="bi bi-person-vcard me-1 text-primary"></i> <?= $full_name ?>
                        </div>
                        <?php if ($check_in): ?>
                            <div class="text-muted text-end">
                                <form action="" method="post">
                                    <span class="me-4 small d-none d-md-inline">
                                        <i class="bi bi-check text-success"></i> <span class="text-muted fst-italic">Đã check-in</span>
                                    </span>
                                    <input type="hidden" name="phone" value="<?= $phone_check ?>">
                                    <input type="hidden" name="detail" value="<?= $order ?>">
                                    <button type="submit" name="check"
                                        class="btn btn-sm btn-outline-primary text-primary border-primary fw-semibold px-2 py-1">
                                        <small>Xem chi tiết</small>
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="text-muted text-end">
                                <form action="" method="post">
                                    <input type="hidden" name="phone" value="<?= $phone_check ?>">
                                    <input type="hidden" name="check_in" value="<?= $order ?>">
                                    <button type="submit" name="check" class="btn btn-sm btn-primary bg-primary border-primary fw-semibold px-2 py-1">
                                        <small>Check-in ngay</small>
                                    </button>
                                </form>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <a href="/" class="btn btn-primary bg-primary border-primary mt-3">
            Tiếp tục kiểm tra
        </a>
    </div>
</div>