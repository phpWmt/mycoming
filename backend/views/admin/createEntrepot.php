<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>添加仓库管理员</h3>
                </div>
                <div class="ibox-content">
                    <?php
                    $form = ActiveForm::begin([
                        'action' => Url::to(['admin/create-entrepot']),       //此处为请求地址 Url用法查看手册
                        'options' => ['class' => 'myform form-horizontal', 'method' => 'post','id'=>'manager_create'],
                        'validateOnBlur'=>false,//关闭失去焦点验证
                        'enableAjaxValidation'=>true, //开启Ajax验证
                        'fieldConfig'=>[
                            'template'=>'{label}<div class="col-sm-4">{input}{error}</div><div class="hr-line-dashed"></div>',
                            'labelOptions'=>['class'=>'col-sm-2 control-label']
                        ],
                    ]);
                    ?>

                    <?= $form->field($model, 'username')->textInput(['placeholder' => '用户名4-16个字符'])->label('账号:') ?>

                    <?= $form->field($model, 'name')->textInput(['placeholder' => '姓名'])->label('姓名:') ?>

                    <?= $form->field($model, 'phone')->textInput(['placeholder' =>'手机号'])->label('手机号:') ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码'])->label('密码:') ?>

                    <?= $form->field($model, 'password2')->passwordInput(['placeholder' => '确认密码'])->label('确认密码:') ?>

                    <?= $form->field($model, 'entrepot')->dropDownList($list, ['prompt'=>'请选择']) ?>

                    <?= $form->field($model, 'type')->hiddenInput(['value'=>2]) ?>

                    <div class="form-group">
                        <div class="col-sm-6 text-center">
                            <?php echo Html::submitButton('保存内容', ['class' => 'btn btn-primary m-r-md btn_save']) ?>
                            <a class="btn btn-white" href="<?php echo Url::to(['admin/list']) ?>">取消</a>
                        </div>
                    </div>
                    <div class="form-group">&nbsp;</div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


