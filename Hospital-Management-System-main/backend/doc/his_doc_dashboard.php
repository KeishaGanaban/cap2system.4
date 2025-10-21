<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$doc_id = $_SESSION['doc_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("assets/inc/head.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; margin:0; }
        .page-title-box h4 { font-weight: 600; color: #2c3e50; }
        .summary-card {
            background: #fff; border-radius: 20px; padding: 20px 25px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-width: 200px;
        }
        .summary-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.12); }
        .summary-info h3 { font-size: 1.5rem; margin:0; font-weight:600; color:#2c3e50; }
        .summary-info span { font-size:0.85rem; color:#6c757d; letter-spacing:0.5px; }
        .summary-arrow { font-weight:600; font-size:0.85rem; margin-top:5px; }
        .summary-icon {
            width: 50px; height: 50px; border-radius:50%; display:flex;
            align-items:center; justify-content:center; font-size:1.3rem;
            color:#fff; flex-shrink:0;
        }
        .bg-gradient-blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .bg-gradient-green { background: linear-gradient(135deg, #4ade80, #16a34a); }
        .bg-gradient-red { background: linear-gradient(135deg, #f87171, #dc2626); }

        .chart-section { display: flex; gap: 25px; flex-wrap: wrap; margin-top: 30px; }
        .chart-left, .chart-right {
            background: #fff; border-radius: 20px; padding: 25px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .chart-left { flex: 0 0 65%; }
        .chart-right { flex: 0 0 32%; }
        canvas { width: 100% !important; height: auto !important; }
        h4.header-title { font-weight: 600; margin-bottom: 25px; color: #1d4ed8; }

        @media (max-width: 991px) { .chart-left, .chart-right { flex: 0 0 100%; } }
        .content-page .content .container-fluid { padding-top: 20px; padding-bottom: 40px; }
    </style>
</head>
<body>
<div id="wrapper">
    <?php include('assets/inc/nav.php'); ?>
    <?php include('assets/inc/sidebar.php'); ?>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Doctor Dashboard</h4>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between gap-3 flex-wrap">

                            <!-- Total Patients -->
                            <?php
                                // Change 'pat_date_joined' to your actual date column
                                $dateColumn = 'pat_date_joined';

                                // Get total patients
                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients");
                                $stmt->execute(); $stmt->bind_result($totalPatients); $stmt->fetch(); $stmt->close();

                                // Weekly comparison
                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE YEARWEEK($dateColumn,1) = YEARWEEK(CURDATE(),1)");
                                $stmt->execute(); $stmt->bind_result($thisWeekTotal); $stmt->fetch(); $stmt->close();

                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE YEARWEEK($dateColumn,1) = YEARWEEK(CURDATE(),1)-1");
                                $stmt->execute(); $stmt->bind_result($lastWeekTotal); $stmt->fetch(); $stmt->close();

                                $changeTotal = $lastWeekTotal > 0 ? (($thisWeekTotal - $lastWeekTotal)/$lastWeekTotal)*100 : 0;
                                $arrowTotal = $thisWeekTotal > $lastWeekTotal ? "▲" : ($thisWeekTotal < $lastWeekTotal ? "▼" : "➝");
                                $colorTotal = $thisWeekTotal > $lastWeekTotal ? "text-success" : ($thisWeekTotal < $lastWeekTotal ? "text-danger" : "text-warning");
                            ?>
                            <div class="summary-card flex-fill">
                                <div class="summary-info">
                                    <h3><?php echo $totalPatients; ?></h3>
                                    <span>Total Patients</span>
                                </div>
                                <div class="summary-arrow <?php echo $colorTotal; ?>"><?php echo $arrowTotal . " " . number_format($changeTotal,1) . "%"; ?></div>
                                <div class="summary-icon bg-gradient-blue"><i class="mdi mdi-hospital-building"></i></div>
                            </div>

                            <!-- Active Patients -->
                            <?php
                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Active'");
                                $stmt->execute(); $stmt->bind_result($activePatients); $stmt->fetch(); $stmt->close();

                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Active' AND YEARWEEK($dateColumn,1)=YEARWEEK(CURDATE(),1)");
                                $stmt->execute(); $stmt->bind_result($thisWeekActive); $stmt->fetch(); $stmt->close();

                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Active' AND YEARWEEK($dateColumn,1)=YEARWEEK(CURDATE(),1)-1");
                                $stmt->execute(); $stmt->bind_result($lastWeekActive); $stmt->fetch(); $stmt->close();

                                $changeActive = $lastWeekActive > 0 ? (($thisWeekActive - $lastWeekActive)/$lastWeekActive)*100 : 0;
                                $arrowActive = $thisWeekActive > $lastWeekActive ? "▲" : ($thisWeekActive < $lastWeekActive ? "▼" : "➝");
                                $colorActive = $thisWeekActive > $lastWeekActive ? "text-success" : ($thisWeekActive < $lastWeekActive ? "text-danger" : "text-warning");
                            ?>
                            <div class="summary-card flex-fill">
                                <div class="summary-info">
                                    <h3><?php echo $activePatients; ?></h3>
                                    <span>Active Patients</span>
                                </div>
                                <div class="summary-arrow <?php echo $colorActive; ?>"><?php echo $arrowActive . " " . number_format($changeActive,1) . "%"; ?></div>
                                <div class="summary-icon bg-gradient-green"><i class="mdi mdi-account-heart"></i></div>
                            </div>

                            <!-- Diagnosed Patients -->
                            <?php
                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Diagnosed'");
                                $stmt->execute(); $stmt->bind_result($diagnosedPatients); $stmt->fetch(); $stmt->close();

                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Diagnosed' AND YEARWEEK($dateColumn,1)=YEARWEEK(CURDATE(),1)");
                                $stmt->execute(); $stmt->bind_result($thisWeekDiagnosed); $stmt->fetch(); $stmt->close();

                                $stmt = $mysqli->prepare("SELECT COUNT(*) FROM his_patients WHERE pat_discharge_status='Diagnosed' AND YEARWEEK($dateColumn,1)=YEARWEEK(CURDATE(),1)-1");
                                $stmt->execute(); $stmt->bind_result($lastWeekDiagnosed); $stmt->fetch(); $stmt->close();

                                $changeDiagnosed = $lastWeekDiagnosed > 0 ? (($thisWeekDiagnosed - $lastWeekDiagnosed)/$lastWeekDiagnosed)*100 : 0;
                                $arrowDiagnosed = $thisWeekDiagnosed > $lastWeekDiagnosed ? "▲" : ($thisWeekDiagnosed < $lastWeekDiagnosed ? "▼" : "➝");
                                $colorDiagnosed = $thisWeekDiagnosed > $lastWeekDiagnosed ? "text-success" : ($thisWeekDiagnosed < $lastWeekDiagnosed ? "text-danger" : "text-warning");
                            ?>
                            <div class="summary-card flex-fill">
                                <div class="summary-info">
                                    <h3><?php echo $diagnosedPatients; ?></h3>
                                    <span>Diagnosed</span>
                                </div>
                                <div class="summary-arrow <?php echo $colorDiagnosed; ?>"><?php echo $arrowDiagnosed . " " . number_format($changeDiagnosed,1) . "%"; ?></div>
                                <div class="summary-icon bg-gradient-red"><i class="mdi mdi-account-off"></i></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="chart-section">
                    <div class="chart-left">
                        <h4 class="header-title">Monthly Patient Registration</h4>
                        <canvas id="patientLineChart"></canvas>
                    </div>
                    <div class="chart-right">
                        <h4 class="header-title">Patients by Location</h4>
                        <canvas id="patientsLocationChart"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <?php include('assets/inc/footer.php'); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
<script>lucide.createIcons();</script>

<script>
    const ctxLine = document.getElementById('patientLineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['May', 'June', 'July', 'August', 'September', 'October'],
            datasets: [{
                label: 'Registered Patients',
                data: [80, 92, 100, 130, 125, 140],
                borderColor: '#1d4ed8',
                backgroundColor: 'rgba(29,78,216,0.15)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#1d4ed8'
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } }
    });

    const ctxPie = document.getElementById('patientsLocationChart').getContext('2d');
    const labels = ['Bontoc', 'Sagada', 'Tadian', 'Sabangan', 'Bauko'];
    const dataValues = [25, 18, 22, 20, 15];

    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{ data: dataValues, backgroundColor: ['#1d4ed8','#10b981','#ef4444','#facc15','#8b5cf6'], borderWidth: 1 }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 15, padding: 15 } },
                datalabels: {
                    color: '#fff', font: { weight: '600', size: 12 },
                    anchor: 'center', align: 'center',
                    formatter: (value, ctx) => {
                        const sum = ctx.chart.data.datasets[0].data.reduce((a,b)=>a+b,0);
                        return ((value*100)/sum).toFixed(1)+'%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
</body>
</html>
