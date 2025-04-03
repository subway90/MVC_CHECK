<?php
# [FILE]
require_once 'autoload.php';

# [LOCK]
if(LOCK_PAGE) controller('user','lock');

# [ACTION]
if (isset($_GET['act']) && $_GET['act']) {
    $_arrayURL = explode('/', $_GET['act']);
    $_action = $_arrayURL[0];
    controller('user',$_action);
}

# [DEFAULT]
controller('user','kiem-tra');