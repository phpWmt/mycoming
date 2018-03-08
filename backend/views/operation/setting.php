<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/7
 * Time: 13:12
 */

use yii\widgets\ActiveForm;

$css = <<<CSS
.setting_logo{
    width: 50px;
    height: 40px;
}
CSS;
$this->registerCss($css);
?>
<?= \common\widgets\Alert::widget() ?>
<div class="col-sm-12">
    <div class="panel blank-panel">
        <div class="panel-heading">
            <div class="panel-title m-b-md">
                <h3><i class="fa fa-cog">　</i>站点设置</h3>
            </div>
            <div class="panel-options">

                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <form role="form" method="post"
                                  action="<?php echo \yii\helpers\Url::to(['operation/setting']) ?>"
                                  enctype="multipart/form-data" class="form-horizontal">
                                <input name="_csrf-backend" type="hidden" id="_csrf"
                                       value="<?= Yii::$app->request->csrfToken ?>">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">网站LOGO:</label>
                                    <div class="col-sm-10 file-pretty">
                                        <input type="file" class="form-control" name="logo">
                                        <?php if ($site['logo'] !=''): ?>
                                            <img src="<?php echo $site['logo'] ?>" width="100px" height="70px">
                                        <?php endif ?>
                                    </div>


                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">站点名称:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="<?php echo $site['name'] ?>"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">联系方式:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="contact" value="<?php echo $site['contact'] ?>"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit">保存内容</button>
                                        <button class="btn btn-white" type="button">取消</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('.file-pretty input[type="file"]').prettyFile();
JS;
$this->registerJs($js);
?>


