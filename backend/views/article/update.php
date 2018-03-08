<?php
use yii\helpers\Url;
use \kucha\ueditor\UEditor;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>修改文章</h5>
                </div>
                <div class="ibox-content">
                    <form class="myform form-horizontal" action="<?php echo Url::to(['article/create'])?>" method="post">
                        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">
                        <input type="hidden" name="id" value="<?= $data->id ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">文章标题：</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $data->title; ?>" name="title" placeholder="请填写文章标题！" required>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

<!--                        <div class="form-group">-->
<!--                            <label class="col-sm-2 control-label">所属分类：</label>-->
<!--                            <div class="col-sm-9">-->
<!--                                <select class="form-control in-block" id="cate" name="cate_id" datatype="*" nullmsg="请选择所属分类！">-->
<!--                                    --><?php //if(is_array($article_cate)&&!empty($article_cate)): foreach ($article_cate as $k=>$v):?>
<!--                                    <option value="--><?php //echo $v['id']; ?><!--">--><?php //echo $v['name'] ?><!--</option>-->
<!--                                        --><?php //if(!empty($v['children'])): foreach ($v['children'] as $k1=>$v1):?>
<!--                                            <option value="--><?php //echo $v1['id']; ?><!--">--><?php //echo '　　'.$v1['name'] ?><!--</option>-->
<!--                                            --><?php //if(!empty($v1['children'])): foreach ($v1['children'] as $k2=>$v2):?>
<!--                                                <option value="--><?php //echo $v2['id']; ?><!--">--><?php //echo '　　　　'.$v2['name'] ?><!--</option>-->
<!--                                            --><?php //endforeach;endif;?>
<!--                                        --><?php //endforeach;endif;?>
<!--                                    --><?php //endforeach;endif;?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="hr-line-dashed"></div>-->

                        <div class="form-group">
                            <label class="col-sm-2 control-label">文章内容：</label>
                            <div class="col-sm-9">
                                <?php
                                echo UEditor::widget([
                                    'name' => "content",
                                    'id' => 'content',
                                    'clientOptions' => [
                                        'initialFrameHeight' => '500',
                                        'autoHeightEnabled'=>false,
                                        'lang' => 'zh-cn',
                                        'initialContent' => $data->content,
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary m-r-md" id="add_article" type="button">保存内容</button>
                                <a class="btn btn-white" href="<?php echo Url::to(['article/list']) ?>">取消</a>
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
 $("#cate").val($data->cate_id);
$("#add_article").on('click',function() {
    $(".myform").ajaxSubmit({
        url: "/article/update",
        type: "post",
        dataType: "json",
        success: function (data) {
            if(data.status === 1) {
                dialog({content: data.info}).showModal();
                setTimeout(function () {window.location.href = data.url;}, 800);
            } else {
                dialog({title: '友情提示', content: data.info, ok: true}).showModal();
            }
        }
    });
});
JS;
$this->registerJs($js);
?>