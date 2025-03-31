<div class="container d-flex justify-content-center align-items-center">
    <div class="card col-4 shadow p-5">
        <h5 class="fw-bold mb-3 text-primary">Kết quả kiểm tra</h5>
        <?php if ($return): ?>
            <div class="my-1">
                <div class="">
                    SĐT Check : <strong>0<?= $return[0]['phone_check'] ?></strong>
                </div>
                <div class="">
                    Số lượng người : <strong><?= count($return) ?></strong>
                </div>
            </div>
            <div class="small my-2">
                <?php foreach ($return as $row):
                    extract($row); ?>
                    <div class="my-4">
                        <div class="d-flex justify-content-between align-items-center my-1">
                            <div class="text-start">
                                <i class="bi bi-person-vcard me-1 text-primary"></i> <?= $full_name ?>
                            </div>
                            <div class="text-muted text-end">
                                <form action="" method="post">
                                    <input type="hidden" name="phone" value="<?= $phone_check ?>">
                                    <input type="hidden" name="detail" value="<?= $order ?>">
                                    <button type="submit" name="check" class="btn btn-sm btn-primary fw-semibold px-2 py-1">
                                        <small>Xem chi tiết</small>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="text-center text-muted fst-italic">
                Không có kết quả
            </div>
        <?php endif ?>
        <a href="/" class="btn btn-primary mt-3">
            Tiếp tục kiểm tra
        </a>
    </div>
</div>