<?php
use Xmf\Request;
use XoopsModules\Beck_signup\Beck_signup_actions;
use XoopsModules\Beck_signup\Beck_signup_data;
use \PhpOffice\PhpWord\TemplateProcessor;
/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/autoload.php';

if (!$_SESSION['can_add']) {
    redirect_header($_SERVER['PHP_SELF'], 3, "您沒有權限使用此功能");
}

$id = Request::getInt('id');
$action = Beck_signup_actions::get($id);

$templateProcessor = new TemplateProcessor("docs/signup-1.docx");
$templateProcessor->setValue('title', $action['title']);
$templateProcessor->setValue('detail', strip_tags($action['detail']));
$templateProcessor->setValue('action_date', $action['action_date']);
$templateProcessor->setValue('end_date', $action['end_date']);
$templateProcessor->setValue('number', $action['number']);
$templateProcessor->setValue('candidate', $action['candidate']);
$templateProcessor->setValue('signup', $action['signup_count']);
$templateProcessor->setValue('url', XOOPS_URL . "/modules/beck_signup/index.php?op=beck_signup_data_create&amp;action_id={$action['id']}");
// $templateProcessor->saveAs("{$action['title']}報名名單.docx");

$signup = Beck_signup_data::get_all($action['id']);
//重複生成幾列
$templateProcessor->cloneRow('id', count($signup));

$i = 1;
foreach ($signup as $id => $signup_data) {
    $iteam = [];
    foreach ($signup_data['tdc'] as $head => $user_data) {
        $iteam[] = $head . '：' . implode('、', $user_data);
    }
    // 「<w:br/>」 word的斷行符號
    $data = implode('<w:br/>', $iteam);

    if ($signup_data['accept'] === '1') {
        $accept = '錄取';
    } elseif ($signup_data['accept'] === '0') {
        $accept = '未錄取';
    } else {
        $accept = '尚未設定';
    }

    // 第1筆資料
    // $templateProcessor->setValue('欄A#1', '值A');
    // $templateProcessor->setValue('欄B#1', '值B');
    // $templateProcessor->setValue('欄C#1', '值C');
    // // 第2筆資料
    // $templateProcessor->setValue('欄A#2', '值A');
    // $templateProcessor->setValue('欄B#2', '值B');
    // $templateProcessor->setValue('欄C#2', '值C');
    $templateProcessor->setValue("id#{$i}", $id);
    $templateProcessor->setValue("accept#{$i}", $accept);
    $templateProcessor->setValue("data#{$i}", $data);
    $i++;
}


header('Content-Type: application/vnd.ms-word');
header("Content-Disposition: attachment;filename={$action['title']}報名名單.docx");
header('Cache-Control: max-age=0');
$templateProcessor->saveAs('php://output');
