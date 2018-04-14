$(document).ready(function(){  
    myVar = setTimeout(showPage, 3000);
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "pie",
        "theme": "light",
        "innerRadius": "40%",
        "gradientRatio": [-0.4, -0.4, -0.4, -0.4, -0.4, -0.4, 0, 0.1, 0.2, 0.1, 0, -0.2, -0.5],
        "dataProvider": [{
            "type": "Texto",
            "score": '<?php echo count($textResult);?>'
        }, {
            "type": "Maquetación",
            "score": '<?php echo count($designResult);?>'
        }],
        "balloonText": "[[value]]",
        "valueField": "score",
        "titleField": "type",
        "balloon": {
            "drop": true,
            "adjustBorderColor": false,
            "color": "#FFFFFF",
            "fontSize": 16
        },
        "export": {
            "enabled": false
        }
    });
    
});