function init_points(){
    @foreach($reports as $report)
       add_map_circle(confirmedLayer, {{ $report->lat }}, {{ $report->lng }}, 4* {{ $report->confirmed }});
       add_map_circle(deathLayer, {{ $report->lat }}, {{ $report->lng }}, 40* {{ $report->deaths}});
       add_map_circle(recoverLayer, {{ $report->lat }}, {{ $report->lng }}, 10* {{ $report->recovered}});
       add_map_circle(activeLayer, {{ $report->lat }}, {{ $report->lng }}, 10* {{ $report->active}});

    @endforeach 
}
