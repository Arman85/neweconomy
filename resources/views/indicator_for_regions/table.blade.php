<table class="table table-responsive" id="indicatorForRegions-table">
    <thead>
        <tr>
            <th>Region</th>
            <th>Year</th>
            <th>If</th>
            <th>P</th>
            <th>As</th>
            <th>I</th>
            <th>Z</th>
            <th>Ef Fin</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($indicatorForRegions as $indicatorForRegion)
        <tr>
            <td>{!! $indicatorForRegion->region->name !!}</td>
            <td>{!! $indicatorForRegion->year !!}</td>
            <td>{!! $indicatorForRegion->if !!}</td>
            <td>{!! $indicatorForRegion->p !!}</td>
            <td>{!! $indicatorForRegion->as !!}</td>
            <td>{!! $indicatorForRegion->i !!}</td>
            <td>{!! $indicatorForRegion->z !!}</td>
            <td>{!! $indicatorForRegion->ef_fin !!}  <a href="{!! route('indicatorForRegions.calculate', [$indicatorForRegion->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-refresh"></i></a></td>
            <td>
                {!! Form::open(['route' => ['indicatorForRegions.destroy', $indicatorForRegion->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('indicatorForRegions.show', [$indicatorForRegion->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('indicatorForRegions.edit', [$indicatorForRegion->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>