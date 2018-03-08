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
                    <h3><i class="fa fa-key">　</i>权限列表</h3>
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
                                <button type="button" data-toggle="modal" data-target="#add_per" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-key"></i>添加权限</button>
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
                                    <td style="text-align:center"><?php echo $v['description'] ?></td>
                                    <td style="text-align:center"><?php echo $v['name'] ?></td>
                                    <td style="text-align:center"><?php echo date('Y-m-d H:i:s', $v['created_at']) ?></td>
                                    <td style="text-align:center"><?php echo date('Y-m-d H:i:s', $v['updated_at']) ?></td>
                                    <td align="center">
                                        <a href="<?php echo Url::to(['rbac/update-item','name'=>$v['name'],'type'=>2]) ?>">
                                            <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-paste"></i>编辑</button>
                                        </a>
                                        <button data-id="<?php echo $v['name'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>删除</button>
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


<div class="modal inmodal fade" id="///" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">权限添加</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-8">
                        <label class="control-label">权限名称:</label>
                        <input type="text" id="per_description"  placeholder="权限名称" class="col-sm-6 form-control">
                    </div>

                    <div class="col-sm-8">
                        <label class="control-label">权限标识:</label>
                        <input type="text" id="per_name" placeholder="权限标识" class="col-sm-6 form-control">
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="add_save" data-dismiss="modal">保存</button>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                </button>
                <i class="fa fa-key modal-icon"></i>
                <h4 class="modal-title">添加权限</h4>
                <p>
                    此处参数请认真填写，谨防出错。<br>
                    <strong style="color: #0AA699" id="success_status"></strong>
                    <strong style="color: #E21918" id="error_status"></strong>
                </p>
            </div>
            <small class="font-bold">
                <div class="modal-body">
                    <form class="myform">

                        <input type="hidden" name="status" value="<?php echo $status?>">

                        <div class="form-group">
                            <label>权限描述:</label>
                            <input type="text" name="description"  placeholder="权限描述,比如 首页" class="col-sm-6 form-control">
                        </div>
                        <div class="form-group">
                            <label>权限标识:</label>
                            <input type="text" name="name"  placeholder="权限标识,比如index/index" class="col-sm-6 form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" id="add" class="btn btn-primary">添加</button>
                </div>
            </small>
        </div>
    </div>
</div>
<?php
$js=<<<JS
    $("#delete_all").click(function() {
        var id='';
        $('input[name="check"]:checked').each(function (i, obj) {
            id=$(obj).val()+','+id;
        });
        $(".myform").ajaxSubmit({
            url: "/room/update",
            type: "post",
            dataType: "json",
            success: function (data) {
                if(data.status === 1) {
                    $("#update_status").text(data.info);
                    setTimeout(function (){
                   window.location.reload();
                    }, 800);
                }else{
                    $("#update_status").text(data.info);
                } 
            }
        });
    });
    
$("#add").click(function() {
    $(".myform").ajaxSubmit({
        url:"/rbac/add-permissions",
        type:"post",
        dataType:"json",
        success:function(data) {
            if(data.status === 1) {
                $("#error_status").text('');
                $("#success_status").text(data.info);
                    setTimeout(function (){
                    window.location.reload();
                }, 800);
            }else{
                $("#success_status").text('');
                $("#error_status").text(data.info);
            } 
        }
    });
});
JS;
$this->registerJs($js);
?>
</body>