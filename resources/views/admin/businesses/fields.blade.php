<!-- Region Field -->
<div class="form-group col-sm-4">
    {!! Form::label('region', 'Region:') !!}
    {!! Form::select('region_id', App\Models\Region::dropdown(), null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-4">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-4">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-4">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Activity Cycle Field -->
<div class="form-group col-sm-4">
    {!! Form::label('cycle', 'Activity Cycle:') !!}
    {!! Form::select('cycle', App\Models\Admin\Business::cyclesDropdown(-1), null, ['class' => 'form-control']) !!}
</div>

<!-- Activity Cycle Field -->
<div class="form-group col-sm-4">
    {!! Form::label('assets', 'Assets:') !!}
    {!! Form::select('assets', App\Models\Admin\Business::assetsDropdown(-1), null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>




<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.businesses.index') !!}" class="btn btn-default">Cancel</a>
</div>
