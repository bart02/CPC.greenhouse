<?php

/*if ($_SERVER['REMOTE_ADDR'] != '77.106.87.85') {
	header("HTTP/1.1 302 Moved Temporarily");
    header("Location: http://greenhouse.cpc.tomsk.ru/r.html");
}*/

$mysql_s = "92.127.158.65";    #MySQL server
$mysql_u = "dc319_greeghouse";    #MySQL user
$mysql_p = 'n4z8YKCHZ82W';    #MySQL password
$mysql_d = "dc319_greeghouse";    #MySQL database
try {
	$db = new PDO('mysql:host='.$mysql_s.';dbname='.$mysql_d, $mysql_u, $mysql_p, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
	exit($e->getMessage());
}

$airing = $db->query("SELECT * FROM `logs` WHERE `logtype` = '0' ORDER BY `id` DESC ;");
$airing = array_reverse($airing->fetchAll(PDO::FETCH_ASSOC));
$airingm = "";
foreach ($airing as $value) $airingm .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$air_temp = $db->query("SELECT * FROM `logs` WHERE `logtype` = '1' ORDER BY `id` DESC ;");
$air_temp = array_reverse($air_temp->fetchAll(PDO::FETCH_ASSOC));
$air_tempm = "";
foreach ($air_temp as $value) $air_tempm .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$ground_temp = $db->query("SELECT * FROM `logs` WHERE `logtype` = '2' ORDER BY `id` DESC ;");
$ground_temp = array_reverse($ground_temp->fetchAll(PDO::FETCH_ASSOC));
$ground_tempm = "";
foreach ($ground_temp as $value) $ground_tempm .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$air_humidity = $db->query("SELECT * FROM `logs` WHERE `logtype` = '3' ORDER BY `id` DESC ;");
$air_humidity = array_reverse($air_humidity->fetchAll(PDO::FETCH_ASSOC));
$air_humiditym = "";
foreach ($air_humidity as $value) $air_humiditym .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$ground_humidity = $db->query("SELECT * FROM `logs` WHERE `logtype` = '4' ORDER BY `id` DESC ;");
$ground_humidity = array_reverse($ground_humidity->fetchAll(PDO::FETCH_ASSOC));
$ground_humiditym = "";
foreach ($ground_humidity as $value) $ground_humiditym .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$lights = $db->query("SELECT * FROM `logs` WHERE `logtype` = '5' ORDER BY `id` DESC ;");
$lights = array_reverse($lights->fetchAll(PDO::FETCH_ASSOC));
$lightsm = "";
foreach ($lights as $value) $lightsm .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$air_humidity_out = $db->query("SELECT * FROM `logs` WHERE `logtype` = '6' ORDER BY `id` DESC ;");
$air_humidity_out = array_reverse($air_humidity_out->fetchAll(PDO::FETCH_ASSOC));
$air_humidity_outm = "";
foreach ($air_humidity_out as $value) $air_humidity_outm .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

$air_temp_out = $db->query("SELECT * FROM `logs` WHERE `logtype` = '7' ORDER BY `id` DESC ;");
$air_temp_out = array_reverse($air_temp_out->fetchAll(PDO::FETCH_ASSOC));
$air_temp_outm = "";
foreach ($air_temp_out as $value) $air_temp_outm .= "[" . $value['date'] * 1000 . "," . $value['data'] . "],";

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta name="theme-color" content="#03a9f4">
    <title>Теплица ЦПК</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
    
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
	
	<style>
		@media only screen and (min-width: 993px) {
			h5 {
				height: 52px;
			}
		}
	</style>
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
            <div class="row">
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Температура воздуха (тепл.)</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$air_temp[count($air_temp) - 1]['data']?> °C</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_air_temp()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Температура воздуха (улица)</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$air_temp_out[count($air_temp_out) - 1]['data']?> °C</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_air_temp_out()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Температура почвы</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$ground_temp[count($ground_temp) - 1]['data']?> °C</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_ground_temp()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="staff-online">
                        <div class="card-content">
                            <h5 class="hh">Освещенность</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$lights[count($lights) - 1]['data']?> люксов</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_lights()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="staff-online">
                        <div class="card-content">
                            <h5>Влажность воздуха (тепл.)</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$air_humidity[count($air_humidity) - 1]['data']?>%</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_air_humidity()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="staff-online">
                        <div class="card-content">
                            <h5>Влажность воздуха (улица)</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$air_humidity_out[count($air_humidity_out) - 1]['data']?>%</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_air_humidity_out()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5>Влажность почвы</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?=$ground_humidity[count($ground_humidity) - 1]['data']?>%</p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_ground_humidity()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6 s12">
                    <div class="card blue-grey darken-1 white-text" id="server-stats">
                        <div class="card-content">
                            <h5 class="hh">Проветривание</h5>
                            <div class="divider"></div>
                            <div class="section">
                                <p><?php echo (($airing[count($airing) - 1]['data'] == '1') ? "Есть" : "Нету"); ?></p>
                            </div>
							<div class="card-action">
                                <a onclick="Chart_airing()">Отобразить статистику</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row center">
			    <div class="col s12">
			        <div id="graph" style="height: 400px;"></div>
		        </div>
			</div>
        </div>
    </main>
    
    
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    
    <script>
	range = {
    	buttons: [{
			type: 'hour',
			count: 1,
			text: '1ч'
		}, {
			type: 'day',
			count: 1,
			text: '1д'
		}, {
			type: 'day',
			count: 3,
			text: '3д'
		}, {
			type: 'month',
			count: 1,
			text: '1м'
		}, {
			type: 'month',
			count: 3,
			text: '3м'
		}, {
			type: 'year',
			count: 1,
			text: '1y'
		}, {
			type: 'all',
			text: 'Общ.'
		}],
        selected: 1
    }
	Highcharts.setOptions({
		lang: {
			contextButtonTitle: "Chart context menu",
			decimalPoint: ".",
			downloadJPEG: "Cкачать в формате JPEG",
			downloadPDF: "Cкачать в формате PDF",
			downloadPNG: "Cкачать в формате PNG",
			downloadSVG: "Cкачать в формате SVG",
			invalidDate: undefined,
			loading: "Загрузка...",
			months: [ "Январь" , "Февраль" , "Март" , "Апрель" , "Май" , "Июнь" , "Июль" , "Август" , "Сентябрь" , "Октябрь" , "Ноябрь" , "Декабрь"],
			numericSymbolMagnitude: 1000,
			numericSymbols: [ "k" , "M" , "G" , "T" , "P" , "E"],
			printChart: "Напечатать график",
			rangeSelectorFrom: "С",
			rangeSelectorTo: "По",
			rangeSelectorZoom: "Увеличение",
			resetZoom: "Сбросить увеличение",
			resetZoomTitle: "Сбросить увеличение к 1:1",
			shortMonths: [ "Янв" , "Фев" , "Мар" , "Апр" , "Май" , "Июн" , "Июл" , "Авг" , "Сен" , "Окт" , "Ноя" , "Дек"],
			shortWeekdays: undefined,
			thousandsSep: " ",
			weekdays: ["Воскресение", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"]
		}
		
	})
	
	
	function Chart_airing() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits:{
				enabled: false
			},
			
	        rangeSelector: range,
	        title: {
	            text: 'Проветривание'
	        },
	        series: [{
	            name: 'Вкл/выкл',
	            data: [<?php echo $airingm; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	        yAxis: [{
	        	min: 0,
	        	max: 1
			}]
	    });
	}
		
	function Chart_ground_temp() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Температура почвы (тепл.)'
	        },
	        series: [{
	            name: '°C',
	            data: [<?php echo $ground_tempm; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	    });
	}
	
	function Chart_air_temp() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Температура воздуха (тепл.)'
	        },
	        series: [{
	            name: '°C',
	            data: [<?php echo $air_tempm; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	    });
	}
	
	function Chart_air_humidity() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Влажность воздуха (тепл.)'
	        },
	        series: [{
	            name: '%',
	            data: [<?php echo $air_humiditym; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	        yAxis: [{
	        	min: 0,
	        	max: 100
			}]
	    });
	}
	
	function Chart_ground_humidity() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Влажность почвы'
	        },
	        series: [{
	            name: '%',
	            data: [<?php echo $ground_humiditym; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	        yAxis: [{
	        	min: 0,
	        	max: 100
			}]
	    });
	}
	
	function Chart_lights() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Освещение'
	        },
	        series: [{
	            name: 'Люкс',
	            data: [<?php echo $lightsm; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	    });
	}
	
	function Chart_air_temp_out() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Температура воздуха (улица)'
	        },
	        series: [{
	            name: '°C',
	            data: [<?php echo $air_temp_outm; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	    });
	}
	
	function Chart_air_humidity_out() {
	    // Create the chart
	    Highcharts.stockChart('graph', {
	    	credits: {
				enabled: false
			},
	        rangeSelector: range,
	        title: {
	            text: 'Влажность воздуха (улица)'
	        },
	        series: [{
	            name: '%',
	            data: [<?php echo $air_humidity_outm; ?>],
	            tooltip: {
	                valueDecimals: 0
	            }
	        }],
	        yAxis: [{
	        	min: 0,
	        	max: 100
			}]
	    });
	}
	</script>  <!--Charts-->
</body>

</html>
