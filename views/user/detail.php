<div class="container d-flex flex-column justify-content-center align-items-center py-5">
    <div class="card col-12 col-md-10 col-lg-5 shadow px-3 px-md-5 py-5">
        <h5 class="fw-bold mb-3 text-primary">Thông tin khách hàng</h5>
        <table class="table tabl-bordered table-hover my-2 small">
            <tr>
                <th class="fw-bold">
                    Họ tên
                </th>
                <td class="text-end">
                    <?= $detail['full_name'] ?>
                </td>
            </tr>
            <tr>
                <th class="fw-bold">
                    SĐT
                </th>
                <td class="text-end">
                    <?= $detail['phone'] ?>
                </td>
            </tr>
            <tr>
                <th class="fw-bold">
                    Khu vực
                </th>
                <td class="text-end">
                    <?= $detail['area'] ?>
                </td>
            </tr>
            <tr>
                <th class="fw-bold">
                    Số phòng
                </th>
                <td class="text-end">
                    <?= $detail['room'] ?>
                </td>
            </tr>
            <tr>
                <th class="fw-bold">
                    Nhà hàng ăn trưa
                </th>
                <td class="text-end">
                    <?= $detail['restaurant'] ?>
                </td>
            </tr>
            <tr>
                <th class="fw-bold">
                    Đại diện liên hệ Casper
                </th>
                <td class="text-end">
                    <?= $detail['represent'] ?>
                </td>
            </tr>
            <tr>
                <th class="fw-bold">
                    Hotline hỗ trợ
                </th>
                <td class="text-end">
                    <?= $detail['hotline'] ?>
                </td>
            </tr>
        </table>
    </div>

    <div style="height: <?= $detail['map'] ? '500px' : '' ?> " class="card col-12 col-md-10 col-lg-5 shadow px-3 px-md-5 py-5 mt-4">
        <h5 class="fw-bold mb-3 text-primary">Sơ đồ khu vực của bạn</h5>
        <?php if($detail['map']): ?>
            <iframe src="<?= str_replace('view?usp=drive_link','preview',$detail['map'][1]) ?>" height="100%" width="100%" allow="autoplay"></iframe>
        <?php else : ?>
            <div class="text-center text-muted fw-light">Bản đồ của khu vực này chưa có ! Vui lòng thử lại sau</div>
        <?php endif ?>
    </div>

    <div class="card col-12 col-md-10 col-lg-5 shadow px-3 px-md-5 py-5 mt-4">
        <h5 class="fw-bold mb-3 text-primary">Timeline chương trình</h5>
        <table class="table tabl-bordered table-hover my-2 small" style="height: 200px; overflow-y : auto">
            <?php foreach($script as $row) : ?>
            <tr>
                <th class="fw-bold">
                    <?= $row[1] ?>
                </th>
                <td class="text-end">
                    <?= $row[2] ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>

    <a href="/" class="btn btn-primary col-12 col-md-10 col-lg-5 shadow px-3 my-4">
        Tiếp tục kiểm tra
    </a>
        
</div>