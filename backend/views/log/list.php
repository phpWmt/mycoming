<?php
use yii\widgets\LinkPager;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-file-text">　</i>日志列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form method="get" action="<?php \yii\helpers\Url::to(['log/list']) ?>">
                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="start_time" placeholder="开始时间"
                                           class="input-sm form-control time">
                                </div>
                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" id="time" name="end_time" placeholder="结束时间"
                                           class="input-sm form-control time">
                                </div>
                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="admin_username" placeholder="管理员账号"
                                           class="input-sm form-control">
                                </div>
                                <div class="input-group list-group col-sm-2">
                                    <input type="text" name="route" placeholder="请输入路由名称" class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
                                </div>
                            </form>
                            <button id="delete_all" class="btn btn-sm btn-outline btn-danger m-l del_all" type="button"><i class="fa fa-trash-o"></i>批量删除</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th >ID</th>
                                <th >管理员</th>
                                <th >路由</th>
                                <th >简要</th>
                                <th >操作时间</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($list)): foreach ($list as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="check" value="<?php echo $v['id'] ?>">
                                        </label>
                                    </td>
                                    <td><?php echo($v["id"]); ?></td>
                                    <td ><?php echo($v["admin_username"]); ?></td>
                                    <td ><?php echo($v["route"]); ?></td>
                                    <td ><?php
                                        echo(mb_substr($v["description"],0,100,'UTF-8').'......');
                                        ?></td>
                                    <td ><?php echo($v["created_at"]); ?></td>
                                    <td  align="center">

                                            <button type="button" data-id="<?php echo $v['id']; ?>" class="btn btn-primary btn-xs open"><i class="fa fa-eye"></i>查看</button>

                                        <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-xs del"><i class="fa fa-trash-o"></i>删除</button>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12 page"><span>共<strong><?php echo $pages->totalCount; ?></strong>条记录</span>
                            <div class="pull-right">
                                <?= LinkPager::widget([
                                    'pagination' => $pages,
                                    'nextPageLabel' => '下一页',
                                    'prevPageLabel' => '上一页',
                                    'firstPageLabel' => '首页',
                                    'lastPageLabel' => '尾页',
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
$js=<<<JS

        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"})
            // 全选
        $('.all-checks').on('ifChecked', function (event) {
            $("input[type='checkbox']").iCheck('check');
        });
        // 反选
        $('.all-checks').on('ifUnchecked', function (event) {
            $("input[type='checkbox']").iCheck('uncheck');
        });
            lay('.time').each(function(index,obj){
                var date_value=index===1?new Date():'';
                laydate.render({
                elem: obj,
                type: 'datetime',
                theme:'molv',//墨绿主题
                trigger: 'click',//日期只读
                value:date_value
                });
            });

            $("#delete_all").click(function () {
            var id='';
            $('input[name="check"]:checked').each(function (i, obj) {
                id=$(obj).val()+','+id;
            });
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要批量删除这些日志吗？',
                ok: function () {
                    $.ajax({
                        url: "/log/delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                    window.location.reload();
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
            
            
        $(".del").click(function () {
            var dele = $(this);
            var id=$(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此日志吗？',
                ok: function () {
                    $.ajax({
                        url: "/log/delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id+',',
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
    
        $(".open").click(function() {
            id=$(this).attr('data-id');
             layer.open({
              type: 2,
              title: '日志详情',
              shadeClose: true,
              shade: false,
              maxmin: true, //开启最大化最小化按钮
              area: ['600px', '500px'],
              content: '/log/content?id='+id
            });
        });
JS;
$this->registerJs($js);
?>
</body>