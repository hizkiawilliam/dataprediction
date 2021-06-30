<!DOCTYPE html>
<html>
	<head>    
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/theme/dist/css/adminlte.min.css">
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/normalize.css">
  <link rel="stylesheet" href="<?php echo base_url();?>css/main.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/theme/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<script src="<?php echo base_url();?>js/vendor/modernizr-2.6.2.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
	<style type="text/css">
	*
  {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    color: rgb(100, 100, 100);
  }
  #textload{
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    color: rgb(240, 240, 240);
  }
	#loader{
		display: none;
	}
	#progress{
		position: absolute;
		top: 50%;
		left: 50%;
		margin-right: -50%;
		transform: translate(-50%, -50%);
		padding-top: 300px;
		font-size: 30pt;
	}
	#dimmed
	{
		display: none;
		background: rgba(0,0,0,.5) no-repeat;
		width:100%;
		height:100%;
		position:fixed;
		top:0;
		left:0;
		z-index:999;
	}
  .content {
  max-width: 1500px;
  margin: auto;
  background: white;
  padding: 10px;
}
	</style>
	<title>Data Prediction Algorithms</title>
	<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.css">
	<link rel="icon" href='<?php echo base_url();?>assets/img/icon.png'>
	</head>
 
	<body class="layout-top-nav" style="height: auto;">
    <div id="dimmed">
      <div id="loader-wrapper">
        <div id="loader"></div>
        <div id="progress" class="textload"></div>
      </div>
    </div>
    <div class="wrapper">
    <header>
    <nav class="main-header navbar navbar navbar-expand-md navbar-light navbar-white mx-auto order-0"  style = "text-align: center;">
      <div class="container">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">How to use</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">About Algorithm</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
        </ul>
      </div>
    </nav>
    </header>
    <div class="content">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-4">	
              <div class="card card-yellow">
                <div class="card-header">
                  <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                    Upload Data Training 
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                <form action="<?php echo base_url();?>Control/uploadData/" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-sm-7">	
                      <input type="file" name="file" id = "upload" onchange = "enableRun()"/><br><br>
                    </div>
                    <div class="col-sm-3">	
                      <input type="range" class="form-range" min="70" max="100" step="1" id="dataRange" name="dataRange">
                      <p><span id="dataRangeValue"></span></p>
                    </div>
                  </div>
                  <input type="submit" class="btn btn-primary btn" style = "align:'center'" onclick="open_script()" id = "runScript" placeholder></input>
                </form> 
                </div>
              </div>
            </div>
            <div class="col-sm-4">	
              <div class="card card-green">
                <div class="card-header">
                  <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                    Upload Data Real
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                <form action="<?php echo base_url();?>Control/uploadDataReal/" method="post" enctype="multipart/form-data">
                  <input type="file" name="file" id = "uploadReal" onchange = "enableRun()"/><br><br>
                  <input type="submit" class="btn btn-primary btn" style = "align:'center'" onclick="open_script()" id = "runScript" ></input>
                </form> 
                </div>
              </div>
            </div>
            <div class="col-sm-4">	
              <div class="card card-red">
                <div class="card-header">
                  <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                    Delete All Data
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                <h6>Delete all recorded data and analysis</h6><br>
                <form action="<?php echo base_url();?>Control/deleteall/" method="post" enctype="multipart/form-data">
                  <input type="submit" class="btn btn-primary btn" style = "align:'center'" onclick="open_script()" id = "runScript" ></input>
                </form> 
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-12">	
              <div class="card card-blue">
                <div class="card-header">
                  <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                    Data Trend
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="chartdiv"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">	
              <div class="card card-red">
                <div class="card-header">
                  <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                    Analysis
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">	
                      <h4>Time Consumption (Second)</h4>
                      <div id="chartdiv3"></div>
                    </div>
                    <div class="col-sm-3">	
                      <h4>CPU Usage (%)</h4><br>
                      <div id="chartdiv4"></div>
                    </div>
                    <div class="col-sm-2">	
                      <h4>Ram Usage (%)</h4><br>
                      <div id="chartdiv5"></div>
                    </div>
                    <div class="col-sm-2">	
                      <h4>Error Rate (%)</h4><br>
                      <div id="chartdiv2"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">	
              <div class="card card-blue">
                <div class="card-header">
                  <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                    Accuracy (%)
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="chartdiv6"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <script> 
	var myVar;
	function enableRun() {
	  document.getElementById("runScript").disabled = false;
	}

	function open_script(){ 
		myVar = setTimeout(0);
		document.getElementById("progress").innerHTML = "Please Wait...";
		var x = document.getElementById("loader");
			x.style.display = "block";
		var y = document.getElementById("dimmed");
			y.style.display = "block";
		var z = document.getElementById("progress");
			z.style.display = "block";
	} 
	</script>
  </body>
</html>

<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 600px;
}
#chartdiv2 {
  width: 100%;
  height: 400px;
}
#chartdiv3 {
  width: 100%;
  height: 400px;
}
#chartdiv4 {
  width: 100%;
  height: 400px;
}
#chartdiv5 {
  width: 100%;
  height: 400px;
}
#chartdiv6 {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<!-- jQuery -->
<script src="<?php echo base_url();?>assets/theme/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="<?php echo base_url();?>assets/theme/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/theme/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/theme/dist/js/demo.js"></script>

<script>
var slider = document.getElementById("dataRange");
var output = document.getElementById("dataRangeValue");
output.innerHTML = slider.value + "%";

slider.oninput = function() {
  output.innerHTML = this.value + "%";
}
</script>
<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = [
 <?php if($datas["data_origin"]->result() != null) { foreach($datas["data_origin"]->result() as $key) {?>
{
  "date": "<?php echo $key->month?>",
  "value": <?php echo $key->passengers;?>,
},<?php }}?> 
<?php if($datas["data_real"]->result() != null) { foreach($datas["data_real"]->result() as $key) {?>
{
  "date": "<?php echo $key->month?>",
  "prediction_real": <?php echo $key->value;?>,
},<?php }}?> 
<?php if($datas["data_pred"]->result() != null) {foreach($datas["data_pred"]->result() as $key) {?>
{
  "date": "<?php echo $key->month?>",
  "prediction_arima":<?php echo $key->arima;?>,
  "prediction_hwes": <?php echo $key->hwes;?>,
},<?php }}?> 
];

// Set input format for the dates
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Value";
// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]"
series.name = "Data";
series.stroke = chart.colors.getIndex(1);
series.strokeWidth = 2;
series.minBulletDistance = 15;

var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "prediction_arima";
series2.dataFields.dateX = "date";
series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]"
series2.stroke = chart.colors.getIndex(6);
series2.name = "ARIMA";
series2.strokeWidth = 2;
series2.minBulletDistance = 15;

var series3 = chart.series.push(new am4charts.LineSeries());
series3.dataFields.valueY = "prediction_hwes";
series3.dataFields.dateX = "date";
series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]"
series3.stroke = chart.colors.getIndex(11);
series3.name = "HWES";
series3.strokeWidth = 2;
series3.minBulletDistance = 15;

var series4 = chart.series.push(new am4charts.LineSeries());
series4.dataFields.valueY = "prediction_real";
series4.dataFields.dateX = "date";
series4.stroke = chart.colors.getIndex(1);
series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]"
series4.name = "Real";
series4.strokeWidth = 2;
series4.minBulletDistance = 15;

// Drop-shaped tooltips
series.tooltip.background.cornerRadius = 20;
series.tooltip.background.strokeOpacity = 0;
series.tooltip.pointerOrientation = "vertical";
series.tooltip.label.minWidth = 40;
series.tooltip.label.minHeight = 40;
series.tooltip.label.textAlign = "middle";
series.tooltip.label.textValign = "middle";

series2.tooltip.background.cornerRadius = 20;
series2.tooltip.background.strokeOpacity = 0;
series2.tooltip.pointerOrientation = "vertical";
series2.tooltip.label.minWidth = 40;
series2.tooltip.label.minHeight = 40;
series2.tooltip.label.textAlign = "middle";
series2.tooltip.label.textValign = "middle";

series3.tooltip.background.cornerRadius = 20;
series3.tooltip.background.strokeOpacity = 0;
series3.tooltip.pointerOrientation = "vertical";
series3.tooltip.label.minWidth = 40;
series3.tooltip.label.minHeight = 40;
series3.tooltip.label.textAlign = "middle";
series3.tooltip.label.textValign = "middle";

series4.tooltip.background.cornerRadius = 20;
series4.tooltip.background.strokeOpacity = 0;
series4.tooltip.pointerOrientation = "vertical";
series4.tooltip.label.minWidth = 40;
series4.tooltip.label.minHeight = 40;
series4.tooltip.label.textAlign = "middle";
series4.tooltip.label.textValign = "middle";
// Make bullets grow on hover
var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

var bullet2 = series2.bullets.push(new am4charts.CircleBullet());
bullet2.circle.strokeWidth = 2;
bullet2.circle.radius = 4;
bullet2.circle.fill = am4core.color("#fff");

var bullethover2 = bullet2.states.create("hover");
bullethover2.properties.scale = 1.3;

var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
bullet3.circle.strokeWidth = 2;
bullet3.circle.radius = 4;
bullet3.circle.fill = am4core.color("#fff");

var bullethover3 = bullet3.states.create("hover");
bullethover3.properties.scale = 1.3;

var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
bullet4.circle.strokeWidth = 2;
bullet4.circle.radius = 4;
bullet4.circle.fill = am4core.color("#fff");

var bullethover4 = bullet4.states.create("hover");
bullethover4.properties.scale = 1.3;

// Make a panning cursor
chart.cursor = new am4charts.XYCursor();

// Create vertical scrollbar and place it before the value axis
chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.parent = chart.leftAxesContainer;
chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
chart.scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX.series.push(series);
chart.scrollbarX.series.push(series2);
chart.scrollbarX.series.push(series3);
chart.scrollbarX.series.push(series4);
chart.scrollbarX.parent = chart.bottomAxesContainer;



chart.legend = new am4charts.Legend();
}); // end am4core.ready()
</script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv2", am4charts.XYChart);

// Add data
chart.data = [
  <?php if($datas["analysis_error"]->result() != null) {foreach($datas["analysis_error"]->result() as $key) {?>
{
  "algo": "<?php echo $key->algo;?>",
  "value": <?php echo round($key->value,2);?>,
},<?php }}?>];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "algo";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "value";
series.dataFields.categoryX = "algo";
series.name = "Error Rate";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}%[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>


<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv3", am4charts.XYChart);

// Add data
chart.data = [
  <?php if($datas["analysis_time"]->result() != null) {foreach($datas["analysis_time"]->result() as $key) {?>
{
  "algo": "<?php echo $key->algo;?>",
  "value": <?php echo round($key->value,2);?>,
},<?php }}?>];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "algo";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "value";
series.dataFields.categoryX = "algo";
series.name = "Time Consumed";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY} Second[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv4", am4charts.XYChart);

// Add data
chart.data = [
  <?php if($datas["analysis_cpuUsage"]->result() != null) {foreach($datas["analysis_cpuUsage"]->result() as $key) {?>
{
  "algo": "<?php echo $key->algo;?>",
  "valueUsage": <?php echo round($key->value,2);?>,
},<?php }}?>
<?php if($datas["analysis_cpuMax"]->result() != null) {foreach($datas["analysis_cpuMax"]->result() as $key) {?>
{
  "algo": "<?php echo $key->algo;?>",
  "valueMax": <?php echo round($key->value,2);?>,
},<?php }}?>];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "algo";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "valueUsage";
series.dataFields.categoryX = "algo";
series.name = "CPU Usage";
series.columns.template.tooltipText = "{categoryX} Average: [bold]{valueY} %[/]";
series.columns.template.fillOpacity = .8;

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "valueMax";
series.dataFields.categoryX = "algo";
series.name = "CPU Max";
series.columns.template.tooltipText = "{categoryX} Max: [bold]{valueY} %[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>


<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv5", am4charts.XYChart);

// Add data
chart.data = [
  <?php if($datas["analysis_ram"]->result() != null) {foreach($datas["analysis_ram"]->result() as $key) {?>
{
  "algo": "<?php echo $key->algo;?>",
  "value": <?php echo round($key->value,2);?>,
},<?php }}?>];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "algo";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "value";
series.dataFields.categoryX = "algo";
series.name = "Ram Consumed";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY} %[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv6", am4charts.XYChart);

// Add data
chart.data = [
 <?php if($datas["analysis_accuracy"]->result() != null) { foreach($datas["analysis_accuracy"]->result() as $key) {?>
{
  "date": "<?php echo $key->month?>",
  "sarimax": <?php echo $key->sarimax;?>,
  "hwes": <?php echo $key->hwes;?>,
},<?php }}?>
];

// Set input format for the dates
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Percentage (%)";
// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "sarimax";
series.dataFields.dateX = "date";
series.tooltipText = "{name}\n[bold font-size: 20]{valueY}%[/]"
series.name = "Sarimax";
series.stroke = chart.colors.getIndex(1);
series.strokeWidth = 2;
series.minBulletDistance = 15;

var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "hwes";
series2.dataFields.dateX = "date";
series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}%[/]"
series2.stroke = chart.colors.getIndex(6);
series2.name = "Hwes";
series2.strokeWidth = 2;
series2.minBulletDistance = 15;


// Drop-shaped tooltips
series.tooltip.background.cornerRadius = 20;
series.tooltip.background.strokeOpacity = 0;
series.tooltip.pointerOrientation = "vertical";
series.tooltip.label.minWidth = 40;
series.tooltip.label.minHeight = 40;
series.tooltip.label.textAlign = "middle";
series.tooltip.label.textValign = "middle";

series2.tooltip.background.cornerRadius = 20;
series2.tooltip.background.strokeOpacity = 0;
series2.tooltip.pointerOrientation = "vertical";
series2.tooltip.label.minWidth = 40;
series2.tooltip.label.minHeight = 40;
series2.tooltip.label.textAlign = "middle";
series2.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

var bullet2 = series2.bullets.push(new am4charts.CircleBullet());
bullet2.circle.strokeWidth = 2;
bullet2.circle.radius = 4;
bullet2.circle.fill = am4core.color("#fff");

var bullethover2 = bullet2.states.create("hover");
bullethover2.properties.scale = 1.3;

// Make a panning cursor
chart.cursor = new am4charts.XYCursor();

// Create vertical scrollbar and place it before the value axis
chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.parent = chart.leftAxesContainer;
chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
chart.scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX.series.push(series);
chart.scrollbarX.series.push(series2);
chart.scrollbarX.parent = chart.bottomAxesContainer;

chart.legend = new am4charts.Legend();
}); // end am4core.ready()
</script>