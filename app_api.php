<?php
use Xmf\Request;
use XoopsModules\Beck_signup\Beck_signup_api;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$token = Request::getString('token');
$action_id = Request::getInt('action_id');

$api = new Beck_signup_api($token);

switch ($op) {
    // 取得報名活動
    case 'beck_signup_actions_index':
        echo $api->beck_signup_actions_index($xoopsModuleConfig['only_enable']);
        break;
    // 取得某活動報名名單
    case 'beck_signup_data_index':
        echo $api->beck_signup_data_index($action_id);
        break;

    default:
        echo $api->user();
        break;
}
