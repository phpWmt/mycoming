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
                        <h5>修改仓库</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="myform form-horizontal" action="<?php echo Url::to(['warehouse/editor'])?>" method="post">
                            <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="id" value="<?php echo $id?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">仓库名称：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="$list" name="entrepot_name" value="<?php echo $list['entrepot_name']?>" placeholder="请填写仓库名称！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">仓库电话：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone"  value="<?php echo $list['phone']?>" placeholder="请填写仓库电话！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">仓库地址：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="entrepot_address"  value="<?php echo $list['entrepot_address']?>" name="entrepot_address" placeholder="请填写仓库详细地址！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-9">
                                    <a href="http://lbs.amap.com/console/show/picker" target="_blank">高德地图获取经纬度</a>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">仓库经度：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="location" name="lng"  value="<?php echo $list['lng']?>" placeholder="例如:(109.003378,34.248559)" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">仓库纬度：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="location" name="lat" value="<?php echo $list['lat']?>" placeholder="例如:(109.003378,34.248559)" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-primary m-r-md" id="add_article" type="submit">保存内容</button>
                                    <a class="btn btn-white" href="<?php echo Url::to(['warehouse/index']) ?>">取消</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
<?php
$js=<<<JS
$("#add_article").on('click',function() {
    var name= $('#entrepot_name').val();
    var address= $('#entrepot_address').val();
    var locations= $('#location').val();
    if(name == ''){
      dialog({title: '友情提示', content: "仓库名称不能为空！", ok: true}).showModal();  
    }else if(address == ''){
      dialog({title: '友情提示', content: "仓库地址不能为空！", ok: true}).showModal();  
    }else if(locations == ''){
      dialog({title: '友情提示', content: "仓库经纬度不能为空！", ok: true}).showModal();  
    }else {
        return true;
    }
    
});
JS;
$this->registerJs($js);
?>