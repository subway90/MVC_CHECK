<?php

const _s_me_error = '<div style="color:red">PHÁT HIỆN LỖI:</div><div style="margin-left:10px">';
const _e_me_error = '</div>';

/**
 * Dùng để xác nhận quyền xác thực theo custom role
 * 
 * Chỉ cần gọi tên role hoặc mảng role là dùng được
 * 
 * @param mixed $type Loại author cần xác thực
 * @return void
 */
function author($type)
{
    $author = false; // trạng thái author
    $array_type = [];
    // kiểm tra đã đăng nhập chưa
    if (!empty($_SESSION['user'])) {
        // tạo thành mảng nếu là chuỗi
        if (!is_array($type))
            $array_type[] = $type;
        else
            $array_type = $type;
        // so sánh phần tử của mảng author yêu cầu với author hiện tại của user
        foreach ($array_type as $type) {
            if ($_SESSION['user']['name_role'] == $type)
                $author = true;
        }
    }
    if (!$author)
        view_error(401);
}

/**
 * Kiểm tra đã đăng nhập hay chưa, nếu chưa đăng nhập sẽ trả về FALSE, ngược lại sẽ trả về TRUE
 * @return bool
 */
function is_login()
{
    if (!empty($_SESSION['user']))
        return true;
    return false;
}

/**
 * Lấy thông tin của một user thông qua param
 * 
 * Trả về FALSE nếu dữ liệu trống hoặc không tồn tại
 * 
 * @param string $param Thông tin cần lấy
 * 
 * @return mixed
 */
function auth($param)
{
    if (empty($_SESSION['user']))
        return false;
    elseif ($param == 'all')
        return $_SESSION['user'];
    elseif (!isset($_SESSION['user'][$param]))
        die(_s_me_error . 'Không tồn tại param ' . $param . ' trong session user' . _e_me_error);
    else
        return $_SESSION['user'][$param];
}

/**
 * Load view từ views/user
 * @param string $title Tiêu đề trang
 * @param string $page Tên file view cần load
 * @param $data Mảng dữ liệu
 */
function view($type, $title, $page, $data)
{
    if ($type != 'admin' && $type != 'user')
        die(_s_me_error . 'Type khai báo <strong>' . $type . '</strong> không phù hợp trong mảng [user,admin] ' . _e_me_error);
    if (file_exists('views/' . $type . '/' . $page . '.php')) {
        if (!empty($data))
            extract($data);
        require_once 'models/' . $type . '/header.php';
        require_once 'views/' . $type . '/layout/header.php';
        require_once 'views/' . $type . '/' . $page . '.php';
        require_once 'views/' . $type . '/layout/footer.php';
        exit;
    } else {
        die(_s_me_error . 'Trang view <strong>' . $page . '.php</strong> mà bạn khai báo không được tìm thấy tại :<br> <strong>path : views/' . $type . '/' . $page . '.php</strong>' . _e_me_error);
    }
}

/**
 * Load model theo loại [user,admin]
 * @param string $type Loại model [user,admin]
 * @param string $name_model Tên model cần gọi ra
 * @return void
 */
function model($type, $name_model)
{
    if ($type != 'admin' && $type != 'user')
        die(_s_me_error . 'Type khai báo <strong>' . $type . '</strong> không phù hợp trong mảng [user,admin] ' . _e_me_error);
    if (file_exists('models/' . $type . '/' . $name_model . '.php')) {
        require_once 'models/' . $type . '/' . $name_model . '.php';
    } else {
        die(_s_me_error . 'Model <strong> ' . $name_model . '</strong> mà bạn khai báo không được tìm thấy tại :<br> <strong>path : models/' . $type . '/' . $name_model . 'php</strong>' . _e_me_error);
    }
}


/**
 * Hàm này dùng để hiển thị lỗi trạng tháu
 * 
 * Lưu ý : Hiện tại chỉ có 2 mã lỗi [401,404] là hoạt động
 * 
 * @param int $code Mã trạng thái trang 
 * @return void
 */
function view_error($code)
{
    http_response_code($code);
    require_once 'page_error/' . $code . '.php';
    exit();
}

/**
 * Lồng layout vào trong một view
 * 
 * @param string $type Folder layout [user,admin]
 * @param string $layout Tên layout
 */
function layout($type, $layout)
{
    if ($type != 'admin' && $type != 'user')
        die(_s_me_error . 'Type khai báo <strong>' . $type . '</strong> không phù hợp trong mảng [user,admin] ' . _e_me_error);
    if (file_exists('views/' . $type . '/layout' . '/' . $layout . '.php')) {
        if (!empty($data))
            extract($data);
        require 'views/' . $type . '/layout' . '/' . $layout . '.php';
    } else
        die(_s_me_error . 'Trang layout <strong>' . $type . '/layout' . '/' . $layout . '.php</strong> mà bạn khai báo không được tìm thấy' . _e_me_error);
}

function alert($content)
{
    echo '<script>alert("' . $content . '")</script>';
}

/**
 * Hàm tạo token ngẫu nhiên theo độ dài tùy ý trong phạm vi [a-z][A-Z][0-9]
 * @param int $length độ dài kí tự token (0-100)
 */
function create_token($length)
{
    if ($length <= 0)
        return "[ERROR] length not valid";
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, $length);
}

/**
 * Hàm này dùng để loại bỏ dấu của chuỗi
 * @param string $input Chuỗi cần loại bỏ dấu
 */
function create_slug($input)
{
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', #1
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',#2
        '#(ì|í|ị|ỉ|ĩ)#',#3
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',#4
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',#5
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',#6
        '#(đ)#',#7
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',#8
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',#9
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',#10
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',#11
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',#12
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',#13
        '#(Đ)#',#14
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',#1
        'e',#2
        'i',#3
        'o',#4
        'u',#5
        'y',#6
        'd',#7
        'A',#8
        'E',#9
        'I',#10
        'O',#11
        'U',#12
        'Y',#13
        'D',#14
        '-',#15
    );
    $input = preg_replace($search, $replace, $input);
    $input = preg_replace('/(-)+/', '-', $input);
    return $input;
}

/**
 * Hàm này dùng để định dạng hiển thị thời gian
 * @param $input Nhập thời gian cần FORMAT, [YYYY-MM-DD hh:mm:ss]
 * @param $format Nhập biểu thức muốn hiển thị. Ví dụ 'Lúc hh:mm ngày DD/MM/YYYY'
 */
function format_time($input, $format)
{
    if (strtotime($input) !== false && similar_text($input, '- - : :') == 5) { #kiểm tra $input nhập vào có hợp lệ không | hàm strtotime: trả về số giây(int) đếm được kể từ ngày 1/1/1976 -> thời gian input
        $arr = explode(' ', $input); #YYYY-MM-DD hh:mm:ss -> [0] YYYY-MM-DD [1] hh:mm:ss
        $arr_time = explode('-', $arr[0]); //arr_time[0] YYYY [1] MM [2] DD
        $arr_day = explode(':', $arr[1]);  //arr_day[0] hh [1] mm [2] ss
        return str_replace(['hh', 'mm', 'ss', 'YYYY', 'MM', 'DD'], [$arr_day[0], $arr_day[1], $arr_day[2], $arr_time[0], $arr_time[1], $arr_time[2]], $format);
    } else
        return 'Thời gian nhập vào chưa đúng form YYYY-MM-DD hh:mm:ss';
}

/**
 * Hàm trả về IP Address của người dùng
 */
function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * Dùng để trả về các thông số của $_SERVER
 * @return array
 */
function test_server()
{
    echo '<pre>';
    print_r($_SERVER);
    echo '</pre>';
    exit;
}

/**
 * Dùng để trả về các thông số của $array
 * @param $array Mảng cần hiển thị
 * @return array
 */
function test_array($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    exit;
}

/**
 * Dùng để trả về các thông số của $input
 * @param $input Giá trị cần hiển thị
 * @return mixed
 */
function test($input)
{
    var_dump($input);
    exit;
}


/**
 * Hàm này dùng để chuyển đến case theo yêu cầu.
 * 
 * @param string $case Tên route muốn chuyển đến
 */
function route($case)
{
    header('Location:' . URL . $case);
    exit;
}

/**
 * Hàm dùng để tạo toast
 * @param string $type Loại background [danger,warning,success]
 * @param string $message Tin nhắn cần thông báo
 */
function toast_create($type, $message)
{
    $_SESSION['toast'][0] = $type;
    $_SESSION['toast'][1] = $message;
}

/**
 * Dùng để show toast (Thường để ở header layout)
 * @return void
 */
function toast_show()
{
    if (!empty($_SESSION['toast'])) {
        echo '
        <style>
        .line-bar {
            height: 2px;
            animation: lmao ' . (TOAST_TIME / 1000) . 's linear forwards;
        }
        @keyframes lmao {
            from {
              width: 100%;
            }
            to {
              width: 0;
            }
          }      
        </style>
        <div style="z-index: 9999;" class="position-fixed end-0 me-1 mt-5 pt-5">
            <div class="w-100 alert alert-' . $_SESSION['toast'][0] . ' border-0 alert-dismissible fade show m-0 rounded-0" role="alert">
                <span class="ps-2 pe-5 py-2">' . $_SESSION['toast'][1] . '</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="bg-' . $_SESSION['toast'][0] . ' line-bar"></div>
        </div>
        <script>
            function closeAlert() {
                document    .querySelector(".btn-close").click();
            }
            setTimeout(closeAlert,' . TOAST_TIME . ')
        </script>';
    }
    unset($_SESSION['toast']);
}

/**
 * Làm sạch các kí tự tránh SQL Injection
 * @param string $input
 * @return array|string|null
 */
function clear_input($input)
{
    // Chuyển đổi các kí tự đặc biệt thành mã code HTML
    return filter_var($input, FILTER_SANITIZE_STRING);
}

/**
 * Hàm này dùng để lưu file
 * 
 * Lưu ý: Nếu để false $encrypt_bool, thì file trùng tên sẽ thêm hậu tố -copy
 * 
 * @param bool $encrypt_bool Có cần mã hoá tên hay không
 * @param string $folder Thư mục lưu file ( tiền tố assets/file/ )
 * @param mixed $file File cần lưu
 * @return string Trả về đường dẫn đã lưu nếu lưu thành công, trả về 0 nếu lưu thất bại
 */
function save_file($bool_encrypt, $folder, $file)
{
    // Kiểm tra thư mục tồn tại chưa
    if (!is_dir('assets/file/' . $folder))
        die(_s_me_error . 'Thư mục asset/file/' . $folder . ' chưa được tạo khi dùng hàm save_file' . _e_me_error);
    if ($bool_encrypt) {
        // Mã hoá tên file
        $file['name'] = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    } else {
        // Kiểm tra file đã tồn tại chưa, nếu có thì thêm hậu tố -copy
        if (file_exists('assets/file/' . $folder . '/' . $file["name"]))
            $file['name'] = pathinfo($file['name'], PATHINFO_FILENAME) . '-copy.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    }
    // Tiến hành lưu
    $check = move_uploaded_file($file["tmp_name"], 'assets/file/' . $folder . '/' . basename($file["name"]));
    // Trả về path đã lưu
    if ($check)
        return $folder . '/' . $file['name'];
    return 0;
}

/**
 * Hàm này dùng để xoá file theo PATH
 * @param mixed $path Đường dẫn file cần xoá
 */
function delete_file($path)
{
    if (file_exists('assets/file/' . $path))
        (unlink('assets/file/' . $path));
    else
        die(_s_me_error . ' File không được tìm thấy để xoá. Path file: ' . 'assets/file/' . $path . _e_me_error);
}

/**
 * Tạo mã ngẫu nhiên độ dài 24, thích hợp cho làm id
 * @return string
 */
function create_uuid()
{
    // Tạo một chuỗi ngẫu nhiên
    $data = random_bytes(16);
    // Đặt giá trị phiên bản (4 cho UUID ngẫu nhiên)
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Phiên bản 4
    // Đặt giá trị variant (2 cho RFC 4122)
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    // Chuyển đổi thành UUID
    return vsprintf('%s-%s-%s-%s-%s', str_split(bin2hex($data), 4));
}

/**
 * Hàm này để trả dữ liệu dạng JSON
 * @param int $status
 * @param array $data
 * @return void
 */
function view_json($status, $data)
{
    header('Content-Type: application/json');
    $data = array_merge(['status' => $status], $data);
    echo json_encode($data);
    exit;
}

/**
 * Hàm này dùng để in ra mảng lỗi validate
 * @param $array mảng lỗi
 * @return void
 */
function show_error($array)
{
    if (!empty($array)) {
        foreach ($array as $error)
            echo '<div class="text-danger small mb-2"><i class="fas fa-exclamation-triangle me-2"></i>' . $error . '</div>';
    }
}

/**
 * Hàm này dùng để tự động đăng nhập khi vừa truy cập trình duyệt
 * @return void
 */
function auto_login()
{
    // Nếu chưa đăng nhập
    if (!is_login()) {
        // nếu có cookie token_remember
        if (isset($_COOKIE['token_remember']))
            $token_remember = clear_input($_COOKIE['token_remember']);
        else
            $token_remember = '';
        // nếu có value
        if ($token_remember) {
            // lấy thông tin user bằng token
            $get_user = pdo_query_one(
                'SELECT u.*, r.name_role
                FROM user u
                JOIN role r
                ON u.id_role = r.id_role
                WHERE u.deleted_at IS NULL
                AND u.token_remember = "' . $token_remember . '"'
            );
            // nếu lấy thông tin thành công
            if ($get_user) {
                // gán dữ liệu cho session
                $_SESSION['user'] = $get_user;
                // thông báo toast
                toast_create('success', 'Chào mừng bạn quay trở lại ' . WEB_NAME);
            }
        }
    }
}

/**
 * Tạo toast để thông báo
 * 
 * Lưu ý: Chỉ trả về, phải dùng lệnh echo
 * 
 * @param string $type Loại màu toast
 * @param string $message Nội dung thông báo
 * @return string Đoạn script thông báo toast
 */
function toast($type, $message)
{
    return '
        <style>
        .line-bar {
            height: 2px;
            animation: lmao ' . (TOAST_TIME / 1000) . 's linear forwards;
        }
        @keyframes lmao {
            from {
              width: 100%;
            }
            to {
              width: 0;
            }
          }      
        </style>
        <div style="z-index: 9999;" class="position-fixed end-0 me-1 mt-5 pt-5">
            <div class="w-100 alert alert-' . $type . ' border-0 alert-dismissible fade show m-0 rounded-0" role="alert">
                <span class="ps-2 pe-5 py-2">' . $message . '</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="bg-' . $type . ' line-bar"></div>
        </div>
        <script>
            function closeAlert() {
                document    .querySelector(".btn-close").click();
            }
            setTimeout(closeAlert,' . TOAST_TIME . ')
        </script>';
}

/**
 * Lấy action của request uri
 * 
 * @param mixed $order Thứ tự phần tử cần lấy, hoặc để string('test') để lấy toàn bộ
 */
function get_action_uri($order)
{
    if (isset($_GET['act'])) {
        $array_uri = explode('/', $_GET['act']); // tạo mảng bởi dấu phân cách "/"
        if ($order === 'test')
            return $array_uri;
        else if (!empty($array_uri[$order]))
            return $array_uri[$order];
    }
    return false;
}