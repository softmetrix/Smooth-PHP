<?php
require 'vendor/autoload.php';
use softmetrix\Smooth\Smooth;

$defaultDistribution = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1];

function dateArray($startDate, $months)
{
    $arr = [];
    $currentDate = date('Y-m-t', strtotime($startDate));
    $arr[] = $currentDate;
    for ($i = 1; $i <= $months; ++$i) {
        $currentDate = date('Y-m-t', strtotime('+1 months', strtotime($currentDate)));
        $arr[] = $currentDate;
    }

    return $arr;
}

function dateArray2($startDate, $endDate)
{
    $arr = [];
    $currentDate = date('Y-m-t', strtotime($startDate));
    $endDate = date('Y-m-t', strtotime($endDate));
    $arr[] = $currentDate;
    while (strtotime($currentDate) <= strtotime($endDate)) {
        $currentDate = date('Y-m-t', strtotime('+1 months', strtotime($currentDate)));
        $arr[] = $currentDate;
    }

    return $arr;
}

function generateDistribution($defaultDistribution, $startDate, $endDate, $method)
{
    $dateArray = dateArray2($startDate, $endDate);
    $step = count($defaultDistribution) / count($dateArray);
    $smooth = new Smooth($defaultDistribution, $method);
    $newDistribution = [];
    $current = 0;
    foreach ($dateArray as $date) {
        $newDistribution[$date] = $smooth->val($current);
        $current += $step;
    }

    return $newDistribution;
}

$cubic1 = generateDistribution($defaultDistribution, '2015-01-31', '2050-01-31', Smooth::METHOD_CUBIC);
$linear1 = generateDistribution($defaultDistribution, '2015-01-31', '2050-01-31', Smooth::METHOD_LINEAR);
$nearest1 = generateDistribution($defaultDistribution, '2015-01-31', '2050-01-31', Smooth::METHOD_NEAREST);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Smooth PHP demo</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6">
                <div style="width:100%;">
                    <canvas id="chart1"></canvas>
                </div> 
            </div>
            <div class="col-xs-6">
                <div style="width:100%;">
                    <canvas id="chart2"></canvas>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div style="width:100%;">
                    <canvas id="chart3"></canvas>
                </div> 
            </div>
            <div class="col-xs-6">
                <div style="width:100%;">
                    <canvas id="chart4"></canvas>
                </div> 
            </div>
        </div>
    </div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){ 
    var data = <?= json_encode($defaultDistribution); ?>;
    var labels = <?= json_encode(dateArray('2015-01-01', count($defaultDistribution))); ?>;
    var ctx = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Default distribution',
                backgroundColor: '#c00',
                borderColor: '#c00',
                data: data,
                fill: false,
            }]
        }
    });

    var data2 = <?= json_encode(array_values($cubic1)); ?>;
    var labels2 = <?= json_encode(array_keys($cubic1)); ?>;
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: labels2,
            datasets: [{
                label: 'Cubic interpolation',
                backgroundColor: '#0c0',
                borderColor: '#0c0',
                data: data2,
                fill: false,
            }]
        }
    });

    var data3 = <?= json_encode(array_values($linear1)); ?>;
    var labels3 = <?= json_encode(array_keys($linear1)); ?>;
    var ctx3 = document.getElementById('chart3').getContext('2d');
    var chart3 = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: labels3,
            datasets: [{
                label: 'Linear interpolation',
                backgroundColor: '#00c',
                borderColor: '#00c',
                data: data3,
                fill: false,
            }]
        }
    });

    var data4 = <?= json_encode(array_values($nearest1)); ?>;
    var labels4 = <?= json_encode(array_keys($nearest1)); ?>;
    var ctx4 = document.getElementById('chart4').getContext('2d');
    var chart4 = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: labels4,
            datasets: [{
                label: 'Nearest neighbor interpolation',
                backgroundColor: '#0cc',
                borderColor: '#0cc',
                data: data4,
                fill: false,
            }]
        }
    });
}, false);
</script>
</body>
</html>