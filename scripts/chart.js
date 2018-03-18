$(document).ready(function(){  
    myVar = setTimeout(showPage, 3000);
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "pie",
        "theme": "light",
        "innerRadius": "40%",
        "gradientRatio": [-0.4, -0.4, -0.4, -0.4, -0.4, -0.4, 0, 0.1, 0.2, 0.1, 0, -0.2, -0.5],
        "dataProvider": [{
            "type": "Texto",
            "score": 80
        }, {
            "type": "Maquetación",
            "score": 20
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