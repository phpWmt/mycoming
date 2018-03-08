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
                        <h5>修改用户</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="myform form-horizontal" action="<?php echo Url::to(['user/update'])?>" method="post"  enctype="multipart/form-data">
                            <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="id" value="<?php echo $id?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户头像：</label>
                                <div class="col-sm-9">
                                    <div  id="ic" class="icon" style="height:50%;padding: 0px;border: none" onclick="document.getElementById('upload').click()">
                                        <input type="file" id="upload" style="display: none;"  name="files" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">
                                        <img id="myImage" src="<?php echo Yii::$app->params['API_HOST'].$list['cover']?>" style="height: 30%;width: 30%;border-radius: 5px" title="点击上传图片" >
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">手机号：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="phone" value="<?php echo $list['phone']?>" placeholder="请填写仓库名称！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">昵称：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nickname" value="<?php echo $list['nickname']?>" placeholder="请填写仓库电话！" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <div class="col-sm-6 text-center">
                                    <button class="btn btn-primary m-r-md" id="add_article" type="submit">保存内容</button>
                                    <a class="btn btn-white" href="<?php echo Url::to(['user/list']) ?>">取消</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",})});
    </script>

    <script>
        $(document).ready(function(){var updateOutput=function(e){var list=e.length?e:$(e.target),output=list.data("output");if(window.JSON){output.val(window.JSON.stringify(list.nestable("serialize")))}else{output.val("浏览器不支持")}};$("#nestable").nestable({group:1}).on("change",updateOutput);$("#nestable2").nestable({group:1}).on("change",updateOutput);updateOutput($("#nestable").data("output",$("#nestable-output")));updateOutput($("#nestable2").data("output",$("#nestable2-output")));$("#nestable-menu").on("click",function(e){var target=$(e.target),action=target.data("action");if(action==="expand-all"){$(".dd").nestable("expandAll")}if(action==="collapse-all"){$(".dd").nestable("collapseAll")}})});
    </script>
    <?php
    $js = <<<JS
            //页面加载执行
            $(function(){ 
                $('.hides').click();
            });
    
            //技能图片编辑
            $('#upload').on('change',function (event)
        
            {
        
                console.log(event.target.files);
        
                var allLen=event.target.files.length;
        
                if(allLen >1){
        
                    alert('图片不能多于6张');
        
                    return false;
        
                }
        
                var html = "";
        
                for(var i=0; i<allLen; i++){
        
                    var tmppath = window.webkitURL.createObjectURL(event.target.files[i]);
        
        
                    html+='<img src="'+tmppath+'" alt="" title="点击上传图片"  style="width:30%; height:30%;border-radius: 5px;cursor: pointer;">';
        
                }
        
                $(this).parent('div').find('img').remove();
                $(this).parent('div').append(html);
                //$("#inform_show_img").html(html);
        
            });

JS;
    $this->registerJs($js);
    ?>
</body>
