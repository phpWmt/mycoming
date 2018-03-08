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
                    <h3><i class="fa fa-key">　</i>角色列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5 p-m">
                            <form method="get">
                                <div class="input-group list-group col-sm-6">
                                    <input type="text" name="keyword" placeholder="输入角色名称或标识" class="input-sm form-control">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                </div>
                            </form>
                            <a href="<?php echo Url::to(['rbac/add-roles']) ?>">
                                <button type="button" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-user-plus"></i>添加角色</button>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">描述</th>
                                <th class="text-center">标识</th>
                                <th class="text-center">创建时间</th>
                                <th class="text-center">修改时间</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($list)): foreach ($list as $k => $v): ?>
                                <tr>
                                    <td align="center"><?php echo($v["description"]); ?></td>
                                    <td align="center"><?php echo($v["name"]); ?></td>
                                    <td style="text-align:center"><?php echo date('Y-m-d H:i:s', $v['created_at']) ?></td>
                                    <td style="text-align:center"><?php echo date('Y-m-d H:i:s', $v['updated_at']) ?></td>
                                    <td align="center">
                                        <a href="<?php echo Url::to(['rbac/update-item','name'=>$v['name'],'type'=>1]) ?>">
                                            <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-paste"></i>编辑</button>
                                        </a>
                                        <?php  if ($v['name']!='admin'&&$v['name']!='default'):?>
                                        <button data-name="<?php echo $v['name'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-xs del"><i class="fa fa-trash-o"></i>删除</button>
                                        <?php else: ?>
                                        <?php endif; ?>
                                        <a href="<?php echo Url::to(['rbac/assign-item','name'=>$v['name'],'status'=>$status])?>">
                                            <button type="button" class="btn btn-success btn-xs"><i class="fa fa-key"></i>分配权限</button>
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
</body>
<?php
$delete=<<<JS
    $("body").on("click", ".del", function () {
       var name = $(this).attr('data-name');
       var dele=$(this);
        var d = dialog({
            title: '友情提示',
            id: 'del_pro',
            content: '您确定要删除此角色吗？',
            ok: function () {
                $.ajax({
                    type: "post",
                    url: "/rbac/delete-item",
                    data: {
                        'name':name,
                        'type':1,
                        '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status === 1) {
                            var d=dialog({content: data.info}).showModal();
                            setTimeout(function () {
                                dele.closest("tr").remove();
                                d.close();
                            }, 800);
                        } else {
                            dialog({title: "提示", content: data.info, ok: true}).showModal();
                        }
                    }
                });
            },
            cancel: true
        });
        d.showModal();
    })
JS;
$this->registerJs($delete);
?>