<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Covid-19 data Viewer</title>
            
            <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.2.0/build/ol.js"></script>

            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <script>
                function refresh( country ) {
                    var original_api_url = "http://covid-viewer/graphByCountryAPIWrapper";
                    var newurl = original_api_url + "?country=" + country;

                    fetch(newurl)
                        .then(data => data.json())
                        .then(data => { 
                            {{ $chart->id }}.data = data;
                            {{ $chart->id }}.update();
                        });
                }


                jQuery(document).ready(function($) {
      
                    $("#tabs").tabs();
                    $("#tabs-left").tabs();

                    $("#tabs-right").tabs();

                    $( "#tabs-1-selector" ).click(function() {  switchLayer( confirmedLayer );});
                    $( "#tabs-2-selector" ).click(function() {   switchLayer( deathLayer );   });
                    $( "#tabs-3-selector" ).click(function() {   switchLayer( recoverLayer ); });
                    $( "#tabs-4-selector" ).click(function() {   switchLayer( activeLayer ); });

                    $('#tabs-1').height( $('#tabs-1').height() - $('ul').css("height") ) ;
                    $('#map').height(  $('#tabs-1').height()  - 44 ) ;

                    initialize_map();
                    switchLayer( confirmedLayer ); 

                    init_points();  

                });



            </script>
            
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.2.0/css/ol.css" type="text/css">
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

            <style>
                html, body, .container-covid{
                    height: 100%; width:100%;
                }

                .row{
                    height: auto !important;
                }
                
                #upper-panel {margin:15px;}

                #tabs-1, #tabs-right-1, #tabs-left-1 {
                    margin:0px;padding:0px;            
                }

                #tabs-1{
                    height:100%;
                }

                #tabs,  #tabs-right, #tabs-left{ 
                    margin:0px;padding:0px;
                }

                #tabs-left{
                    height:400px;
                    margin-bottom:30px;
                }

                #centered-panel{
                    height: auto !important;
                }

                #tabs {
                    height: 100%;
                }

 

            </style>

        </head>
        <body>
            <div class="container-covid">
            <div id="upper-panel" class=""><h1>Covid-19 data viewer</h1></div>
            <div class="row">
                <div id="left-panel" class="col-3">
                    <div id="tabs-left">
                        <ul>
                            <li><a href="#tabs-left-1">Derniers chiffres</a></li>
                        </ul>
                        <div id="tabs-left-1">
                            <div style="height:350px;overflow:scroll;position:relative;">
                                @include('last_stats_by_countries_inc')
                            </div>
                        </div>
                    </div>

                    <div id="tabs-right">
                        <ul>
                            <li><a href="#tabs-right-1">Evolution</a></li>
                        </ul>
                        <div id="tabs-right-1">
                        @include('graph_by_country_inc')
                        </div>
                    </div>


                </div>
                <div id="centered-panel" class="col-9">


                    <div id="tabs">
                        <ul>
                            <li id="tabs-1-selector"><a href="#tabs-1">Cas déclarés</a></li>
                            <li id="tabs-2-selector"><a href="#tabs-1">Décès</a></li>
                            <li id="tabs-3-selector"><a href="#tabs-1">Guérisons</a></li>
                            <li id="tabs-4-selector"><a href="#tabs-1">Cas actifs</a></li>  
                        </ul>
                        <div id="tabs-1">
                            @include('map_inc')
                        </div>
                    </div>


                </div>

            </div>
            <div id="lower-panel" class="">            
            </div>
            </div>



        </body>
    </html>

