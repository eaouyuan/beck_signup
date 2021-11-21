<h2 class="my">
    <{if $enable && ($number + $candidate) > $signup_count && $end_date|strtotime >= $smarty.now}>
        <i class="fa fa-check text-success" aria-hidden="true"></i>
    <{else}>
        <i class="fa fa-times text-danger" aria-hidden="true"></i>
    <{/if}>
    <{$title}>
    <small><i class="fa fa-calendar" aria-hidden="true"></i> 活動日期：<{$action_date}></small>
</h2>

<div class="alert alert-info">
    <{$detail}>
</div>

<!-- AddToAny BEGIN 快速簡易轉換pdf--> 
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
    <a class="a2a_button_printfriendly"></a>
    <a class="a2a_button_facebook"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->

<{$files}>

<h3 class="my">
    已報名表資料
    <small>
        <i class="fa fa-calendar-check-o" aria-hidden="true"></i> 報名截止日期：<{$end_date}>
        <i class="fa fa-users" aria-hidden="true"></i> 報名人數上限：<{$number}>
        <{if $candidate}><span data-toggle="tooltip" title="可候補人數">(<{$candidate}>)</span><{/if}>
    </small>
</h3>


<table data-toggle="table" data-pagination="true" data-search="true" data-mobile-responsive="true">
    <thead>
        <tr>
            <{* <{foreach from=$signup.0.tdc key=col_name item=user name=tdc}> *}>
            <{foreach from=$titles  item=title }>
                <th data-sortable="true" nowrap class="c"><{$title}></th>
            <{/foreach}>
            <th data-sortable="true" nowrap class="c">錄取</th>
            <th data-sortable="true" nowrap class="c">報名日期</th>
        </tr>
    </thead>
    <tbody>
        <{foreach from=$signup item=signup_data}>
            <tr>
                <{foreach from=$titles  item=title }>
                    <{assign var=user_data value=$signup_data.tdc.$title}>
                    <{* <{foreach from=$signup_data.tdc key=col_name item=user_data}> *}>
                    <td>
                        <{if ($smarty.session.can_add && $uid == $now_uid)|| $signup_data.uid == $now_uid  || ($smarty.session.beck_signup_adm)}>
                            <{foreach from=$user_data item=data}>
                                <div><a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_show&id=<{$signup_data.id}>"><{$data}></a></div>
                            <{/foreach}>
                        <{else}>
                            <div>
                                <{if strpos($title, '姓名')!==false}>
                                    <{if preg_match("/[a-z]/i", $user_data.0)}>
                                        <{$user_data.0|regex_replace:"/[a-z]/":"*"}>
                                    <{else}>
                                        <{$user_data.0|substr_replace:'O':3:3}>
                                    <{/if}>
                                <{else}>
                                    ****
                                <{/if}>
                                    
                            </div>
                        <{/if}>
                    </td>
                <{/foreach}>
            
                <{if $smarty.session.can_add}>
                    <td>
                        <{if $signup_data.accept==='1'}>
                            <div class="text-primary">錄取</div>
                            <{if ($smarty.session.can_add && $uid == $now_uid) || ($smarty.session.beck_signup_adm)}>
                                <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_accept&id=<{$signup_data.id}>&action_id=<{$id}>&accept=0" class="btn btn-sm btn-warning">改成未錄取</a>
                            <{/if}> 
                        <{elseif $signup_data.accept==='0'}>
                            <div class="text-danger">未錄取</div>
                            <{if ($smarty.session.can_add && $uid == $now_uid) || ($smarty.session.beck_signup_adm)}>
                                <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_accept&id=<{$signup_data.id}>&action_id=<{$id}>&accept=1" class="btn btn-sm btn-success">改成錄取</a>
                            <{/if}> 
                        <{else}>
                            <div class="text-muted">尚未設定</div>

                            <!-- <{$smarty.session.can_add}> <{$uid}> <{$now_uid}> -->
                            <{if ($smarty.session.can_add && $uid == $now_uid) || ($smarty.session.beck_signup_adm)}>
                                <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_accept&id=<{$signup_data.id}>&action_id=<{$id}>&accept=0" class="btn btn-sm btn-warning">未錄取</a>
                                <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_accept&id=<{$signup_data.id}>&action_id=<{$id}>&accept=1" class="btn btn-sm btn-success">錄取</a>
                            <{/if}> 
                        <{/if}>
                    </td>
                <{/if}>

                <td>
                    <{$signup_data.signup_date}>
                    <{if $signup_data.tag}><div><span class="badge badge-primary"><{$signup_data.tag}></span></div><{/if}>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
<table class="table table-sm">
    <tr>
        <{foreach from=$statistics key=title item=options}>
            <td>
                <b><{$title}></b>
                <hr class="my-1">
                <ul>
                    <{foreach from=$options key=option item=count}>
                        <li><{$option}> : <{$count}></li>
                    <{/foreach}>
                </ul>
            </td>
        <{/foreach}>
    </tr>
</table>
<{if $smarty.session.can_add && $uid == $now_uid || ($smarty.session.beck_signup_adm)}>
    <div class="bar">
        <div class="col mb-3">
            <a href="javascript:del_action('<{$id}>')" class="btn btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i> 刪除活動
            </a>
            <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_actions_edit&id=<{$id}>" class="btn btn-warning">
                <i class="fa fa-pencil" aria-hidden="true"></i> 編輯活動
            </a>
            <a href="<{$xoops_url}>/modules/beck_signup/html.php?id=<{$action.id}>" class="btn  btn-primary"><i class="fa fa-html5" aria-hidden="true"></i> HTML</a>
            <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_pdf_setup&id=<{$id}>" class="btn btn-info"><i class="fa fa fa-save" aria-hidden="true"></i> 產生簽到表</a>
        </div>

        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="#" class="btn btn-secondary"><i class="fa fa-file-text-o" aria-hidden="true"></i> 匯出報名名單：</a>

            <a href="<{$xoops_url}>/modules/beck_signup/csv.php?id=<{$id}>&type=signup" class="btn  btn-info">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> CSV</a>
            <a href="<{$xoops_url}>/modules/beck_signup/excel.php?id=<{$id}>&type=signup" class="btn  btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
            <a href="<{$xoops_url}>/modules/beck_signup/pdf.php?id=<{$id}>" class="btn  btn-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
            <a href="<{$xoops_url}>/modules/beck_signup/word.php?id=<{$id}>" class="btn btn-primary"><i class="fa fa-file-word-o" aria-hidden="true"></i> Word</a>
        </div>
    </div>
    <div class="bar">

    </div>

    
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text">匯入報名名單（CSV）</span>
            </div>
            <input type="file" name="csv" class="form-control" accept="text/csv">
            <div class="input-group-append input-group-btn">
                <input type="hidden" name="id" value="<{$id}>">
                <input type="hidden" name="op" value="beck_signup_data_preview_csv">
                <button type="submit" class="btn btn-primary">匯入 CSV</button>
                <a href="<{$xoops_url}>/modules/beck_signup/csv.php?id=<{$id}>" class="btn btn-secondary">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i> 下載 CSV 匯入格式檔
                </a>

            </div>
        </div>
    </form>
    <br>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text">匯入報名名單（Excel）</span>
            </div>
            <input type="file" name="excel" class="form-control" accept=".xlsx">
            <div class="input-group-append input-group-btn">
                <input type="hidden" name="id" value="<{$id}>">
                <input type="hidden" name="op" value="beck_signup_data_preview_excel">
                <button type="submit" class="btn btn-primary">匯入 Excel</button>
                <a href="<{$xoops_url}>/modules/beck_signup/excel.php?id=<{$id}>" class="btn btn-secondary">
                    <i class="fa a-file-excel-o" aria-hidden="true"></i> 下載 Excel 匯入格式檔
                </a>
            </div>
        </div>
    </form>

<{/if}>