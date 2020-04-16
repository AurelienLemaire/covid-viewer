<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Covid Viewer</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        </head>
        <body>

            <div class="container">

                <h1>Derniers chiffres</h1>

                <br/>

                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Pays</th>
                            <th>Date</th>
                            <th>Cas</th>
                            <th>Décès</th>
                            <th>Guérisons</th>

                        </tr>
                    </thead>
                    
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->Country_Region }}</td>
                            <td>{{ $report->last_update }}</td>

                            <td>{{ $report->confirmed }}</td>
                            <td>{{ $report->deaths }}</td>
                            <td>{{ $report->recovered }}</td>

                        </tr>
                    @endforeach
                </table>

                <hr/>

                {{ $reports->appends(request()->except('page'))->links() }}

            </div>
        </body>
    </html>

