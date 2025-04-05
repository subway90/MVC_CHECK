<div class="section-home container-fluid justify-content-center">
    <div class="d-flex flex-column justify-content-lg-end justify-content-center align-items-center pt-5 gap-lg-2 gap-5">
        <div class="col-12 col-lg-7 text-center">
            <img class="w-75" src="<?= URL_STORAGE ?>system/bg_brand.png" alt="bg_brand.png">
        </div>
        <div class="col-12 col-lg-7 text-center">
            <img class="w-75" src="<?= URL_STORAGE ?>system/bg_name_event.png" alt="bg_brand.png">
        </div>
    </div>
</div>

<div class="section-detail container-fluid py-5 d-flex flex-column justify-content-center align-items-center">
    <h1 class="text-uppercase text-primary display-6 mb-4">
        khởi nguyên vô cực
    </h1>

    <div class="col-lg-7 col-12 section-sm bg-primary rounded-4 p-3 mb-3">
        <div class="text-start text-light fs-2 mb-5">
            10 - 11/04
        </div>
        <div class="text-end text-uppercase text-light fs-2 mt-5">
            flamingo đại lải
        </div>
    </div>

    <div class="position-relative col-lg-7 col-12 card border-2 rounded-4 border-primary mt-5 mb-3 p-3 gap-3 pt-5">
        <div class="position-absolute top-0 start-0 label-form bg-primary text-light text-uppercase fs-6 py-2 px-4 rounded-3">
            thông tin khách hàng
        </div>

        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Họ tên :
            </div>
            <div class="text-end">
                <?= $detail['full_name'] ?>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Số điện thoại :
            </div>
            <div class="text-end">
                <?= $detail['phone'] ?>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Khu vực :
            </div>
            <div class="text-end">
                <?= $detail['area'] ?>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Số phòng :
            </div>
            <div class="text-end">
                <?= $detail['room'] ?>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Nhà hàng ăn trưa :
            </div>
            <div class="text-end">
                <?= $detail['restaurant'] ?>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Đại diện liên hệ Casper :
            </div>
            <div class="text-end">
                <?= $detail['represent'] ?>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="small">
                Hotline hỗ trợ :
            </div>
            <div class="text-end">
                <?= $detail['hotline'] ?>
            </div>
        </div>
    </div>

    <div style="height: 500px" class="position-relative col-lg-7 col-12 card border-2 rounded-4 border-primary mt-5 p-3 pt-5">
        <div class="position-absolute top-0 start-0 label-form bg-primary text-light text-uppercase fs-6 py-2 px-4 rounded-3">
            sơ đồ khu vực của bạn
        </div>
        <iframe src="https://drive.google.com/file/d/13R6QRu_k5OlYN3RO7SksMuU8IMQ2ADrk/preview" height="100%" width="100%" allow="autoplay"></iframe>
    </div>

</div>

<div class="container-fluid p-0 text-center">
    <img src="https://i.postimg.cc/J098NzNT/timeline-1.png" width="100%">
</div>

<div class="container-fluid p-0 text-center">
    <img src="<?= URL_STORAGE ?>system/bg_section_1.png" width="100%">
</div>