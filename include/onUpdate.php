<?php
// 如「模組目錄」= beck_signup ，則「首字大寫模組目錄」= Beck_signup
// 如「資料表名」= actions，則「模組物件」= Actions

use XoopsModules\Tadtools\Utility;

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

use XoopsModules\Beck_signup\Update;
if (!class_exists('XoopsModules\Beck_signup\Update')) {
    require dirname(__DIR__) . '/preloads/autoloader.php';
}

// 更新前
function xoops_module_pre_update_beck_signup(XoopsModule $module, $old_version)
{
    // 有上傳功能才需要
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/beck_signup");
    // 若有用到CKEditor編輯器才需要
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/beck_signup/file");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/beck_signup/image");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/beck_signup/image/.thumbs");

    $gperm_handler  = xoops_getHandler('groupperm');
    $groupid = Update::mk_group("活動報名管理");
    if (!$gperm_handler->checkRight($module->dirname(), 1, $groupid, $module->mid())) {
        $perm = $gperm_handler->create();
        $perm->setVar('gperm_groupid', $groupid);//群組編號
        $perm->setVar('gperm_itemid', 1);  //權限編號
        $perm->setVar('gperm_name', $module->dirname()); // 權限名稱，一般為模組目錄名稱
        $perm->setVar('gperm_modid', $module->mid()); //模組編號
        $gperm_handler->insert($perm);
    }
}

// 更新後
function xoops_module_update_beck_signup(XoopsModule $module, $old_version)
{
    global $xoopsDB;

    // 新增候補欄位
    if (Update::chk_candidate()) {
        Update::go_candidate();
    }

    return true;
}
