<?php
// 如「模組目錄」=  beck_signup ，則「首字大寫模組目錄」= Signup
// 如「資料表名」= beck_signup_actions= Beck_signup_actions
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_signup\Beck_signup_actions;
use XoopsModules\Beck_signup\Beck_signup_data;

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'beck_signup_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

/*-----------變數過濾----------*/
$op = Request::getString('op');
$id = Request::getInt('id');
$action_id = Request::getInt('action_id');
$accept = Request::getInt('accept');
$files_sn = Request::getInt('files_sn');

/*-----------執行動作判斷區----------*/
switch ($op) {

    // 下載檔案
    case "tufdl":
    $TadUpFiles = new TadUpFiles('beck_signup');
    $TadUpFiles->add_file_counter($files_sn);
    exit;

    //新增活動表單
    case 'beck_signup_actions_create':
        Beck_signup_actions::create();
        break;

    //新增活動資料
    case 'beck_signup_actions_store':
        $id = Beck_signup_actions::store();
        // header("location: {$_SERVER['PHP_SELF']}?id=$id");
        redirect_header($_SERVER['PHP_SELF'] . "?id=$id", 3, "成功建立活動！");
        exit;

    //修改用表單
    case 'beck_signup_actions_edit':
        Beck_signup_actions::create($id);
        $op = 'beck_signup_actions_create';
        break;

    //更新資料
    case 'beck_signup_actions_update':
        Beck_signup_actions::update($id);
        // header("location: {$_SERVER['PHP_SELF']}?id=$id");
        redirect_header($_SERVER['PHP_SELF'] . "?id=$id", 3, "成功修改活動！");
        exit;

    //刪除資料
    case 'beck_signup_actions_destroy':
        Beck_signup_actions::destroy($id);
        // header("location: {$_SERVER['PHP_SELF']}");
        redirect_header($_SERVER['PHP_SELF'] , 3, "成功刪除活動！");

        exit;

    //新增報名表單
    case 'beck_signup_data_create':
        Beck_signup_data::create($action_id);
        break;
    //儲存報名資料
    case 'beck_signup_data_store':
        $id = Beck_signup_data::store();
        Beck_signup_data::mail($id, 'store');
        redirect_header("{$_SERVER['PHP_SELF']}?op=beck_signup_data_show&id=$id", 3, "成功建立報名資料！");
        exit;
    //顯示報名表
    case 'beck_signup_data_show':
        Beck_signup_data::show($id);
        break;
    //修改報名表
    case 'beck_signup_data_edit':
        Beck_signup_data::create($action_id,$id);
        $op='beck_signup_data_create';
        break;
    //更新報名資料
    case 'beck_signup_data_update':
        Beck_signup_data::update($id);
        Beck_signup_data::mail($id, 'update');
        redirect_header($_SERVER['PHP_SELF'] . "?op=beck_signup_data_show&id=$id", 3, "成功修改報名資料！");
        exit;
    //刪除報名資料
    case 'beck_signup_data_destroy':
        $uid = $_SESSION['can_add'] ? null : $xoopsUser->uid();
        $signup = Beck_signup_data::get($id, $uid);
        Beck_signup_data::destroy($id);
        Beck_signup_data::mail($id, 'destroy', $signup);
        redirect_header($_SERVER['PHP_SELF'] . "?id=$action_id", 3, "成功刪除報名資料！");
        exit;

    //更改錄取狀態
    case 'beck_signup_data_accept':
        Beck_signup_data::accept($id, $accept);
        Beck_signup_data::mail($id, 'accept');
        redirect_header($_SERVER['PHP_SELF'] . "?id=$action_id", 3, "成功設定錄取狀態！");
        exit;
        
    
    // 複製活動
    case 'beck_signup_actions_copy':
        $new_id = Beck_signup_actions::copy($id);
        header("location: {$_SERVER['PHP_SELF']}?op=beck_signup_actions_edit&id=$new_id");
        exit;

    // 匯入 CSV 並預覽
    case 'beck_signup_data_preview_csv':
        Beck_signup_data::preview_csv($id);
        break;

        
    //批次匯入 CSV
    case 'beck_signup_data_import_csv':
        Beck_signup_data::import_csv($id);
        redirect_header("{$_SERVER['PHP_SELF']}?id=$id", 3, "成功匯入報名資料！");
        break;

    // 匯入 Excel 並預覽
    case 'beck_signup_data_preview_excel':
        Beck_signup_data::preview_excel($id);
        break;

    //批次匯入 Excel
    case 'beck_signup_data_import_excel':
        Beck_signup_data::import_excel($id);
        redirect_header("{$_SERVER['PHP_SELF']}?id=$id", 3, "成功匯入報名資料！");
        break;

    default:
    if (empty($id)) {
        Beck_signup_actions::index($xoopsModuleConfig['only_enable']);
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
