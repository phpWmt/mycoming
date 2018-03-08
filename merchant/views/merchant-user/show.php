<?php
use \kucha\ueditor\UEditor;
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::addJs($this, 'js/plugins/jasny/jasny-bootstrap.min.js');
AppAsset::addJs($this, '/js/plugins/dropzone/dropzone.js');
AppAsset::addJs($this, '/js/dropzone_demo.js');

AppAsset::addCss($this, '/css/plugins/dropzone/basic.css');
AppAsset::addCss($this, '/css/plugins/dropzone/dropzone.css');
AppAsset::addCss($this, 'css/plugins/jasny/jasny-bootstrap.min.css');

?>
<style>
    #myarticle{
        width:100%;
        height:500px;
        overflow-y:hidden;
        margin:20px auto;
    }
    /*p{*/
        /*text-indent: 2em;*/
        /*margin-bottom: 10px;*/
    /*}*/
    /*button{*/
        /*width:700px;*/
        /*margin:10px auto;*/
        /*text-align: center;*/
        /*display: none;*/
    /*}*/
</style>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>个人详细信息</h3>
                </div><br/>

                <div>
                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">

                        <div class="col-sm-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>个人资料</h5>
                                </div>
                                <div>
                                    <div class="ibox-content no-padding border-left-right" >
                                        <img  alt="image" class="img-responsive" src="<?php echo Yii::$app->params['API_HOST'].$lists['user']['cover']?>">
                                    </div>
                                    <div class="ibox-content profile-content">
                                        <h4><strong><?php echo $lists['user']['nickname']?></strong></h4>

                                        <p>
                                            <i class="glyphicon glyphicon-phone"></i> <?php echo $lists['user']['phone']?>
                                        </p>

                                        <p>
                                            <i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;备注：&nbsp; &nbsp;<?php echo $lists['remark'] ? $lists['remark'] : "暂无备注" ?>
                                        </p>


                                        <div class="row m-t-lg">
                                            <div class="col-sm-4">
                                                <span class="bar" style="display: none;">5,3,9,6,5,9,7,3,5,2</span><svg class="peity" height="16" width="32"><rect fill="#1ab394" x="0" y="7.111111111111111" width="2.3" height="8.88888888888889"></rect><rect fill="#d7d7d7" x="3.3" y="10.666666666666668" width="2.3" height="5.333333333333333"></rect><rect fill="#1ab394" x="6.6" y="0" width="2.3" height="16"></rect><rect fill="#d7d7d7" x="9.899999999999999" y="5.333333333333334" width="2.3" height="10.666666666666666"></rect><rect fill="#1ab394" x="13.2" y="7.111111111111111" width="2.3" height="8.88888888888889"></rect><rect fill="#d7d7d7" x="16.5" y="0" width="2.3" height="16"></rect><rect fill="#1ab394" x="19.799999999999997" y="3.555555555555557" width="2.3" height="12.444444444444443"></rect><rect fill="#d7d7d7" x="23.099999999999998" y="10.666666666666668" width="2.3" height="5.333333333333333"></rect><rect fill="#1ab394" x="26.4" y="7.111111111111111" width="2.3" height="8.88888888888889"></rect><rect fill="#d7d7d7" x="29.7" y="12.444444444444445" width="2.3" height="3.5555555555555554"></rect></svg>
                                                <h5><strong> <?php \merchant\models\User::count_shop($lists['user']['id'])?></strong> 购买数量</h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <h5><strong>&nbsp;</strong>&nbsp; </h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <span class="bar" style="display: none;">5,3,2,-1,-3,-2,2,3,5,2</span><svg class="peity" height="16" width="32"><rect fill="#1ab394" x="0" y="0" width="2.3" height="10"></rect><rect fill="#d7d7d7" x="3.3" y="4" width="2.3" height="6"></rect><rect fill="#1ab394" x="6.6" y="6" width="2.3" height="4"></rect><rect fill="#d7d7d7" x="9.899999999999999" y="10" width="2.3" height="2"></rect><rect fill="#1ab394" x="13.2" y="10" width="2.3" height="6"></rect><rect fill="#d7d7d7" x="16.5" y="10" width="2.3" height="4"></rect><rect fill="#1ab394" x="19.799999999999997" y="6" width="2.3" height="4"></rect><rect fill="#d7d7d7" x="23.099999999999998" y="4" width="2.3" height="6"></rect><rect fill="#1ab394" x="26.4" y="0" width="2.3" height="10"></rect><rect fill="#d7d7d7" x="29.7" y="6" width="2.3" height="4"></rect></svg>
                                                <h5><strong><?php \merchant\models\User::count_entrepot($lists['user']['id'])?></strong> 关注仓库</h5>
                                            </div>
                                        </div>
                                        <div class="user-button">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#add_per">
                                                        <i class="fa fa-envelope"></i> 添加备注
                                                    </button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="<?php echo Url::to(['merchant-user/list'])?>" type="button" class="btn btn-default btn-sm btn-block">
                                                        <i class="fa fa-coffee"></i> 返回
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!--  评论-->
                        <div class="col-sm-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>评论列表</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="profile.html#">
                                            <i class="fa fa-wrench"></i>
                                        </a>
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">

                                    <div>
                                        <div class="feed-activity-list" id="myarticle">

                                            <?php if(!empty($comentList)):foreach ($comentList as $value):?>
                                            <div class="feed-element">
                                                <a href="profile.html#" class="pull-left">
                                                    <img alt="image" class="img-circle" src="<?php echo Yii::$app->params['API_HOST'].$lists['user']['cover']?>">
                                                </a>
                                                <div class="media-body ">
                                                    <small class="pull-right">
                                                        <?php \merchant\models\Order::return_time($value['addTime'])?>
                                                    </small>
                                                    <strong><?php echo $lists['user']['nickname']?> <br>
                                                    <small class="text-muted"><?php echo $value['addTime']?></small>
                                                    <div class="photos">
                                                        <?php if(!empty($value['img'])):?>
                                                        <?php
                                                            $imgData =  explode(',',$value['img']);
                                                        ?>
                                                        <?php if(!empty($imgData)):foreach ($imgData as $v):?>
                                                                <a class="fancybox img-circle"  href="<?php echo Yii::$app->params['API_HOST'].$v?>" title="评论图">
                                                                    <img alt="image" src="<?php echo Yii::$app->params['API_HOST'].$v?>">
                                                                </a>
                                                        <?php endforeach;endif;?>
                                                        <?php endif;?>
                                                    </div>
                                                    <div class="well">
                                                        <?php echo $value['content']?>
                                                    </div>

                                                    <div class="pull-right">
                                                        <?php if($value['grade'] == 3):?>
                                                            <a class="btn btn-xs btn-danger btn-outline"><i class="fa fa-heart"></i> 好评</a>
                                                        <?php elseif ($value['grade'] == 2):?>
                                                            <a class="btn btn-xs btn-warning btn-outline"><i class="glyphicon glyphicon-thumbs-up"></i> 中评</a>
                                                        <?php else:?>
                                                            <a class="btn btn-xs btn-default btn-outline"><i class="glyphicon glyphicon-thumbs-down"></i> 差评</a>&nbsp;
                                                        <?php endif;?>


                                                        <?php if($value['status'] == 1):?>
                                                        <a href="<?php echo Url::to(['merchant-user/status-content','id'=>$value['id'],'status'=>0])?>" class="btn btn-xs btn-danger"><i class="fa fa-heart"></i> 隐藏</a>
                                                        <?php else: ?>
                                                        <a href="<?php echo Url::to(['merchant-user/status-content','id'=>$value['id'],'status'=>1])?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> 显示</a>
                                                        <?php endif;?>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php endforeach;endif;?>
                                        </div>

                                        <button id="btn" class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> 显示更多</button>

                                    </div>

                                </div>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </div>

</div>

<!--//添加备注-->
<div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                </button>

                <h4 class="modal-title">用户备注</h4>
            </div>
            <small class="font-bold">
                <div class="modal-body">
                    <form  class="myform" action="<?php echo Url::to(['merchant-user/remark'])?>" method="post">
                       <input type="hidden" name="id" value="<?php echo $lists['id']?>"/>
                        <input type="hidden" name="_csrf-merchant" value="<?= Yii::$app->request->csrfToken ?>">
                        <div class="form-group">
                            <?php
                            echo UEditor::widget([
                                'name' => "content",
                                'id' => 'content',
                                'clientOptions' => [
                                    'initialFrameHeight' => '250',
                                    'autoHeightEnabled'=>false,
                                    'lang' => 'zh-cn',
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                            <button type="submit" id="add" class="btn btn-primary btn_save">添加</button>
                        </div>
                    </form>
                </div>

            </small>
        </div>
    </div>
</div>

</body>
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/js/content.min.js?v=1.0.0"></script>
<script src="/js/plugins/fancybox/jquery.fancybox.js"></script>
<script>
    $(document).ready(function(){$(".fancybox").fancybox({openEffect:"none",closeEffect:"none"})});
</script>
<script>
    var btn = document.getElementById('btn');
    var obj = document.getElementById('myarticle');
    var total_height =  obj.scrollHeight;//文章总高度
    var show_height = 300;//定义原始显示高度
    if(total_height>show_height){
        btn.style.display = 'block';
        btn.onclick = function(){
            obj.style.height = total_height + 'px';
            btn.style.display = 'none';
        }

    }
</script>