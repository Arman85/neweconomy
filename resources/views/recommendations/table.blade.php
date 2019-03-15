<table class="table table-responsive" id="recommendations-table">
    <thead>
        <tr>
            <th>Type</th>
        <th>Desc</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($recommendations as $recommendation)
        <tr>
            <td>{!! $recommendation->type !!}</td>
            <td>{!! $recommendation->desc !!}</td>
            <td>
                {!! Form::open(['route' => ['recommendations.destroy', $recommendation->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('recommendations.show', [$recommendation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('recommendations.edit', [$recommendation->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>