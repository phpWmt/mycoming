<?php

use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/7
 * Time: 13:12
 */
$css = <<<CSS
.setting_logo{
    width: 50px;
    height: 40px;
}
CSS;
$this->registerCss($css);
?>
<div class="col-sm-12">
    <div class="panel blank-panel">
        <div class="panel-heading">
            <div class="panel-title m-b-md">
                <h3><i class="fa fa-cog">　</i>SEO 设置</h3>
            </div>
            <div class="panel-options">

                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <form action="<?php echo Url::to(['seo/update']) ?>" method="get"
                                  class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">网站域名:</label>
                                    <div class="col-sm-10 file-pretty">
                                        <input type="text" class="form-control" placeholder="请填写网站域名" name="host" value="<?php echo $seo['host'] ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">网站名称:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" placeholder="请填写网站标题" class="form-control" value="<?php echo $seo['title'] ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">SEO 关键字:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="keyword" placeholder="请填写 SEO 关键字，逗号隔开"
                                               class="form-control" value="<?php echo $seo['keyword'] ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">SEO 描述:</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" name="describe" placeholder="请填写 SEO 描述"
                                                  class="form-control"><?php echo $seo['describe'] ?></textarea>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">IPC 备案号:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ipc" placeholder="请填写 IPC 备案号" class="form-control" value="<?php echo $seo['ipc'] ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit">保存内容</button>
                                        <button class="btn btn-white" type="submit">取消</button>
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


