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
                    <h3><i class="fa fa-cart-plus">　</i>商品规格</h3>
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
                                <th class="text-center"><b>商品</b></th>
                                <th class="text-center"><b>仓库</b></th>
                                <th class="text-center"><b>规格名称</b></th>
                                <th class="text-center"><b>多规格</b></th>
                                <th class="text-center"><b>时间</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($listSpec)): foreach ($listSpec as $k => $vo): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" name="check" value="<?php echo $vo['id'] ?>">
                                        </label>
                                    </td>
                                    <td align="center"><?php echo($vo['goods']["title"]); ?></td>
                                    <td align="center"><?php echo($vo['entrepot']["entrepot_name"]); ?></td>
                                    <td align="center">
                                        <a class="btn btn-primary btn-rounded btn-outline btn-xs" > <?php echo($vo["name"]); ?></a>
                                    </td>

                                    <td align="center">
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" > <?php echo($vo["spec"]); ?></a>
                                    </td>

                                    <td align="center"><?php echo($vo["addTime"]); ?></td>

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

<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品子规格</h3>
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
                                <th class="text-center"><b>商品</b></th>
                                <th class="text-center"><b>仓库名称</b></th>
                                <th class="text-center"><b>规格</b></th>
                                <th class="text-center"><b>价格</b></th>
                                <th class="text-center"><b>剩余数量</b></th>
                                <th class="text-center"><b>入库总数量</b></th>
                                <th class="text-center"><b>入库时间</b></th>
                                <th class="text-center"><b>状态</b></th>
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

                                    <td align="center"><?php echo($v['goods']["title"]); ?></td>
                                    <td align="center"><?php echo($v['entrepot']["entrepot_name"]); ?></td>
                                    <td align="center">
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" ><?php echo($v["sepc"]); ?></a>
                                    </td>

                                    <td align="center"><?php echo($v["price"]); ?></td>
                                    <td align="center"><?php echo($v["num"]); ?></td>
                                    <td align="center"><?php echo($v["total_num"]); ?></td>
                                    <td align="center"><?php echo($v["addTime"]); ?></td>


                                    <td align="center">
                                        <?php if($v["status"] == 0):?>
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="buttons.html#">已禁用</a>
                                        <?php else:?>
                                            <a class="btn btn-info btn-rounded btn-outline btn-xs" href="buttons.html#">已启用</a>
                                        <?php endif;?>

                                    </td>

                                    <td align="center">
                                        <?php if ($v['status'] == 0):?>
                                            <a class="btn btn-info btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['merchant-warehouse/spec-status','spec_id'=>$v['id'],'status'=>1,'id'=>$id])?>"><i class="fa fa-check"></i>&nbsp;启用</a>
                                        <?php else:?>
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="<?php echo Url::to(['merchant-warehouse/spec-status','spec_id'=>$v['id'],'status'=>0,'id'=>$id])?>"><i class="glyphicon glyphicon-remove"></i>&nbsp;禁用</a>
                                        <?php endif;?>

                                        <?php if ($v['status'] != 0):?>
                                            <a href="<?php echo Url::to(['merchant-warehouse/add-inventory','Add_id'=>$v['id'],'id'=>$id])?>">
                                                <button type="button" class="btn btn-success btn-outline btn-xs btn-rounded"><i class="glyphicon glyphicon-arrow-up"></i>&nbsp;增加库存</button>
                                            </a>
                                        <?php endif;?>

                                        <button data-id="<?php echo $v['id'] ?>" href="javascript:void (0)" type="button" class="btn btn-rounded btn-danger btn-outline btn-xs del"><i class="fa fa-trash-o"></i>&nbsp;删除</button>
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
            
           
            
        //删除    
        $(".del").click(function () {
            var dele = $(this);
            var id=$(this).attr('data-id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除此规格吗？删除后不可恢复！',
                ok: function () {
                    $.ajax({
                        url: "/merchant/merchant-warehouse/spec-del",
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
    

JS;
$this->registerJs($js);
?>
</body>