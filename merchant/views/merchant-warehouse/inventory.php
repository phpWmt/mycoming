<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\bootstrap\Alert;

if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}

?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form  method="get">
                                <input type="hidden" name="id" value="<?php echo Yii::$app->admin->getIdentity()['entrepot']?>"/>
                                <div class="input-group list-group col-sm-2">
                                    <input type="text" name="keyword" placeholder="请输入商品名称检索" class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
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

                                <th class="text-center"><b>入库单号</b></th>
                                <th class="text-center"><b>商品名称</b></th>
                                <th class="text-center"><b>所属仓库</b></th>
                                <th class="text-center"><b>商品分类</b></th>
                                <th class="text-center"><b>商品品牌</b></th>
                                <th class="text-center"><b>入库类型</b></th>
                                <th class="text-center"><b>剩余数量</b></th>
                                <th class="text-center"><b>已售数量</b></th>
                                <th class="text-center"><b>入库总数</b></th>
                                <th class="text-center"><b>是否推荐</b></th>
                                <th class="text-center"><b>推荐原因</b></th>
                                <th class="text-center"><b>状态</b></th>
                                <th class="text-center"><b>入库规格</b></th>
                                <th class="text-center"><b>操作</b></th>
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


                                    <td align="center"><?php echo($v["godown_id"]); ?></td>

                                    <td align="center"><?php echo($v['title']); ?></td>

                                    <td align="center"><?php echo($v['entrepot']["entrepot_name"]); ?></td>
                                    <td align="center"><?php echo($v['cate']["name"]); ?></td>

                                    <td align="center"><?php echo($v['brand']["name"]); ?></td>

                                    <td align="center"><?php echo($v["godownType"]['name']); ?></td>

                                    <td align="center"><?php echo($v["num"]); ?></td>

                                    <td align="center"><?php echo($v["sold"]); ?></td>

                                    <td align="center"><?php echo($v["total_num"]); ?></td>

                                    <td align="center">
                                        <?php if($v["is_recom"] == 0):?>
                                            <a class="btn btn-default btn-rounded btn-outline btn-xs" href="#">&nbsp;未推荐&nbsp;</a>
                                        <?php else:?>
                                            <a class="btn btn-info btn-rounded btn-outline btn-xs" href="">&nbsp;已推荐&nbsp;</a>
                                        <?php endif;?>
                                    </td>

                                    <td align="center"><?php echo($v["recom_reason"]); ?></td>

                                    <td align="center">
                                        <?php if($v["status"] == 0):?>
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="buttons.html#">已禁用</a>
                                        <?php else:?>
                                            <a class="btn btn-info btn-rounded btn-outline btn-xs" href="buttons.html#">已启用</a>
                                        <?php endif;?>

                                    </td>

                                    <td align="center">
                                        <a class="btn btn-success btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['merchant-warehouse/spec','id'=>$v['id']])?>"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;查看入库规格</a>
                                    </td>

                                    <td align="center">
                                        <?php if($v["is_recom"] == 0):?>
                                            <button data-id="<?php echo $v['id'] ?>" type="button" data-toggle="modal" data-target="#add_per" class="btn btn-sm btn-primary btn-outline btn-xs btn-rounded recommended"><i class="glyphicon glyphicon-resize-vertical"></i>添加推荐</button>

                                        <?php else:?>

                                            <a href="<?php echo Url::to(['merchant-warehouse/recommended','id'=>$v['id'],'is_recom'=>0,'status'=>1])?>" type="button"   class="btn btn-sm btn-success btn-outline btn-xs btn-rounded "><i class="glyphicon glyphicon-resize-vertical"></i>取消推荐</a>

                                        <?php endif;?>

                                        <?php if($v["status"] == 0):?>
                                            <a class="btn btn-primary btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['merchant-warehouse/entrepot-status','Entrepot_id'=>$v['id'],'status'=>1])?>"><i class="fa fa-check"></i>&nbsp;启用</a>
                                        <?php else:?>
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['merchant-warehouse/entrepot-status','Entrepot_id'=>$v['id'],'status'=>0])?>"><i class="glyphicon glyphicon-remove"></i>&nbsp;禁用</a>
                                        <?php endif;?>

                                        <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12 page">
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


<div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">推荐原因</h4>
            </div>
            <form class="myform" action="<?php echo Url::to(['merchant-warehouse/recommended'])?>" method="get">
                <small class="font-bold">
                    <div class="modal-body">
                        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">
                        <input type="hidden" name="is_recom"  value="1">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" name="status"  value="1">
                        <div class="form-group">
                            <label>推荐原因:</label>
                            <input type="text" name="recom_reason"  placeholder="填写推荐原因" class="col-sm-6 form-control" required>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit"  class="btn btn-primary">添加</button>
                    </div>
                </small>
            </form>
        </div>
    </div>
</div>

<?php
$js=<<<JS
        $(".recommended").click(function () {
             var id = $(this).attr('data-id');
             $('#id').val(id);
         });
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
                var date_value=index==1?new Date():'';
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
                content: '您确定要批量删除这些管理员吗？',
                ok: function () {
                    $.ajax({
                        url: "/goods/delete",
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
                content: "您确定要删除此商品吗？",
                ok: function () {
                    $.ajax({
                        url: "/merchant/merchant-warehouse/entrepot-delete",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
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