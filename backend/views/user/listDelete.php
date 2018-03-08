<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<?= \common\widgets\Alert::widget()?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>用户列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form method="get" action="/user/list-delete">

                                <div class="input-group list-group" style="float:left; margin-right: 10px;">
                                        <span style="float:left;">
                                            <select class="form-control" name="status">
                                            <option value="">状态选择</option>
                                                <option value="2">禁用</option>
                                                <option value="1">正常</option>
                                            </select>
                                        </span>
                                </div>

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="start_time" placeholder="开始时间" class="input-sm form-control time" lay-key="1">
                                </div>

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" id="time" name="end_time" placeholder="结束时间" class="input-sm form-control time" lay-key="2">
                                </div>
                                <div class="input-group list-group col-sm-2">
                                    <input type="text" name="keyword" placeholder="请输入手机号、昵称" class="input-sm form-control">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th class="text-center">头像</th>
                                <th class="text-center">手机号</th>
                                <th class="text-center">昵称</th>
                                <th class="text-center">注册时间</th>
                                <th class="text-center">上次登录时间</th>
                                <th class="text-center">状态</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($lists)): foreach ($lists as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" value="<?php echo $v->id ?>">
                                        </label>
                                    </td>
                                    <td align="center">
                                        <img class="goods_img" src="<?php echo Yii::$app->params['API_HOST'].$v->cover; ?>">
                                    </td>
                                    <td align="center">
                                        <?php echo $v->phone; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $v->nickname; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $v->create_time; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $v->last_time; ?>
                                    </td>

                                    <td align="center">
                                        <?php if ($v->status == 1): ?>
                                            <a href="<?php echo Url::to(['user/status?id='.$v->id.'&status=2'])?>" class="status off" id="<?php echo $v->id; ?>"
                                               title="账户正常">
                                                <i class="fa fa-lg fa-check text-navy" data-status="1"></i>
                                            </a>
                                        <?php elseif ($v->status == 2): ?>
                                            <a href="<?php echo Url::to(['user/status?id='.$v->id.'&status=1'])?>" class="status" id="<?php echo $v->id; ?>"
                                               title="账户锁定则不允许登录">
                                                <i class="fa fa-lg fa-lock text-danger" data-status="0"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>

                                    <td align="center">

                                        <button data-id="<?php echo $v['id']?>" data-delete="1" href="javascript:void (0)" type="button" class="btn btn-info btn-outline btn-xs del btn-rounded"><i class="glyphicon glyphicon-ok"></i>&nbsp;还原</button>

                                        <button data-id="<?php echo $v['id']?>" data-delete="1" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs delete btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;彻底删除</button>

                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12 page"><span>共<strong>
                        <?php echo $pages->totalCount; ?></strong>条记录</span>
                            <div class="pull-right">
                                <?= LinkPager::widget([
                                    'pagination'     => $pages,
                                    'nextPageLabel'  => '下一页',
                                    'prevPageLabel'  => '上一页',
                                    'firstPageLabel' => '首页',
                                    'lastPageLabel'  => '尾页',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$js = <<<JS

    $(document).ready(function () {
        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"})
            // 全选
        $('.all-checks').on('ifChecked', function (event) {
            $("input[type='checkbox']").iCheck('check');
        });
        // 反选
        $('.all-checks').on('ifUnchecked', function (event) {
            $("input[type='checkbox']").iCheck('uncheck');
        });
    });

            lay('.time').each(function(index,obj){
                var date_value=index==1?new Date():'';
                laydate.render({
                elem: obj,
                type: 'datetime',
                theme:'molv',//墨绿主题
                trigger: 'click',//日期只读
                value:date_value
                });
            });



    
        //还原     
        $(".del").click(function () {
            var dele = $(this);
            var id= $(this).attr('data-id');
             var is_delete= $(this).attr('data-delete');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要还原此用户吗？',
                ok: function () {
                    $.ajax({
                        url: "/user/delete",
                        type: "post",
                        dataType: "json",
                        data:{
                             'id':id,'is_delete':is_delete,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                var status=dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                status.close();
                                dele.closest('tr').remove();
                                }, 800);
                            }else{ 
                                dialog({title: "提示",content: data.info,ok: true}).showModal();
                            } 
                        }
                    });
                },
                cancel: true
            });
            d.showModal();
        }); 
        
        
        //彻地删除  
        $(".delete").click(function () {
            var dele = $(this);
            var id= $(this).attr('data-id');
             var is_delete= $(this).attr('data-delete');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此用户吗？不可恢复！',
                ok: function () {
                    $.ajax({
                        url: "/user/del",
                        type: "post",
                        dataType: "json",
                        data:{
                             'id':id,'is_delete':is_delete,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                var status=dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                status.close();
                                dele.closest('tr').remove();
                                }, 800);
                            }else{ 
                                dialog({title: "提示",content: data.info,ok: true}).showModal();
                            } 
                        }
                    });
                },
                cancel: true
            });
            d.showModal();
        }); 
JS;
$this->registerJs($js);
?>
</body>