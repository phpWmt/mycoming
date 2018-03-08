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
                    <h3><i class="fa fa-cart-plus">　</i>出入库明细</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form method="get">
                                <div class="input-group list-group" style="float:left; margin-right: 10px;">
                                        <span style="float:left;">
                                            <select class="form-control" name="status">
                                            <option value="">出库/入库</option>
                                                    <option value="1" >出库</option>
                                                    <option value="2" >入库</option>
                                            </select>
                                        </span>
                                </div>

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="start_time" placeholder="开始时间"
                                           class="input-sm form-control time">
                                </div>

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" id="time" name="end_time" placeholder="结束时间"
                                           class="input-sm form-control time">
                                </div>


                                <div class="input-group list-group col-sm-2">
                                    <input type="text" name="keyword" placeholder="请输入出入库编号" class="input-sm form-control">
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
                                <th class="text-center"><b>编码</b></th>
                                <th class="text-center"><b>商品</b></th>
                                <th class="text-center"><b>规格</b></th>
                                <th class="text-center"><b>所属仓库</b></th>
                                <th class="text-center"><b>出库/入库</b></th>
                                <th class="text-center"><b>数量</b></th>
                                <th class="text-center"><b>出入库/后数量</b></th>
                                <th class="text-center"><b>出入库类型</b></th>
                                <th class="text-center"><b>出入库时间</th>
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
                                    <td align="center" style="color: black"><?php echo($v["number"]); ?></td>
                                    <td align="center"><a href="<?php echo Url::to(['merchant-goods/list','keyword'=>$v["goods"]['title']])?>"><?php echo($v["goods"]['title']); ?></a></td>
                                    <td align="center">
                                        <a href="<?php echo Url::to(['merchant-goods/look-spec','spec'=> $v['spec']])?>" class="btn btn-info btn-outline btn-xs btn-rounded goods">查看规格</a>
                                    </td>

                                    <td align="center"><a href="#"><?php echo($v['entrepot']["entrepot_name"] ? $v['entrepot']["entrepot_name"] : "<button class='btn btn-warning btn-rounded btn-outline btn-xs'>总仓库</button>" ); ?></a></td>

                                    <?php if($v["status"] == 1):?>
                                        <td align="center">
                                            <a class="btn btn-warning btn-rounded btn-outline btn-xs">出库</a>
                                        </td>
                                    <?php else:?>
                                        <td align="center">
                                            <a class="btn btn-success btn-rounded btn-outline btn-xs">入库</a>
                                        </td>
                                    <?php endif;?>


                                    <?php if($v["status"] == 1):?>
                                        <td align="center"><?php echo($v["num"]); ?></td>
                                    <?php else:?>
                                        <td align="center"><?php echo($v["add_num"]); ?></td>
                                    <?php endif;?>

                                    <td align="center">
                                        <a class="btn btn-default btn-rounded btn-outline btn-xs"><?php echo($v["number_num"]); ?></a>
                                    </td>

                                    <td align="center"><?php echo($v["godownType"]['name']); ?></td>

                                    <td align="center"><?php echo($v["add_time"]); ?></td>


                                    <td align="center">
                                        <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-danger btn-outline btn-xs del btn-rounded"><i class="fa fa-trash-o"></i>&nbsp;删除</button>
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

<!--查看规格-->
<div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                </button>
                <h4 class="modal-title">查看规格列表</h4>
            </div>
            <small class="font-bold">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center" width="2%">
                                <label class="checkbox-inline i-checks">
                                    <input type="checkbox" class="all-checks">
                                </label>
                            </th>
                            <th class="text-center"><b>ID</b></th>
                            <th class="text-center"><b>规格</b></th>
                        </tr>
                        </thead>
                        <tbody>



                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
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
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此记录吗？',
                ok: function () {
                    $.ajax({
                        url: "/merchant/merchant-goods/record-delete",
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
                                window.location.reload(); 
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
        
        $('.goods').click(function () {
             var id=$(this).attr('data-goods_id');
             $("#span_spen").html(id); 
        });
JS;
$this->registerJs($js);
?>
</body>