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
                    <h3><i class="fa fa-cart-plus">　</i>商品规格列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th class="text-center"><b>名称</b></th>
                                <th class="text-center"><b>规格</b></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($goods_spec_list)): foreach ($goods_spec_list as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="check" value="<?php echo $v['id'] ?>">
                                        </label>
                                    </td>
                                    <td align="center" style="color: black"><b><?php echo($v["name"]); ?></b></td>
                                    <td align="center" style="color: black"><b><?php echo(str_replace(',', '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;', $v["spec"])); ?></b></td>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品子规格列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form action="<?php echo Url::to(['goods/spec-list'])?>" method="get">
                                <div class="input-group list-group col-sm-2">
                                    <input type="hidden" name="id" value="<?php echo $goods_id?>"/>
                                    <input type="text" name="keyword" placeholder="请输入规格名称检索" class="input-sm form-control">
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
                                <th class="text-center"><b>商品名称</b></th>
                                <th class="text-center"><b>规格</b></th>
                                <th class="text-center"><b>价格</b></th>
                                <th class="text-center"><b>剩余库存</b></th>
                                <th class="text-center"><b>总库存</b></th>
                                <th class="text-center"><b>状态</b></th>
                                <th class="text-center"><b>创建时间</th>
                                <th class="text-center"><b>操作</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($goods_spec)): foreach ($goods_spec as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="check" value="<?php echo $v['id'] ?>">
                                        </label>
                                    </td>
                                    <td align="center"><?php echo($v['goods']["title"]); ?></td>
                                    <td align="center" style="color: black"><b><?php echo(str_replace(',', '&nbsp;&nbsp;', $v["spec"])); ?></b></td>
                                    <td align="center">
                                        <?php echo($v['price']); ?>
                                    </td>
                                    <td align="center">
                                      <?php echo($v['num']); ?>
                                    </td>

                                    <td align="center">
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="#">   <?php echo($v['total_num']); ?></a>
                                    </td>

                                    <td align="center">
                                        <?php if($v["status"] == 0):?>
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="#">已禁用</a>
                                        <?php else:?>
                                            <a class="btn btn-info btn-rounded btn-outline btn-xs" href="#">已启用</a>
                                        <?php endif;?>

                                    </td>



                                    <td align="center">
                                        <?php echo($v['add_time']); ?>
                                    </td>


                                    <td align="center">

                                        <?php if($v["status"] == 0):?>
                                            <a class="btn btn-primary btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['goods/spec-status','id'=>$v['id'],'status'=>1,'goods_id'=>$goods_id])?>"><i class="fa fa-check"></i>&nbsp;启用</a>
                                        <?php else:?>
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['goods/spec-status','id'=>$v['id'],'status'=>0,'goods_id'=>$goods_id])?>"><i class="glyphicon glyphicon-remove"></i>&nbsp;禁用</a>
                                        <?php endif;?>

                                        <?php if($v["status"] == 1):?>
                                            <button type="button" data-toggle="modal" data-target="#add_per" data-price="<?php echo $v['price']?>" data-id="<?php echo $v['id']?>" data-goods_id="<?php echo $v['goods_id']?>" class="btn btn-primary btn-outline btn-xs btn-rounded goods"><i class="glyphicon glyphicon-resize-vertical"></i>&nbsp;<b>+</b>&nbsp;库存</button>
                                        <?php endif;?>
                                        <!--  商品ID-->
                                        <input type="hidden" id="goods_id" value="<?php echo $goods_id?>"/>
                                        <button data-id="<?php echo $v['id'] ?>"  data-num="<?php echo $v['num'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--增加库存-->
<div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                </button>
                <h4 class="modal-title">增加库存</h4>
            </div>
            <small class="font-bold">
                <div class="modal-body">
                    <form class="myform">

                        <input type="hidden" id="goodsId" name="id" value="">
                        <input type="hidden" id="goods_id_id" name="goods_id" value="">

                        <div class="form-group">
                            <label>增加库存:</label>
                            <input type="number" name="num"  placeholder="增加库存(填写数字不能小于0)" class="col-sm-6 form-control" datatype="*" nullmsg="不可为空">
                            <span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> 此处数量请认真填写,请勿频繁增加数量！</span>
                        </div>

                        <div class="form-group">
                            <label>修改价格:</label>
                            <input type="number" name="price"  id="price" placeholder="增加库存(填写数字不能小于0)" class="col-sm-6 form-control" datatype="*" nullmsg="不可为空">
                            <span class="help-block m-b-none" style="color: black"><i class="fa fa-info-circle"></i> 如果修改,请填写实际价格！</span>
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
            var num=$(this).attr('data-num');
            var goods_id=$("#goods_id").val();
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此规格吗？',
                ok: function () {
                    $.ajax({
                        url: "/goods/goods-delete-spec",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,
                            'goods_id':goods_id,
                            'num':num,
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
       
        
        
    //增加库存 
  $(".goods").click(function() {
    var aid = $(this).attr('data-id');
    var gid = $(this).attr('data-goods_id');
    var price = $(this).attr('data-price');
     $('#goodsId').val(aid);
     $('#goods_id_id').val(gid);
     $('#price').val(price);
  });
       
       
    $("#add").click(function() {
    $(".myform").ajaxSubmit({
        url:"/goods/add-permissions",
        type:"post",
        dataType:"json",
         success: function (data) {
            if(data.status === 1) {
                dialog({content: data.info}).showModal();
                setTimeout(function (){
                    window.location.reload();
                }, 800);
                 window.location.reload();
            }else{ 
            dialog({title: "提示",content: data.info,ok: true}).showModal();
            } 
        }
    });
});
JS;
$this->registerJs($js);
?>
</body>