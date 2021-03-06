<h2 class="my">活動列表</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th nowrap class="c">活動名稱</th>
            <th nowrap class="c">活動日期</th>
            <th nowrap class="c">報名截止日</th>
            <th nowrap class="c">已報名人數</th>
            <th nowrap class="c">功能</th>
        </tr>
    </thead>
    <tbody>
        <{foreach from=$all_data key=id item=action name=all_data}>
            <tr>
                <td>
                    <{if $action.enable && ($action.number + $action.candidate) > $action.signup_count && $action.end_date|strtotime >= $smarty.now}>
                        <i class="fa fa-check text-success" data-toggle="tooltip" title="報名中" aria-hidden="true"></i>
                    <{else}>
                        <i class="fa fa-times text-danger" data-toggle="tooltip" title="無法報名" aria-hidden="true"></i>
                    <{/if}>
                    <a href="<{$xoops_url}>/modules/beck_signup/index.php?id=<{$action.id}>"><{$action.title}></a>
                </td>
                <td><{$action.action_date}></td>
                <td><{$action.end_date}></td>
                <td>
                    <{$action.signup_count}>/<{$action.number}>
                    <{if $action.candidate}><span data-toggle="tooltip" title="可候補人數">(<{$action.candidate}>)</span><{/if}>
                </td>
                <td nowrap class="c">
                    <{if $smarty.session.can_add && ($action.uid==$now_uid || $smarty.session.beck_signup_adm)}>
                        <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_actions_edit&id=<{$action.id}>" class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> 編輯</a>
                        <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_actions_copy&id=<{$action.id}>" class="btn btn-success btn-sm"><i class="fa fa-copy" aria-hidden="true"></i> 複製</a>

                    <{/if}>

                    <{if $action.enable && ($action.number + $action.candidate)> $action.signup_count && $xoops_isuser && $action.end_date|strtotime >= $smarty.now}>
                        <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_data_create&action_id=<{$action.id}>" class="btn btn-sm btn-info"><i class="fa fa-plus" aria-hidden="true"></i> 立即報名</a>
                    <{else}>
                        <a href="<{$xoops_url}>/modules/beck_signup/index.php?id=<{$action.id}>" class="btn btn-success btn-sm"><i class="fa fa-file" aria-hidden="true"></i> 詳情</a>
                    <{/if}>
                </td>
            </tr>
        <{/foreach}>
    </tbody>
</table>

<{$bar}>

<{if $smarty.session.can_add}>
    <div class="bar">
        <a href="<{$xoops_url}>/modules/beck_signup/index.php?op=beck_signup_actions_create" class="btn btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i>新增活動</a>
    </div>
<{/if}>