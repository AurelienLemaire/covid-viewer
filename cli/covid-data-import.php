<?php

include "classes/CovidDailyReport.php";
include "classes/CovidDataOperator.php";


$database_file = "data/covid-data";
$data_dir = "data/COVID-19/csse_covid_19_data/csse_covid_19_daily_reports";
//$data_dir = "data/COVID-19/csse_covid_19_data/test";


$processController = new CovidDataOperator($database_file, $data_dir);
$processController->setDebug(false);
/*
$processController->createDatabase();
$processController->printReport();

$processController->dropData();
$processController->printReport();
*/
$processController->processReportsDirectory();
$processController->printReport();
$processController->postProcess();
$processController->printReport();

$processController->buildConsolidatedData();

?>
