<?php
require('vendor/autoload.php');
use softmetrix\Smooth\Smooth;

$distributionFactorArrayHematology = [97.93, 70.06, 102.03, 125.01, 138.85, 120.55, 102.34, 103.53, 137.68, 87.33, 82.90, 87.91, 99.51, 133.92, 140.61, 152.80, 164.15, 192.57, 186.20, 177.29, 185.52, 209.03, 191.72, 191.26, 211.10, 204.60, 201.45, 213.19, 217.12, 217.18, 222.38, 221.61, 223.51, 222.11, 221.21, 218.59, 229.56, 219.15, 220.48, 219.92, 206.08, 195.56, 187.17, 178.44, 170.14, 176.36, 175.86, 172.51, 175.14, 171.32, 166.15, 161.56, 151.47, 145.46, 144.14, 134.68, 132.57, 136.00, 126.44, 115.96, 116.04, 100.86, 94.34, 88.41, 80.75, 73.59, 73.00, 63.13, 58.67, 57.48, 58.48, 48.71, 54.07, 47.33, 44.11, 57.98, 43.44, 43.19, 43.99, 39.94, 37.61, 38.11, 34.60, 39.97, 34.52, 31.28, 30.29, 31.77, 29.18, 26.64, 28.30, 26.77, 25.28, 28.77, 26.45, 25.80, 24.57, 22.10, 21.58, 29.92, 17.21, 16.58, 16.46, 29.88, 15.80, 15.49, 15.54, 13.66, 12.27, 11.13, 10.44, 9.40, 7.65, 7.40, 6.99, 6.74, 6.49, 5.61, 5.25, 1.08, 1.08];
$smooth = new Smooth($distributionFactorArrayHematology, Smooth::METHOD_CUBIC);
$hematologyCubic = [];
foreach (range(0.0, count($distributionFactorArrayHematology)*2, 0.1) as $i) {
    $hematologyCubic[] = $smooth->val($i);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Smooth PHP demo</title>
</head>
<body>
<div style="width:75%;">
    <canvas id="chart1"></canvas>
</div> 
<div style="width:75%;">
    <canvas id="chart2"></canvas>
</div> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){ 
    var data = <?= json_encode($distributionFactorArrayHematology) ?>;
    var labels = <?= json_encode(array_keys($distributionFactorArrayHematology)) ?>;
    var ctx = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cost distribution',
                backgroundColor: '#c00',
                borderColor: '#c00',
                data: data,
                fill: false,
            }]
        }
    });

    var data2 = <?= json_encode($hematologyCubic) ?>;
    var labels2 = <?= json_encode(array_keys($hematologyCubic)) ?>;
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: labels2,
            datasets: [{
                label: 'Cost distribution',
                backgroundColor: '#0c0',
                borderColor: '#0c0',
                data: data2,
                fill: false,
            }]
        }
    });
}, false);
</script>
</body>
</html>