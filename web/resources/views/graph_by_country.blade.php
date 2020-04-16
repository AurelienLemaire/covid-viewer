<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Opérations bancaires</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
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

            </script>
        </head>
        <body>

<a href="javascript:refresh( 'France' );">France</a>
<a href="javascript:refresh( 'Italy' );">Italy</a>

<a href="javascript:refresh( 'China' );">China</a>


            <div class="container">

                <h1>Graphiques</h1>

                <br/>

                <div id="app">
                    {!! $chart->container() !!}
                </div>               
                  

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

  
        
        {!! $chart->script() !!}

            </div>
        </body>
    </html>

