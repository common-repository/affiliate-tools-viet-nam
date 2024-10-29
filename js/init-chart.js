var StatsByVals = [];
StatsByVals['day'] = ['7', '15','30'];
StatsByVals['month'] = ['3','6','12'];
StatsByVals['year'] = ['1'];

function load_overview_chart(label_content, data_content) {
    var barChartCanvas = document.getElementById("overview-chart").getContext("2d");
    var barChartData = {
        labels: label_content,
        datasets:[{
            label: 'Click',
            backgroundColor: '#8DB9CC',
            borderColor: '#8DB9CC',
            data: data_content,
        }]
    };
    var barChartOptions = {
        responsive: true

    };

    var barchart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions });
}

function onChangeTime() {
    
    var sel_val = scriptParams.stats_period;
    var val = document.getElementById('select_time').value;
    
    var content=`<span class='config-title'>Show date over:</span><select id=select_time_period name=stats_period style='width: 130px;'>`;

    for (var i = 0 ; i < StatsByVals[val].length ; i++ ) {
        
        content += '<option value=' + StatsByVals[val][i];
        
        if ( sel_val === StatsByVals[val][i] ) {
            content += ' selected=selected';
        }
        
        var option_value = 'Last '+ StatsByVals[val][i];
        content += '>'+ option_value +' </option>';
    }
    content+='</select>';

    document.getElementById('time_period_container').innerHTML = content;
}

function onClickBtnT(x) {
    
    if(x) {
        document.getElementById('stats_panel').style.display = '';
        document.getElementById('top10_panel').style.display = 'none';
        document.getElementById('btn_stats').style.background = 'linear-gradient(to top, #F7F7F7 , #fff )';
        document.getElementById('btn_top').style.background  = '#f2f2f2';
        document.getElementById('btn_stats').style.position = 'relative';
        document.getElementById('btn_top').style.position = 'initial';
    } else {
        document.getElementById('stats_panel').style.display = 'none';
        document.getElementById('top10_panel').style.display = '';
        document.getElementById('btn_stats').style.background = '#f2f2f2';
        document.getElementById('btn_top').style.background = 'linear-gradient(to top, #F7F7F7 , #fff )';
        document.getElementById('btn_stats').style.position = 'initial';
        document.getElementById('btn_top').style.position = 'relative';
    }

}

function onClickBtn() {
        document.getElementById('stats_panel').style.display = 'none';
        document.getElementById('top10_panel').style.display = '';
}