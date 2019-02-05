<table class="table table-responsive" id="businesses-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Description</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($businesses as $business)
        <tr>
            <td>{!! $business->name !!}</td>
            <td>{!! $business->latitude !!}</td>
            <td>{!! $business->longitude !!}</td>
            <td>{!! $business->description !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.businesses.destroy', $business->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.businesses.show', [$business->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.businesses.edit', [$business->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>

                    <a href="{!! route('indicators.create', ['business_id' => $business->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-signal"></i></a>
                    

                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>