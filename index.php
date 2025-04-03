<?php
# [FILE]
require_once 'autoload.php';

if(LOCK_PAGE) require_once 'controllers/user/lock.php';

# [ACTION]
if (isset($_GET['act']) && $_GET['act']) {
    // hàm explode : tạo mảng bởi dấu phân cách
    $_arrayURL = explode('/', $_GET['act']);
    // lấy action
    $_action = $_arrayURL[0];
    if (file_exists('controllers/user/' . $_action . '.php'))
        require_once 'controllers/user/' . $_action . '.php';
    else
        return view_error(404);
}
// Trường hợp không có action
else
    require_once 'controllers/user/kiem-tra.php';