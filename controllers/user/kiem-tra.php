<?php

# [VARIABLE]


# [HANDLE]
if (isset($_GET['type']) && in_array($_GET['type'], ['agency', 'personal'])) {
    $data = [
        'type_choose' => $_GET['type'],
    ];
    view('user', 'Nhập số điện thoại', 'check_number', $data);
}


# [DATA]
$data = [

];

# [RENDER]
view('user', 'Kiểm tra phòng', 'choose_type', $data);