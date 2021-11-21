<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_signup\Beck_signup_actions;
use XoopsModules\Beck_signup\Beck_signup_data;

require_once __DIR__ . '/header.php';

if (!$_SESSION['can_add']) {
    redirect_header($_SERVER['PHP_SELF'], 3, "您沒有權限使用此功能");
}

$id = Request::getInt('id');
$type = Request::getString('type');
$action = Beck_signup_actions::get($id);

if ($action['uid'] != $xoopsUser->uid()) {
    redirect_header($_SERVER['PHP_SELF'], 3, "您沒有權限使用此功能");
}

$csv = [];
$head = Beck_signup_data::get_head($action);
$csv[] = implode(',', $head);

if ($type == 'signup') {
    $signup = Beck_signup_data::get_all($action['id']);
    // Utility::dd($signup);
    foreach ($signup as $signup_data) {
        $item = [];
        foreach ($signup_data['tdc'] as $user_data) {
            $item[] = implode('|', $user_data);
        }

        if ($signup_data['accept'] === '1') {
            $item[] = '錄取';
        } elseif ($signup_data['accept'] === '0') {
            $item[] = '未錄取';
        } else {
            $item[] = '尚未設定';
        }
        $item[] = $signup_data['signup_date'];
        $item[] = $signup_data['tag'];

        $csv[] = implode(',', $item);
    }
}





$content = implode("\n", $csv);
$content = mb_convert_encoding($content, 'Big5');
// die(var_dump($content));

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename= {$action['title']}報名名單.csv");
echo $content;
exit;
