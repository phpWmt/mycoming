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
                    <h3><i class="fa fa-cart-plus">　</i>库存列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 p-m">
                            <form method="get">
                                <div class="input-group list-group" style="float:left; margin-right: 10px;">
                                        <span style="float:left;">
                                            <select class="form-control" name="entrepot_id">
                                            <option value="">仓库选择</option>
                                                <?php if(is_array($entrepot)&&!empty($entrepot)): foreach ($entrepot as $k=>$v):?>
                                                    <option value="<?php echo $v['id']; ?>"><?php echo $v['entrepot_name'] ?></option>
                                                <?php endforeach;endif;?>
                                            </select>
                                        </span>
                                </div>

                                <div class="input-group list-group" style="float:left;margin-right:10px;">
                                    <input type="text" name="spec" placeholder="请输入规格名称检索" class="input-sm form-control">
                                </div>

                                <div class="input-group list-group col-sm-2">
                                    <input type="text" name="keyword" placeholder="请输入商品名称检索"
                                           class="input-sm form-control">
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
                                <th class="text-center"><b>商品名称</b></th>
                                <th class="text-center"><b>规格</b></th>
                                <th class="text-center"><b>所属仓库</b></th>
                                <th class="text-center"><b>商品单价</b></th>
                                <th class="text-center"><b>剩余库存</b></th>
                                <th class="text-center"><b>入库库存</th>
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
                                    <td align="center"><a href="<?php echo Url::to(['goods/list','keyword'=>$v["goods"]['title']])?>"><?php echo($v['goods']["title"]); ?></a></td>

                                    <td align="center" >
                                        <a style="color: black" class="btn btn-default btn-rounded btn-outline btn-xs" href="#"> <b><?php echo(str_replace(",","&nbsp;&nbsp;|&nbsp;&nbsp;",$v["sepc"])); ?></b></a>
                                    </td>



                                    <td align="center">
                                        <a class="btn btn-default btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['warehouse/index','keyword'=>$v['entrepot']["entrepot_name"]])?>"><i class="glyphicon glyphicon-home"></i>&nbsp;<?php echo($v["entrepot"]['entrepot_name']); ?></a>
                                    </td>

                                    <td align="center"><?php echo($v["price"]); ?></td>


                                    <td align="center">
                                        <a class="btn btn-default btn-rounded btn-outline btn-xs" href="#"><b><?php echo($v["num"]); ?></b></a>
                                    </td>


                                    <td align="center"><?php echo($v["total_num"]); ?></td>


                                    <td align="center">

<!--                                        <a href="--><?php //echo Url::to(['goods/spec-increase','id'=>$v['id']]) ?><!--">-->
                                        <a href="<?php echo Url::to(['goods/spec-increase','Add_id'=>$v['id'],'return'=>'status'])?>">
                                            <button type="button" class="btn btn-info btn-outline btn-xs btn-rounded"><i class="glyphicon glyphicon-arrow-up"></i>&nbsp;增加库存</button>
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
                content: '您确定要删除此商品吗？',
                ok: function () {
                    $.ajax({
                        url: "/goods/delete",
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