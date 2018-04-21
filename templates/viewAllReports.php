Отчёты
<div>
<button id="report_day">За день</button>
<button id="report_week">За неделю</button>
<button id="report_month">За месяц</button>
<button id="report_year">За год</button>
<button id="report_custom">За период</button>
</div>
<form name="report_custom" action="/App/controllers/controllerReports.php" method="GET" style="display:none">
                    <div class="form-group">
                    <label for="inputDate">Введите начальную дату:</label>
                    <input type="date" class="form-control" name="start_date">
					<label for="inputDate">Введите конечную дату:</label>
                    <input type="date" class="form-control" name="end_date">
					<input type="button" value="Вывести" id="report_by_range">
                    </div>
</form>
<div id="report_chart" style="width: 800px; height: 600px;"></div>
<script src="https://www.google.com/jsapi"></script>
<script>

   function drawChart(timeframe) {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET","App/controllers/controllerReports.php?timeframe="+timeframe,false);
	xmlHttp.overrideMimeType("text/plain; charset=utf8");
	xmlHttp.send();
	var rows=xmlHttp.responseText.split(';');
	var data=new google.visualization.DataTable();
	data.addColumn('string','Дата');
	data.addColumn('number','Чистая прибыль');
	data.addColumn('number','Доход');
	for(var i=0;i<rows.length-1;i++)
	{
		var row=rows[i].split(',');
		row[1]=parseFloat(row[1]);
		row[2]=parseFloat(row[2]);
		data.addRow(row);
	}
	var options = {
     title: 'Финансы',
     hAxis: {title: 'Время',slantedText:true,slantedTextAngle:90},
     vAxis: {title: 'грн'}
    };
	var chart = new google.visualization.ColumnChart(document.getElementById('report_chart'));
    chart.draw(data, options);
   };

function initialize(){
	document.getElementById("report_day").onclick=function(){
		document.forms.report_custom.style="display:none";
		drawChart("day");
	};
	document.getElementById("report_week").onclick=function(){
		document.forms.report_custom.style="display:none";
		drawChart("week");
	};
	document.getElementById("report_month").onclick=function(){
		document.forms.report_custom.style="display:none";
		drawChart("month");
	};
	document.getElementById("report_year").onclick=function(){
		document.forms.report_custom.style="display:none";
		drawChart("year");
	};
	document.getElementById("report_custom").onclick=function(){
		document.forms.report_custom.style="display:block";
		document.getElementById('report_chart').innerHTML="";
	};
	document.getElementById("report_by_range").onclick=function(){
		drawChart("custom&start="+document.getElementsByName("start_date")[0].value+"&end="+document.getElementsByName("end_date")[0].value);
	};
}
google.setOnLoadCallback(initialize);
google.load("visualization", "1", {packages:["corechart"]});

</script>