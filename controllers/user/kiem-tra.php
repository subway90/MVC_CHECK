<?php

# [MODEL]
require 'vendor/autoload.php'; // Tải thư viện Google API

# [VARIABLE]
$_SESSION['data'] = [];
$return = [];

# [HANDLE]
if (isset($_POST['check'])) {
    // Input
    if (isset($_POST['phone']))
        $phone = clear_input($_POST['phone']);

    // Validate
    if (!$phone)
        toast_create('danger', 'Vui lòng nhập số điện thoại');

    // Query
    else {
        // Khởi tạo Google Client
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig('check-room-455408-fdb296f12ae3.json'); // Đường dẫn đến tệp JSON
        $client->setAccessType('offline');

        // Tạo đối tượng Google Sheets
        $service = new Google_Service_Sheets($client);

        // Lấy dữ liệu từ bảng
        $response = $service->spreadsheets_values->get(SHEET_ID, 'Data!B2:G');
        $result = $response->getValues();

        if ($result) {
            // format lại data
            foreach ($result as $i => $row) {
                // Lấy SĐT Check
                $phone_check = $row[0];
                // Kiểm tra
                if (!$phone_check)
                    $phone_check = $_SESSION['data'][$i - 1]['phone_check'];

                $_SESSION['data'][] = [
                    'order' => $i,
                    'phone_check' => $phone_check,
                    'full_name' => $row[1],
                    'phone' => $row[2],
                    'area' => $row[3],
                    'room' => $row[4],
                    'restaurant' => $row[5],
                ];

            }

            // detail
            if (isset($_POST['detail']) && $_POST['detail']) {
                // input
                $order = clear_input($_POST['detail']);

                // giảm 1 (vì đã cộng bên input value -> tránh lỗi null value)
                --$order;

                //validate
                if (empty($_SESSION['data'][$order]))
                    route('/');

                //render
                view('user', 'Chi tiết', 'detail', ['detail' => $_SESSION['data'][$order]]);
            }

            // filter
            foreach ($_SESSION['data'] as $row) {
                if ($phone == $row['phone_check'])
                    $return[] = $row;
            }

            // empty
            if (!$return) {
                toast_create('danger', 'Số điện thoại kiểm tra không tìm thấy !');
                route('/');
            }

            // Result
            $data = [
                'phone_check' => $phone,
                'return' => $return,
            ];

            // Render
            view('user', 'Kết quả', 'result', $data);
        } else
            toast_create('danger', 'Hệ thống dữ liệu không tồn tại ! Liên hệ ADMIN để hỗ trợ !');
    }


}

# [RENDER]
view('user', 'Kiểm tra phòng', 'check', null);