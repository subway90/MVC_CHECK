<?php

# [MODEL]
require 'vendor/autoload.php'; // Tải thư viện Google API

# [VARIABLE]
$_SESSION['data'] = [];
$return = [];
$bool_detail = false;

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
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig('check-room-455408-fdb296f12ae3.json'); // Đường dẫn đến tệp JSON
        $client->setAccessType('offline');

        // Tạo đối tượng Google Sheets
        $service = new Google_Service_Sheets($client);

        // Lấy dữ liệu từ bảng
        $response = $service->spreadsheets_values->get(SHEET_ID, 'Data!B2:K');
        $result = $response->getValues();

        if ($result) {
            // format lại data
            foreach ($result as $i => $row) {
                // Lấy SĐT Check
                $phone_check = $row[0];
                // Kiểm tra
                if (!$phone_check)
                    $phone_check = $_SESSION['data'][$i - 1]['phone_check']; // gán giá trị sđt của vị trí trước nó

                // format thời gian check-in
                if (isset($row[7]))
                    $row[7] = DateTime::createFromFormat('d/m/Y H:i:s', $row[7]);
                else
                    $row[7] = null;

                $_SESSION['data'][] = [
                    'order' => $i + 2, // vị trí bắt đầu trong data sheet là dòng 2
                    'phone_check' => $phone_check,
                    'full_name' => $row[1],
                    'type' => $row[2],
                    'phone' => $row[3],
                    'area' => $row[4],
                    'room' => $row[5],
                    'restaurant' => $row[6],
                    'check_in' => $row[7],
                    'represent' => $row[8],
                    'hotline' => $row[9],
                    'map' => null,
                ];

            }

            # [check-in]
            if (isset($_POST['check_in']) && $_POST['check_in']) {

                // input
                $order_check_in = clear_input($_POST['check_in']);
                $phone = clear_input($_POST['phone']);


                $order_bool = false;
                // đúng sđt check
                if ($phone == $_SESSION['data'][$order_check_in - 2]['phone_check']) {

                    // tạo thời gian cập nhật
                    $time_update = date('d/m/Y H:i:s');

                    // khởi tạo GG Sheets
                    $service = new Google_Service_Sheets($client);

                    // Dữ liệu bạn muốn cập nhật
                    $values = [
                        [
                            $time_update
                        ],
                    ];

                    // Phạm vi mà bạn muốn cập nhật
                    $range = 'Data!I' . $order_check_in;

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
                        toast_create('success', 'Đã check-in thành công');
                        // Cập nhật thời gian vào session
                        $_SESSION['data'][$order_check_in - 2]['check_in'] = DateTime::createFromFormat('d/m/Y H:i:s', $time_update);
                        // bật chế độ detail -> gán order vào
                        $bool_detail = $order_check_in;
                    } catch (Exception $e) {
                        toast_create('danger', 'Hệ thống đang bị lỗi, vui lòng thử lại sau !');
                        route();
                    }

                } else {
                    toast_create('danger', 'Cập nhật thất bại vì có sự thay đổi hoặc không chính xác. Vui lòng thử lại !');
                    route();
                }
            }

            # [detail]
            if ($bool_detail || isset($_POST['detail']) && $_POST['detail']) {
                // input
                if ($bool_detail)
                    $order = $bool_detail;
                else
                    $order = clear_input($_POST['detail']);

                // format // giảm 2 đơn vị
                $order -= 2;

                // empty
                if (empty($_SESSION['data'][$order])) {
                    toast_create('danger', 'Không tìm thấy dữ liệu. Vui lòng thử lại !');
                    route();
                }
                // gán dữ liệu
                else
                    $detail = $_SESSION['data'][$order];

                // Lấy số người trong phòng của detail
                foreach ($_SESSION['data'] as $row) {
                    if ($row['room'] == $detail['room'])
                        $array_person_in_room[] = $row;
                }

                // Sắp xếp vị trí theo thời gian tăng dần
                usort($array_person_in_room, function ($a, $b) {
                    if ($a['check_in'] === null && $b['check_in'] === null)
                        return 0; // Nếu cả 2 trống
                    if ($a['check_in'] === null)
                        return 1; // Nếu a trống
                    if ($b['check_in'] === null)
                        return -1; // Nếu b trống
                    return $a['check_in'] <=> $b['check_in']; // Cả 2 đều có dữ liệu, tự so sánh và swap
                });

                // Tìm vị trí trong mảng vừa sort
                $order_checked = '';
                foreach ($array_person_in_room as $i => $row) {
                    if ($row['order'] == $detail['order'])
                        $order_checked = 'Bạn là người thứ ' . ($i + 1) . ' / ' . count($array_person_in_room) . ' đã check in phòng ' . $detail['room'];
                    if ($order_checked)
                        break;
                }

                # [Timeline]
                // Tạo đối tượng Google Sheets
                $service = new Google_Service_Sheets($client);
                // Lấy dữ liệu từ bảng
                $response = $service->spreadsheets_values->get(SHEET_ID, 'Timeline'.$detail['type'].'!A2:C');
                $script = $response->getValues();

                # [Map]
                // Tạo đối tượng Google Sheets
                $service = new Google_Service_Sheets($client);
                // Lấy dữ liệu từ bảng
                $response = $service->spreadsheets_values->get(SHEET_ID, 'Area!A2:B');
                $list_map = $response->getValues();

                if(!empty($list_map)) {
                    foreach ($list_map as $map) if(trim(mb_strtolower($detail['area'],'utf-8')) == trim(mb_strtolower($map[0],'utf-8'))) $detail['map'] = $map;
                }


                //data
                $data = [
                    'detail' => $detail,
                    'script' => $script,
                    'order_checked' => $order_checked,
                ];


                //render
                view('user', 'Chi tiết', 'detail', $data);
            }

            # [list]
            foreach ($_SESSION['data'] as $row) {
                if ($phone == $row['phone_check'])
                    $return[] = $row;
            }

            // empty
            if (empty($return)) {
                toast_create('danger', 'Số điện thoại kiểm tra không tìm thấy !');
                route();
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
view('user', null, 'check', null);