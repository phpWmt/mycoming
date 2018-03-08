<?php
/* @var $this yii\web\View */
use backend\assets\AppAsset;
use yii\bootstrap\Alert;
AppAsset::addJs($this,'/js/jquery.leoweather.min.js');

if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}
?>
<!--文本编辑器-->
<link rel="stylesheet" type="text/css" href="/css/plugins/markdown/bootstrap-markdown.min.css" />

<style>
    #myarticle{
        width:100%;
        height:430px;
        overflow-y:hidden;
        margin:20px auto;
    }
    p{
        text-indent: 2em;
        margin-bottom: 10px;
    }
    /*button{*/
        /*width:700px;*/
        /*margin:10px auto;*/
        /*text-align: center;*/
        /*display: none;*/
    /*}*/
</style>
<!--图形插件-->
<link href="/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">

<script src="/js/echarts.js"></script>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-5 ui-sortable">
<!--            客户统计-->
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">今天</span>
                    <h3><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;客户统计</h3>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-4">
                            <h1 class="no-margins">&nbsp;&nbsp;<?php echo $dayCount?></h1><br/>
                            <div class="font-bold text-navy"><?php echo $dayCount?>% <i class="fa fa-level-up"></i>
                                <small>今日新增</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h1 class="no-margins">&nbsp;&nbsp;<?php echo $monthCount?></h1><br/>
                            <div class="font-bold text-navy"><?php echo $monthCount?>% <i class="fa fa-level-up"></i>
                                <small>本月新增</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h1 class="no-margins">&nbsp;&nbsp;<?php echo $totalCount?></h1><br/>
                            <div class="font-bold text-navy"><?php echo $totalCount?>% <i class="fa fa-level-up"></i>
                                <small>客户总数</small>
                            </div>
                        </div>
                    </div>


                </div>
            </div>




            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="glyphicon glyphicon-home"></i>&nbsp;仓库统计</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link ui-sortable">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="index.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins">&nbsp;&nbsp;<?php echo $freezeCount?></h1>
                            <div class="font-bold text-navy"><?php echo $freezeCount?>% <i class="fa fa-level-up"></i>
                                <small>已冻结仓库</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h1 class="no-margins">&nbsp;&nbsp;<?php echo $EntrepotCount?></h1>
                            <div class="font-bold text-navy"><?php echo $EntrepotCount?>% <i class="fa fa-level-up"></i>
                                <small>已注册仓库</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>




            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="glyphicon glyphicon-fullscreen"></i>&nbsp;财物统计</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link ui-sortable">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="index.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins">¥ <?php echo $orderMoney?></h1></br>
                            <div class="font-bold text-navy"><?php echo $orderMoney?>% <i class="fa fa-level-up"></i>
                                <small>销售总额</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h1 class="no-margins"><?php echo $orderPay?></h1></br>
                            <div class="font-bold text-navy"><?php echo $orderPay?>% <i class="fa fa-level-up"></i>
                                <small>实收金额</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right btn-rounded" data-toggle="modal" data-target="#add_per"><i class="glyphicon glyphicon-time"></i>&nbsp;发布系统通知</span>
                    <h4><i class="glyphicon glyphicon-tasks"></i>&nbsp;系统通知</h4>
                </div>
                <div class="ibox-content">

                    <div id="myarticle">
                        <div class="feed-activity-list">
                        <?php if (!empty($userInfo)):foreach ($userInfo as $value):?>
                            <div class="feed-element">
                                <a href="<?php echo \yii\helpers\Url::to(['user/search','keyword'=>$value['user']['nickname']])?>" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php echo Yii::$app->params['API_HOST'].$value['user']['cover']?>">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">
                                        <i class="glyphicon glyphicon-time"></i>&nbsp;
                                        <?php \backend\models\Order::return_time($value['addTime'])?>
                                    </small>
                                    <strong><?php echo $value['user']['nickname']?></strong> &nbsp;<?php echo $value['title']?> <br>
                                    <small class="text-muted"> <?php echo $value['addTime']?></small>
                                    <div class="well">
                                        <?php echo $value['info']?>
                                    </div>
                                    <div class="pull-right">
                                        <?php if($value['read'] == 0):?>
                                        <a class="btn btn-xs btn-danger btn-outline btn-rounded">
                                            <i class="glyphicon glyphicon-edit"></i> 未读</a>&nbsp;&nbsp;
                                        <?php else:?>
                                        <a class="btn btn-xs btn-info btn-outline btn-rounded">
                                            <i class="glyphicon glyphicon-share"></i> 已读</a>
                                        <?php endif;?>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach;endif;?>

                        </div>
                    </div>

                    <button  id='btn' class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> 加载更多</button>
                </div>
            </div>


        </div>




        <!--    订单统计    -->
        <div class="col-sm-7 ui-sortable">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h4><i class="glyphicon glyphicon-briefcase"></i>&nbsp;订单统计</h4>
                </div>
                <div class="ibox-content" >

                    <!--    统计图容器                 -->
                    <div id="main" style="width: 800px;height:410px;"></div>

                </div>
            </div>

        </div>

        <!--    销售统计    -->
        <div class="col-sm-7 ui-sortable">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h4><i class="glyphicon glyphicon-calendar"></i>&nbsp;销量统计</h4>
                </div>
                <div class="ibox-content">

                    <!--    统计图容器                 -->
                    <div id="main1" style="width: 800px;height:508px;"></div>

                </div>
            </div>

        </div>

    </div>


<!--系统通知-->
<div class="modal inmodal" id="add_per" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span>
                </button>
                <i class="fa fa-clock-o modal-icon"></i>
                <h4 class="modal-title">系统通知</h4>
            </div>
            <form action="<?php echo \yii\helpers\Url::to(['index/notice'])?>" method="post">
                <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">

                <small class="font-bold">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="title"  placeholder="例如：优惠活动" class="col-sm-8 form-control" required>
                        </div>
                    </div>
                </small>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <textarea name="content" data-provide="markdown" rows="10" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">发布通知</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--系统通知-->





<!--订单统计-->
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    var option = {
        tooltip: {
            trigger: 'axis'
        },
        toolbox: {
            show: true,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: [<?php echo $today_order_month?>]
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value}'
            }
        },
        series: [
            {
                name:'订单总数',
                type:'line',
                data:[<?php echo $today_order_start?>],
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
                markLine: {
                    data: [
                        {type: 'average', name: '平均值'}
                    ]
                }
            },
        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>



<!--销量统计-->
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main1'));

    // 指定图表的配置项和数据
    var option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        },
        toolbox: {
            feature: {
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        legend: {
            data:['订单金额','实际收入']
        },
        xAxis: [
            {
                type: 'category',
                data: [<?php echo $today_sales_month?>],
                axisPointer: {
                    type: 'shadow'
                }
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: '',
                min: 0,
                max: <?php echo $salesCount?>,
                interval: <?php echo $salesCount/8?>,
                axisLabel: {
                    formatter: '{value}'
                }
            },

        ],
        series: [
            {
                name:'订单金额',
                type:'bar',
                data:[<?php echo $today_sales_price?>]
            },
            {
                name:'实际收入',
                type:'bar',
                data:[<?php echo $today_sales_pay_money?>]
            },
        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>

<!--文本编辑器-->
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/js/content.min.js?v=1.0.0"></script>
<script type="text/javascript" src="/js/plugins/markdown/markdown.js"></script>
<script type="text/javascript" src="/js/plugins/markdown/to-markdown.js"></script>
<script type="text/javascript" src="/js/plugins/markdown/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/js/plugins/markdown/bootstrap-markdown.zh.js"></script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
<?php
$js=<<<JS
     $(document).ready(
        function()
        {
            /**
            *1.delay函数是jquery 1.4.2新增的函数
            *2.hide函数里必须放一个0,不然延时不起作用
            */
            $('#divids').delay(4000).hide(0);
        }
    );
JS;
$this->registerJs($js);
?>

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


</body>
