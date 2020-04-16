<?php
namespace App\Http\Controllers;
use App\Charts\SampleChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Operation;
//use Charts;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
            return $this->getLastStatsBycountry();
    }


    public function getLastStatsByCountry(){
        $reports = DB::table('last_data_by_country')
                    ->orderBy('confirmed', 'desc');

        return $reports;
    }

    public function getLastStatsByCountryForMap(){
        /*
        select Province_State || '_' || Country_Region as Country_Region, strftime('%Y-%m-%d', last_update) as last_update,Lat as lat, Long_ as lng, 
        Confirmed as confirmed, Deaths as deaths, 
        Recovered as recovered, Active as active
        from reports 
        where 
            strftime('%Y-%m-%d', last_update) = (
                select max(strftime('%Y-%m-%d', last_update)) from reports
            )
        order by confirmed desc
        */

        $reports = DB::table('reports')
            ->selectRaw("Province_State || '_' || Country_Region as Country_Region, strftime('%Y-%m-%d', last_update) as last_update,Lat as lat, Long_ as lng, 
            Confirmed as confirmed, Deaths as deaths, 
            Recovered as recovered, Active as active")
            ->whereRaw("lat != '' and lng != '' and             strftime('%Y-%m-%d', last_update) = (
                        select max(strftime('%Y-%m-%d', last_update)) from reports
                        )")
            ->orderBy('confirmed', 'desc');

        return $reports;
    }

    public function displayLastStatsByCountry(){
        $reports = $this->getLastStatsByCountry();

        return view('last_stats_by_countries', [
            'reports' => $reports->simplePaginate(20),
        ]);
    }


    public function getHistoryByCountry(){
        $country = request( 'country' );

        $reports = DB::table('reports')
                    ->selectRaw("Country_Region, strftime('%Y-%m-%d', last_update) as last_update, sum(Confirmed) as confirmed, sum(Deaths) as deaths, sum(Recovered) as recovered, sum(Active) as active")
                    ->whereRaw("Country_Region = '$country'")
                    ->groupByRaw("strftime('%Y-%m-%d', last_update)")
                    ->orderBy('last_update', 'desc');

        return view('history_by_country', [
            'reports' => $reports->simplePaginate(20),
        ]);
    }

    public function getGraphByCountryChart(){
        $country = request( 'country' );

        if( $country ){
            $reports = DB::table('reports')
            ->selectRaw("Country_Region, strftime('%Y-%m-%d', last_update) as last_update, sum(Confirmed) as confirmed, sum(Deaths) as deaths, sum(Recovered) as recovered, sum(Active) as active")
            ->whereRaw("Country_Region = '$country'")
            ->groupByRaw("strftime('%Y-%m-%d', last_update)")
            ->orderBy('last_update', 'asc');
        } else {
            $reports = DB::table('reports')
            ->selectRaw("strftime('%Y-%m-%d', last_update) as last_update, sum(Confirmed) as confirmed, sum(Deaths) as deaths, sum(Recovered) as recovered, sum(Active) as active")
            ->groupByRaw("strftime('%Y-%m-%d', last_update)")
            ->orderBy('last_update', 'asc');
        }


        $labels = $reports->pluck('last_update');
        $confirmed = $reports->pluck('confirmed');
        $deaths = $reports->pluck('deaths');
        $recovered = $reports->pluck('recovered');
        
        $chart = new SampleChart;
        $chart->labels($labels)->height(350);
        $chart->dataset('confirmed', 'line', $confirmed);
        $chart->dataset('deaths', 'line', $deaths);
        $chart->dataset('recovered', 'line', $recovered);

        return $chart;
    }


    public function displayGraphByCountry(){
        $chart = $this->getGraphByCountryChart();
        return view('graph_by_country', ['chart' => $chart]);  
    }

    public function displayGraphByCountryAPI(){
        $chart = $this->getGraphByCountryChart();
        return $chart->api();
    }

    public function displayGraphByCountryAPIWrapped(){
        $chart = $this->getGraphByCountryChart();
        $dataset_str = $chart->api();
        return "{\"labels\":".json_encode($chart->labels).",\"datasets\":$dataset_str}" ;
    }



}
