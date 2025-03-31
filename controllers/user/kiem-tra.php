<?php

# [VARIABLE]


# [HANDLE]
if (isset($_POST['check'])) {
    // Input

    // Validate

    // Query

    // Result
    $data = [
        'type_choose' => $_POST['typeCheck'],
    ];
    // Render
    view('user', 'Kết quả', 'result', $data);
}


# [DATA]
$data = [

];

# [RENDER]
view('user', 'Kiểm tra phòng', 'check', $data);