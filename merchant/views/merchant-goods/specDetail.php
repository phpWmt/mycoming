<?php
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
                    <h5><i class="glyphicon glyphicon-arrow-up"></i>&nbsp;增加库存</h5>
                </div>
                <div class="ibox-content">
                    <form class="myform form-horizontal" action="<?php echo Url::to(['merchant-goods/spec-increase'])?>" method="post">
                        <input type="hidden" name="_csrf-merchant" value="<?= Yii::$app->request->csrfToken ?>">

                        <!-- 仓库规格ID-->
                        <input type="hidden" name="entrepot_spec_id" value="<?php echo $id?>">

                        <!-- 商品库规格ID-->
                        <input type="hidden" name="goods_spec_id" value="<?php echo $goods_id?>">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">仓库名称：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="entrepot_name"   readonly value="<?php echo $list['entrepot']['entrepot_name']?>"  placeholder="请填写仓库名称！" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品名称：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone"   readonly value="<?php echo $list['goods']['title']?>" placeholder="请填写仓库电话！" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">规格：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly value="<?php echo $list['sepc']?>" id="entrepot_address"  placeholder="请填写仓库详细地址！" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">入库总数量：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly value="<?php echo $list['total_num']?>" id="entrepot_address"  placeholder="请填写仓库详细地址！" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">价格：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" readonly  value="<?php echo $list['price']?>" id="entrepot_address"  placeholder="！" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">&nbsp;&nbsp;</label>
                            <div class="col-sm-9">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>



                        <input type="hidden" class="form-control" id="inputValue" value="<?php echo $list['num']?>">


                        <div class="form-group" style="color: #0a6aa1">
                            <label class="col-sm-2 control-label">商品库-该规格剩余数量：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control"  style="color: black" value="<?php echo $specNum?>" id="specNum" readonly  placeholder="增加库存数量" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group" style="color: #0a6aa1">
                            <label class="col-sm-2 control-label">仓库-该规格剩余数量：</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" style="color: black" value="<?php echo $list['num']?>" readonly  placeholder="增加库存数量" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group" >
                            <label class="col-sm-2 control-label" style="color: #0a6aa1">仓库-该规格新增数量：</label>
                            <div class="col-sm-9">
                                <input type="number" style="color: black" class="form-control" id="input"   id="entrepot_address" name="number" placeholder="增加库存数量" required>
                                <span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> 新增库存<b>(不可大于商品库该规格剩余数量&nbsp;<?php echo $specNum?>)</b></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary m-r-md" id="add_article" type="submit">保存内容</button>
                                <a class="btn btn-white" href="<?php echo Url::to(['merchant-warehouse/index']) ?>">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script>
    var input=document.getElementById("input");
    var inputValue = document.getElementById("inputValue").value;
    var specNum = document.getElementById("specNum").value;
    input.onblur=function(){
        if(parseFloat(input.value) < 0){
            dialog({title: '友情提示', content: "输入的值不允许小于0", ok: true}).showModal();
            input.value="";
        }
        if(parseFloat(input.value) > specNum){
            dialog({title: '友情提示', content: "输入的值不允许大于"+specNum, ok: true}).showModal();
            input.value="";
        }
    };
</script>
