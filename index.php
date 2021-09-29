<?php
// 如「模組目錄」=  beck_signup ，則「首字大寫模組目錄」= Signup
// 如「資料表名」= beck_signup_actions= Beck_signup_actions
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_signup\Beck_signup_actions;

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'beck_signup_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

/*-----------變數過濾----------*/
$op = Request::getString('op');
$id = Request::getInt('id');

/*-----------執行動作判斷區----------*/
switch ($op) {

    //新增表單
    case 'beck_signup_actions_create':
        Beck_signup_actions::create();
        break;

    //新增資料
    case 'beck_signup_actions_store':
        $id = Beck_signup_actions::store();
        header("location: {$_SERVER['PHP_SELF']}?id=$id");
        exit;

    //修改用表單
    case 'beck_signup_actions_edit':
        Beck_signup_actions::create($id);
        $op = 'beck_signup_actions_create';
        break;

    //更新資料
    case 'beck_signup_actions_update':
        Beck_signup_actions::update($id);
        header("location: {$_SERVER['PHP_SELF']}?id=$id");
        exit;

    //刪除資料
    case 'beck_signup_actions_destroy':
        Beck_signup_actions::destroy($id);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    default:
        if (empty($id)) {
            Beck_signup_actions::index();
            $op = 'beck_signup_actions_index';
        } else {
            Beck_signup_actions::show($id);
            $op = 'beck_signup_actions_show';
        }
        break;
}

/*-----------function區--------------*/

/*-----------秀出結果區--------------*/
unset($_SESSION['api_mode']);
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/beck_signup/css/module.css');
require_once XOOPS_ROOT_PATH . '/footer.php';
