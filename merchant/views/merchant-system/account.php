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
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>账号信息</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="myform form-horizontal" action="<?php echo Url::to(['merchant-system/account'])?>" method="post">
                            <input type="hidden" name="_csrf-merchant" value="<?= Yii::$app->request->csrfToken ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">管理员：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="$list" name="username" value="<?php echo $list['username']?>" placeholder="请填写仓库名称！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">姓名：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="name"  value="<?php echo $list['name']?>" placeholder="请填写仓库电话！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone"  value="<?php echo $list['phone']?>" placeholder="请填写仓库电话！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码：</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control"  name="psd" value="<?php echo $list['password']?>">

                                    <input type="text" class="form-control"  name="password" placeholder="请填写新密码！" >
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-8 text-center">
                                    <button class="btn btn-primary m-r-md" id="add_article" type="submit">保存内容</button>
                                    <a class="btn btn-white" >取消</a>
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