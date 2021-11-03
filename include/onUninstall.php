<?php
// 如「模組目錄」= beck_signup ，則「首字大寫模組目錄」= Signup
// 如「資料表名」= actions，則「模組物件」= Actions

// 反安裝前
function xoops_module_pre_uninstall_beck_signup(XoopsModule $module)
{
}

// 反安裝後
function xoops_module_uninstall_beck_signup(XoopsModule $module)
{
    global $xoopsDB;
    $date = date("Ymd");
    rename(XOOPS_ROOT_PATH . "/uploads/beck_signup", XOOPS_ROOT_PATH . "/uploads/beck_signup_bak_{$date}");

    return true;
}
