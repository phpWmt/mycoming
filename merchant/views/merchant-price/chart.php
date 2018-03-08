<?php
/* @var $this yii\web\View */
use backend\assets\AppAsset;
AppAsset::addJs($this,'/js/jquery.leoweather.min.js');

?>
<!--图形插件-->
<link href="/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">

<script src="/js/echarts.js"></script>

<body class="gray-bg">
<div class="wrapper wrapper-content">



    <div class="row">
        <!--    财务订单统计    -->
        <div class="col-sm-6 ui-sortable">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="glyphicon glyphicon-briefcase"></i>&nbsp;财务订单统计</h3>
                </div>
                <div class="ibox-content" >

                    <!--    统计图容器                 -->
                    <div id="main" style="width: 1000px;height:600px;"></div>

                </div>
            </div>

        </div>


        <!--    财务实收金额统计    -->
        <div class="col-sm-6 ui-sortable">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="glyphicon glyphicon-briefcase"></i>&nbsp;财务实收金额统计</h3>
                </div>
                <div class="ibox-content" >

                    <!--    统计图容器                 -->
                    <div id="main1" style="width: 1000px;height:600px;"></div>

                </div>
            </div>

        </div>
    </div>


    <!--订单统计-->
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data:[<?php echo $today_order_month?>]
            },
            series: [
                {
                    name:'订单金额',
                    type:'pie',
                    radius: ['50%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:<?php echo $today_order_start?>
                }
            ]
        };


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>


    <!--订单统计-->
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main1'));

        // 指定图表的配置项和数据
        var option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data:[<?php echo $today_order_month?>]
            },
            series: [
                {
                    name:'实收金额',
                    type:'pie',
                    radius: ['50%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:<?php echo $today_order_pay_money?>
                }
            ]
        };



        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>

</body>
