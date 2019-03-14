<!-- Region Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('region_id', 'Region Id:') !!}
    {!! Form::select('region_id', App\Models\Region::dropdown(), $regionId, ['class' => 'form-control']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::text('year', null, ['class' => 'form-control']) !!}
</div>

<!-- If Field -->
<div class="form-group col-sm-6">
    {!! Form::label('if', 'If:') !!}
    {!! Form::text('if', null, ['class' => 'form-control']) !!}
</div>

<!-- P Field -->
<div class="form-group col-sm-6">
    {!! Form::label('p', 'P:') !!}
    {!! Form::text('p', null, ['class' => 'form-control']) !!}
</div>

<!-- As Field -->
<div class="form-group col-sm-6">
    {!! Form::label('as', 'As:') !!}
    {!! Form::text('as', null, ['class' => 'form-control']) !!}
</div>

<!-- I Field -->
<div class="form-group col-sm-6">
    {!! Form::label('i', 'I:') !!}
    {!! Form::text('i', null, ['class' => 'form-control']) !!}
</div>

<!-- Z Field -->
<div class="form-group col-sm-6">
    {!! Form::label('z', 'Z:') !!}
    {!! Form::text('z', null, ['class' => 'form-control']) !!}
</div>

<!-- Ef Fin Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('ef_fin', 'Ef Fin:') !!}
    {!! Form::text('ef_fin', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('indicatorForRegions.index') !!}" class="btn btn-default">Cancel</a>
</div>
