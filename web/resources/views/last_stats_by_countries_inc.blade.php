<table class="table table-striped table-hover table-sm">
    <thead class="thead-dark">
        <tr>
            <th>Pays</th>
            <!-- th>Date</th -->
            <th>Cas</th>
            <th>Décès</th>
            <th>Guérisons</th>

        </tr>
    </thead>
    
    @foreach($reports as $report)
        <tr>
            <td><a href="javascript:refresh( '{{ $report->Country_Region }}' );">{{ $report->Country_Region }}</a></td>
            <!-- td>{{ $report->last_update }}</td -->

            <td>{{ $report->confirmed }}</td>
            <td>{{ $report->deaths }}</td>
            <td>{{ $report->recovered }}</td>

        </tr>
    @endforeach
</table>
