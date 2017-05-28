<?php

$mysql_s = "92.127.158.65";    #MySQL server
$mysql_u = "dc319_greeghouse";    #MySQL user
$mysql_p = 'n4z8YKCHZ82W';    #MySQL password
$mysql_d = "dc319_greeghouse";    #MySQL database
try {
	$db = new PDO('mysql:host='.$mysql_s.';dbname='.$mysql_d, $mysql_u, $mysql_p, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
	exit($e->getMessage());
}

$airing = $db->query("SELECT * FROM `logs` WHERE `logtype` = '0' ORDER BY `id` DESC LIMIT 20;");
$airing = array_reverse($airing->fetchAll(PDO::FETCH_ASSOC));

$air_temp = $db->query("SELECT * FROM `logs` WHERE `logtype` = '1' ORDER BY `id` DESC LIMIT 20;");
$air_temp = array_reverse($air_temp->fetchAll(PDO::FETCH_ASSOC));

$ground_temp = $db->query("SELECT * FROM `logs` WHERE `logtype` = '2' ORDER BY `id` DESC LIMIT 20;");
$ground_temp = array_reverse($ground_temp->fetchAll(PDO::FETCH_ASSOC));

$air_humidity = $db->query("SELECT * FROM `logs` WHERE `logtype` = '3' ORDER BY `id` DESC LIMIT 20;");
$air_humidity = array_reverse($air_humidity->fetchAll(PDO::FETCH_ASSOC));

$ground_humidity = $db->query("SELECT * FROM `logs` WHERE `logtype` = '4' ORDER BY `id` DESC LIMIT 20;");
$ground_humidity = array_reverse($ground_humidity->fetchAll(PDO::FETCH_ASSOC));

$lights = $db->query("SELECT * FROM `logs` WHERE `logtype` = '5' ORDER BY `id` DESC LIMIT 20;");
$lights = array_reverse($lights->fetchAll(PDO::FETCH_ASSOC));

?><!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-title" content="Icicle Networks">
    <meta name="application-name" content="Icicle Networks">
    <meta name="theme-color" content="#03a9f4">
    <title>Теплица ЦПК</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
</head>

<body>
    <nav class="light-blue" role="navigation">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo">Теплица</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="http://cpc.tomsk.ru">Главная</a></li>
            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li><a href="http://cpc.tomsk.ru">Главная</a></li>
            </ul>
            <a class="button-collapse" href="#" data-activates="nav-mobile"><i class="material-icons">menu</i></a>
    </nav>
    <main>
        <div class="container">
		    <script>
			var global_type = 'airing';
			function chart(type){
			    global_type = type;
			    google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
				    if(global_type == 'airing'){
                        var data = google.visualization.arrayToDataTable([
                            ['Дата', 'Статус']<?php foreach($airing as $key => $value){ ?>, ['<?=$value['date']?>', <?=$value['data']?>]<?php } ?>
                        ]);
                        var options = {
                            title: 'Проветривание',
                            hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };
					}else if(global_type == 'air_temp'){
                        var data = google.visualization.arrayToDataTable([
                            ['Дата', 'Температура']<?php foreach($air_temp as $key => $value){ ?>, ['<?=$value['date']?>', <?=$value['data']?>]<?php } ?>
                        ]);
                        var options = {
                            title: 'Температура воздуха',
                            hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };
					}else if(global_type == 'ground_temp'){
                        var data = google.visualization.arrayToDataTable([
                            ['Дата', 'Температура']<?php foreach($ground_temp as $key => $value){ ?>, ['<?=$value['date']?>', <?=$value['data']?>]<?php } ?>
                        ]);
                        var options = {
                            title: 'Температура почвы',
                            hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };
					}else if(global_type == 'air_humidity'){
                        var data = google.visualization.arrayToDataTable([
                            ['Дата', 'Проценты']<?php foreach($air_humidity as $key => $value){ ?>, ['<?=$value['date']?>', <?=$value['data']?>]<?php } ?>
                        ]);
                        var options = {
                            title: 'Влажность воздуха',
                            hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };
					}else if(global_type == 'ground_humidity'){
                        var data = google.visualization.arrayToDataTable([
                            ['Дата', 'Проценты']<?php foreach($ground_humidity as $key => $value){ ?>, ['<?=$value['date']?>', <?=$value['data']?>]<?php } ?>
                        ]);
                        var options = {
                            title: 'Влажность почвы',
                            hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };
					}else if(global_type == 'lights'){
                        var data = google.visualization.arrayToDataTable([
                            ['Дата', 'Люксы']<?php foreach($lights as $key => $value){ ?>, ['<?=$value['date']?>', <?=$value['data']?>]<?php } ?>
                        ]);
                        var options = {
                            title: 'Освещенность',
                            hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };
					}

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
			}
			</script>
            <div class="row">
                <div class="col l4 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Температура воздуха</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$air_temp[count($air_temp) - 1]['data']?> °C</p>
                            </div>
							<div class="card-action">
                                <a onclick="chart('air_temp')">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Температура почвы</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$ground_temp[count($ground_temp) - 1]['data']?> °C</p>
                            </div>
							<div class="card-action">
                                <a onclick="chart('ground_temp')">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l4 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="staff-online">
                        <div class="card-content">
                            <h5>Влажность воздуха</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$air_humidity[count($air_humidity) - 1]['data']?>%</p>
                            </div>
							<div class="card-action">
                                <a onclick="chart('air_humidity')">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Влажность почвы</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$ground_humidity[count($ground_humidity) - 1]['data']?>%</p>
                            </div>
							<div class="card-action">
                                <a onclick="chart('ground_humidity')">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l4 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="staff-online">
                        <div class="card-content">
                            <h5>Освещенность</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$lights[count($lights) - 1]['data']?> люксов</p>
                            </div>
							<div class="card-action">
                                <a onclick="chart('lights')">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Проветривание</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?php echo (($airing[count($airing) - 1]['data'] == '1') ? "Есть" : "Нету"); ?></p>
                            </div>
							<div class="card-action">
                                <a onclick="chart('airing')">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row center">
			    <div class="col l12 m6 s12">
			        <div id="chart_div" style="height: 400px;"></span>
		        </div>
			</div>
        </div>
    </main>
</body>

</html>