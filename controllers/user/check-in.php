<?php

# [VARIABLE]
$_SESSION['update_data'] = [];

# [MODEL]
require 'vendor/autoload.php'; // Tải thư viện Google API

# [HANDEL]

if (isset($_POST['check_in']) && $_POST['check_in'] && isset($_POST['phone']) && $_POST['phone'] && !empty($_SESSION['data'])) {

    // input
    $order_check_in = clear_input($_POST['check_in']);
    $phone = clear_input($_POST['phone']);


    $order_bool = false;
    // đúng sđt check
    if ($phone == $_SESSION['data'][$order_check_in - 2]['phone_check']) {

        // tạo thời gian cập nhật
        $time_update = date('d/m/Y H:i:s');

        // khởi tạo GG Sheets
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig('check-room-455408-fdb296f12ae3.json');
        $client->setAccessType('offline');

        $service = new Google_Service_Sheets($client);

        // Dữ liệu bạn muốn cập nhật
        $values = [
            [
                $time_update
            ],
        ];

        // Phạm vi mà bạn muốn cập nhật
        $range = 'Data!H' . $order_check_in;

        // Tạo đối tượng ValueRange
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        // Cập nhật dữ liệu
        $params = [
            'valueInputOption' => 'RAW' // Hoặc 'USER_ENTERED'
        ];

        try {
            $result = $service->spreadsheets_values->update(SHEET_ID, $range, $body, $params);
            // Thành công
            // Cập nhật thời gian vào session
            $_SESSION['data'][$order_check_in - 2]['check_in'] = DateTime::createFromFormat('d/m/Y H:i:s', $time_update);
            // gán dữ liệu qua để hiển thị
            $_SESSION['update_data'] = $_SESSION['data'][$order_check_in - 2];



        } catch (Exception $e) {
            // echo 'Lỗi: ' . $e->getMessage();
            // báo lỗi
            toast_create('danger', 'Hệ thống đang bị lỗi, vui lòng thử lại sau !');
        }

    } else
        toast_create('danger', 'Cập nhật thất bại vì có sự thay đổi hoặc không chính xác. Vui lòng thử lại !');
}

route();