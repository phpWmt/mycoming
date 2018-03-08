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
                    <h3><i class="fa fa-edit">　</i>文章列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 p-m">

                            <form method="get">
                                <div class="input-group list-group col-sm-6">
                                    <input type="text" name="keyword" placeholder="请输入文章标题"
                                           class="input-sm form-control">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                </div>
                            </form>

                            <a href="<?php echo Url::to(['article/create']) ?>"><button type="button" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-plus"></i>添加文章</button></a>
                            <button id="delete_all" class="btn btn-sm btn-outline btn-danger m-l del_all" type="button"><i class="fa fa-trash-o"></i>批量删除</button>
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
                                <th class="text-center">ID</th>
                                <th class="text-center">标题</th>
                                <th class="text-center">作者(管理员账号)</th>
                                <th class="text-center">创建时间</th>
                                <th class="text-center">更新时间</th>
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
                                    <td align="center"><?php echo($v["id"]); ?></td>
                                    <td align="center"><?php echo($v["title"]); ?></td>
                                    <td align="center"><?php echo($v['admin_username']); ?></td>
                                    <td align="center"><?php echo($v["create_time"]); ?></td>
                                    <td align="center"><?php echo($v["update_time"]); ?></td>
                                    <td align="center">
                                        <a href="<?php echo Url::to(['article/update','id'=>$v['id']]) ?>">
                                            <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-paste"></i>编辑</button>
                                        </a>
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
                content: '您确定要批量删除这些文章吗？',
                ok: function () {
                    $.ajax({
                        url: "/article/delete",
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
                content: '您确定要删除此文章吗？',
                ok: function () {
                    $.ajax({
                        url: "/article/delete",
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
JS;
$this->registerJs($js);
?>
</body>