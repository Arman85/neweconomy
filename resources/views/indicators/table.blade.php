<table class="table table-responsive" id="indicators-table">
    <thead>
        <tr>
            <th>Business</th>
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
    @foreach($indicators as $indicator)
        <tr>
            <td>{!! $indicator->business->name !!}</td>
            <td>{!! $indicator->year !!}</td>
            <td>{!! $indicator->if !!}</td>
            <td>{!! $indicator->p !!}</td>
            <td>{!! $indicator->as !!}</td>
            <td>{!! $indicator->i !!}</td>
            <td>{!! $indicator->z !!}</td>
            <td>{!! $indicator->ef_fin !!} <a href="{!! route('indicators.calculate', [$indicator->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-refresh"></i></a></td>
            <td>
                {!! Form::open(['route' => ['indicators.destroy', $indicator->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('indicators.show', [$indicator->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('indicators.edit', [$indicator->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>