<h2 class="my">
    <{if $enable && ($number + $candidate) > $signup|@count && $end_date|strtotime >= $smarty.now}>
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
                <th data-sortable="true"><{$title}></th>
            <{/foreach}>
            <th data-sortable="true">錄取</th>
            <th data-sortable="true">報名日期</th>
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
<{if $smarty.session.can_add && $uid == $now_uid}>
    <div class="bar">
        <a href="javascript:del_action('<{$id}>')" class="btn btn-danger">
            <i class="fa fa-times" aria-hidden="true"></i> 刪除活動
        </a>
        <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_actions_edit&id=<{$id}>" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> 編輯活動</a>
    </div>
<{/if}>