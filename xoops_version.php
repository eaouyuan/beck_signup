<?php
$modversion = [];

//---模組基本資訊---//
$modversion['name'] = '活動報名';
$modversion['version'] = 1.00;
$modversion['description'] = '活動報名模組';
$modversion['author'] = 'Beck';
$modversion['credits'] = '';
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = 'images/logo.png';
$modversion['dirname'] = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date'] = '2021/09/21';
$modversion['module_website_url'] = 'https://github.com/eaouyuan/beck_signup';
$modversion['module_website_name'] = 'Beck Signup GitHub';
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://作者網站網址';
$modversion['author_website_name'] = '作者網站名稱';
$modversion['min_php'] = 7.0;
$modversion['min_xoops'] = '2.5';

//---paypal資訊---//
$modversion['paypal'][] = [
    'business' => 'eaouyuan@gmail',
    'item_name' => 'Donation : eaouyuan',
    'amount' => 10,
    'currency_code' => 'USD',
];

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---模組資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][]= 'beck_signup_actions';
$modversion['tables'][]= 'beck_signup_data';
$modversion['tables'][]= 'beck_signup_data_center';
$modversion['tables'][]= 'beck_signup_files_center';

//---後台管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 1;
// $modversion['sub'][] = ['name' => '子選項文字', 'url' => '子選項連結位址'];

//---模組自動功能---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---樣板設定---//
$modversion['templates'][] = ['file' => 'beck_signup_admin.tpl', 'description' => '後台共同樣板'];
$modversion['templates'][] = ['file' => 'beck_signup_index.tpl', 'description' => '前台共同樣板'];

//---搜尋---//
$modversion['hasSearch'] = 1;
$modversion['search'] = ['file' => 'include/search.php', 'func' => 'beck_signup_search'];

//---區塊設定---//

$modversion['blocks'][] = [
    'file' => 'action_list.php',
    'name' => '可報名活動一覽',
    'description' => '列出所有可報名的活動',
    'show_func' => 'action_list',
    'template' => 'action_list.tpl',
    'edit_func' => 'action_list_edit',
    'options' => '5|action_date desc',
];
    
$modversion['blocks'][] = [
    'file' => 'action_signup.php',
    'name' => '活動報名焦點',
    'description' => '可選擇某一活動讓使用者報名',
    'show_func' => 'action_signup',
    'template' => 'action_signup.tpl',
    'edit_func' => 'action_signup_edit',
    'options' => '',
];

//---偏好設定---//
$modversion['config'][] = [
    'name' => 'show_number',
    'title' => '_MI_TAD_SIGNUP_SHOW_NUMBER',
    'description' => '_MI_TAD_SIGNUP_SHOW_NUMBER_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '5',
    // 'options'=>['5則'=>5,'15則'=>15], //有select下拉選單才要用
];

$modversion['config'][] = [
    'name' => 'only_enable',
    'title' => '_MI_TAD_SIGNUP_ONLY_ENABLE',
    'description' => '_MI_TAD_SIGNUP_ONLY_ENABLE_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => '0',
];

//---評論---//
// $modversion['hasComments'] = 1;
// $modversion['comments'][] = ['pageName' => '單一頁面.php', 'itemName' => '主編號'];

//---通知---//
// $modversion['hasNotification'] = 1;
