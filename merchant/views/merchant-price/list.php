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
                    <h3><i class="fa fa-cart-plus">　</i>财务列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form method="get">

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="start_time" placeholder="开始时间" class="input-sm form-control time">
                                </div>
                                <div class="input-group list-group col-sm-2">
                                    <input type="text" id="time" name="end_time" placeholder="结束时间" class="input-sm form-control time">
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
                                       &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th class="text-center"><b>订单金额</b></th>
                                <th class="text-center"><b>实收金额</b></th>
                                <th class="text-center"><b>支付方式</b></th>
                                <th class="text-center"><b>下单时间</b></th>
                                <th class="text-center"><b>发货时间</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($list)): foreach ($list as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <b><?php echo($v["id"]); ?></b>
                                    </td>
                                    <td align="center"><?php echo($v["price"]); ?></td>
                                    <td align="center"><?php echo($v["pay_money"]); ?></td>
                                    <td align="center">
                                        <?php if($v['payment'] == 0):?>
                                            线下支付
                                        <?php elseif ($v['payment'] == 1):?>
                                            支付宝
                                        <?php else:?>
                                            微信
                                        <?php endif;?>
                                    </td>
                                    <td align="center"><?php echo($v["create_time"]); ?></td>
                                    <td align="center"><?php echo($v["update_time"]); ?></td>

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
            
            //批量删除
            $("#delete_all").click(function () {
            var id='';
            $('input[name="check"]:checked').each(function (i, obj) {
                id=$(obj).val()+','+id;
            });
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: "您确定要批量删除这些商品吗？删除此商品<b>入库商品</b>也将被删除！<br/><b>删除后.不可恢复。</b>",
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
                content: '您确定要将此商品放入回收站吗？',
                ok: function () {
                    $.ajax({
                        url: "/merchant/merchant-goods/update-delete",
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