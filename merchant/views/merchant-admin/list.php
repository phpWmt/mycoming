<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>管理员列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 p-m">
                            <form method="get">
                                <div class="input-group list-group col-sm-6">
                                    <input type="text" name="keyword" placeholder="请输入账号"
                                           class="input-sm form-control">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                </div>
                            </form>
                            <a href="<?php echo Url::to(['admin/create']) ?>"><button type="button" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-user-plus"></i>添加管理员</button></a>
                            <button id="delete_all" class="btn btn-sm btn-outline btn-danger m-l del_all" type="button"><i class="fa fa-user-times"></i>批量删除</button>
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
                                <th class="text-center">ID</th>
                                <th class="text-center">账号</th>
                                <th class="text-center">姓名</th>
                                <th class="text-center">手机号</th>
                                <th class="text-center">状态</th>
                                <th class="text-center">注册时间</th>
                                <th class="text-center">最近登录时间</th>
                                <th class="text-center">登录次数</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($model)): foreach ($model as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="check" value="<?php echo $v['id'] ?>">
                                        </label>
                                    </td>
                                    <td align="center"><?php echo($v["id"]); ?></td>
                                    <td align="center"><?php echo($v["username"]); ?></td>
                                    <td align="center"><?php echo($v["name"]); ?></td>
                                    <td align="center"><?php echo($v["phone"]); ?></td>
                                    <td align="center">
                                        <?php if ($v["status"] == 2): ?>
                                            <a href="javascript:;" class="status" aid="<?php echo($v["id"]); ?>" title="账户正常">
                                                <i class="fa fa-lg fa-check text-navy" data-status="2"></i>
                                            </a>
                                        <?php elseif ($v["status"] == 1): ?>
                                            <a href="javascript:;" class="status" aid="<?php echo($v["id"]); ?>" title="账户锁定则不允许登录">
                                                <i class="fa fa-lg fa-lock text-warning" data-status="1"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center"><?php echo($v["create_time"]); ?></td>
                                    <td align="center"><?php echo($v["last_time"]); ?></td>
                                    <td align="center"><?php echo($v["login_num"]); ?></td>
                                    <td align="center">
                                        <a href="<?php echo Url::to(['admin/update','id'=>$v['id']]) ?>">
                                            <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-paste"></i>编辑</button>
                                        </a>
                                        <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-xs del"><i class="fa fa-trash-o"></i>删除</button>
                                        <a href="<?php echo Url::to(['admin/assign','id'=>$v['id']])?>">
                                            <button type="button" class="btn btn-success btn-xs"><i class="fa fa-key"></i>分配角色</button>
                                        </a>
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
            $("#delete_all").click(function () {
            var id='';
            $('input[name="check"]:checked').each(function (i, obj) {
                id=$(obj).val()+','+id;
            });
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要批量删除这些管理员吗？',
                ok: function () {
                    $.ajax({
                        url: "/admin/delete",
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
                content: '您确定要删除此管理员吗？',
                ok: function () {
                    $.ajax({
                        url: "/admin/delete",
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
    
        /* 设置状态 */
        $('.status').click(function () {
            _Itab = $(this).children('i');
            var aid = $(this).attr('aid');
            var status = _Itab.attr('data-status') === '1' ? 2 : 1;
            $.ajax({
                type: "post",
                url: "/admin/status",
                data: {
                    id: aid,
                    status: status,
                    '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status === 1) {
                        console.log(status);
                        if (status === 2) {
                            _Itab.attr('data-status', 2).removeClass('fa-lock text-warning').addClass('fa-check text-navy');
                            _Itab.attr('title','账号正常');
                        } else {
                            _Itab.attr('data-status', 1).removeClass('fa-check text-navy').addClass('fa-lock text-warning');
                            _Itab.attr('title','账户锁定则不允许登录');
                        }
                        var success=dialog({content: data.info}).showModal();
                        setTimeout(function () {
                            success.close();
                        }, 800);
                    } else {
                        dialog({
                            title: "提示",
                            content: data.info,
                            ok: true
                        }).showModal();
                    }
                }
            });
        });
JS;
$this->registerJs($js);
?>
</body>