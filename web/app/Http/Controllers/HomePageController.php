<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $reportCtrl = new ReportsController();
        $chart = $reportCtrl->getGraphByCountryChart();
        $listByCountry = $reportCtrl->getLastStatsByCountry();
        return view('homepage', [
            'reports' => $listByCountry->get(),
            'chart' => $chart
        ]);    
    }

    public function test() {
        return view('test');    
    }

    public function map() {
        return view('map_inc');    
    }

    public function covidOlPoints() {
        $reportCtrl = new ReportsController();
        $listByCountry = $reportCtrl->getLastStatsByCountryForMap();
        return view('covid-ol-points', ['reports' => $listByCountry->get()]);
    }


}
