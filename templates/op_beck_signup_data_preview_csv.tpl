<h2 class="my">匯入「<{$action.title}>」報名資料預覽</h2>

<{assign var=import_number value=$preview_data|@count}>
<{assign var=import_number value=$import_number-1}>

<div class="alert alert-<{if $import_number + $action.signup_count > $action.number + $action.candidate}>danger<{else}>success<{/if}>">
    可報名數：<{$action.number}> 人，
    可候補數：<{$action.candidate}> 人，
    已報名數：<{$action.signup_count}> 人，
    欲匯入人數：<{$import_number}> 人
</div>
<form action="index.php" method="post" id="myForm">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <{foreach from=$head item=title}>
                    <th><{$title}></th>
                <{/foreach}>
            </tr>
        </thead>
        <tbody>
            <{foreach from=$preview_data key=i item=data name=preview_data}>
                <{if $smarty.foreach.preview_data.iteration > 1}> <!-- 第一行是標題，不抓，第二行開始 -->
                    <tr>
                        <{foreach from=$data key=j item=val}>
                            <!-- 樣版設定變數 https://www.smarty.net/docs/zh_CN/language.function.foreach.tpl -->
                            <{assign var=title value=$head.$j}>
                            <{assign var=input_type value=$type.$j}>
                            <{assign var=input_options value=$options.$j}>
                            <{if $title!=''}>
                                <td>
                                    <{if $input_type=="checkbox"}>
                                        <{assign var=val_arr value='|'|explode:$val}>
                                        <{foreach from=$input_options item=opt}>
                                            <div class="form-check-inline checkbox-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="tdc[<{$i}>][<{$title}>][]" value="<{$opt}>" <{if $opt|in_array:$val_arr}>checked<{/if}>>
                                                    <{$opt}>
                                                </label>
                                            </div>
                                        <{/foreach}>
                                    <{elseif $input_type=="radio"}>
                                        <{foreach from=$input_options item=opt}>
                                            <div class="form-check-inline radio-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="tdc[<{$i}>][<{$title}>]" value="<{$opt}>" <{if $opt==$val}>checked<{/if}>>
                                                    <{$opt}>
                                                </label>
                                            </div>
                                        <{/foreach}>
                                    <{elseif $input_type=="select"}>
                                        <select name="tdc[<{$i}>][<{$title}>]" class="form-control validate[required]">
                                            <{foreach from=$input_options item=opt}>
                                                <option value="<{$opt}>" <{if $opt==$val}>selected<{/if}>><{$opt}></option>
                                            <{/foreach}>
                                        </select>
                                    <{else}>
                                        <input type="text" name="tdc[<{$i}>][<{$title}>]" value="<{$val}>" class="form-control form-control-sm">
                                    <{/if}>
                                </td>
                            <{/if}>
                        <{/foreach}>
                    </tr>
                <{/if}>
            <{/foreach}>
        </tbody>
    </table>

    <{$token_form}>
    <input type="hidden" name="id" value="<{$action.id}>">
    <input type="hidden" name="op" value="beck_signup_data_import_csv">
    <div class="bar">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save" aria-hidden="true"></i> 匯入CSV資料
        </button>
    </div>
</form>