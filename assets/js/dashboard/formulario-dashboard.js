var baseUrl = $(".base-url").val();

$(function () {

    //     var chartDom = document.getElementById('largeChart');
    //     var myChart = echarts.init(chartDom);
    //     var option;

    //     option = {
    //         tooltip: {
    //             trigger: 'item'
    //         },
    //         legend: {
    //             top: '5%',
    //             left: 'center'
    //         },
    //         series: [
    //             {
    //                 name: 'Access From',
    //                 type: 'pie',
    //                 radius: ['40%', '70%'],
    //                 avoidLabelOverlap: false,
    //                 label: {
    //                     show: false,
    //                     position: 'center'
    //                 },
    //                 emphasis: {
    //                     label: {
    //                         show: true,
    //                         fontSize: 40,
    //                         fontWeight: 'bold'
    //                     }
    //                 },
    //                 labelLine: {
    //                     show: false
    //                 },
    //                 data: [
    //                     { value: 1048, name: 'Search Engine' },
    //                     { value: 735, name: 'Direct' },
    //                     { value: 580, name: 'Email' },
    //                     { value: 484, name: 'Union Ads' },
    //                     { value: 300, name: 'Video Ads' }
    //                 ]
    //             }
    //         ]
    //     };

    //     myChart.setOption(option);

    $('.btn-troca-dashboard').on('click', function () {
        let nomeDashboard = $(this).data('nome-dashboard');
        
        $('.dashboard-atual').text(nomeDashboard);
    });
    
});



