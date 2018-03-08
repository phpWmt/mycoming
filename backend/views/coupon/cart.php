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
        <!--    订单统计    -->
        <div class="col-sm-12 ui-sortable">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h4><i class="glyphicon glyphicon-briefcase"></i>&nbsp;优惠卷统计</h4>
                </div>
                <div class="ibox-content" >

                    <!--    统计图容器                 -->
                    <div id="main" style="width: 1000px;height:600px;"></div>

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
                data:[<?php echo $today_order_ends?>]
            },
            series: [
                {
                    name:'访问来源',
                    type:'pie',
                    selectedMode: 'single',
                    radius: [0, '30%'],

                    label: {
                        normal: {
                            position: 'inner'
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:<?php echo $couponYes?>, name:'已使用', selected:true},
                        {value:<?php echo $couponNo?>, name:'未使用'},
                        {value:<?php echo $couponMoney?>, name:'已发放总金额'}
                    ]
                },
                {
                    name:'已发放金额',
                    type:'pie',
                    radius: ['40%', '55%'],
                    label: {
                        normal: {
                            formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                            backgroundColor: '#eee',
                            borderColor: '#aaa',
                            borderWidth: 1,
                            borderRadius: 4,
                            // shadowBlur:3,
                            // shadowOffsetX: 2,
                            // shadowOffsetY: 2,
                            // shadowColor: '#999',
                            // padding: [0, 7],
                            rich: {
                                a: {
                                    color: '#999',
                                    lineHeight: 22,
                                    align: 'center'
                                },
                                // abg: {
                                //     backgroundColor: '#333',
                                //     width: '100%',
                                //     align: 'right',
                                //     height: 22,
                                //     borderRadius: [4, 4, 0, 0]
                                // },
                                hr: {
                                    borderColor: '#aaa',
                                    width: '100%',
                                    borderWidth: 0.5,
                                    height: 0
                                },
                                b: {
                                    fontSize: 16,
                                    lineHeight: 33
                                },
                                per: {
                                    color: '#eee',
                                    backgroundColor: '#334455',
                                    padding: [2, 4],
                                    borderRadius: 2
                                }
                            }
                        }
                    },
                    data:<?php echo $datajson?>
                }
            ]
        };


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>


</body>
