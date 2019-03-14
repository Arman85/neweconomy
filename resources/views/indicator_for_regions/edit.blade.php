@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Indicator For Region
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($indicatorForRegion, ['route' => ['indicatorForRegions.update', $indicatorForRegion->id], 'method' => 'patch']) !!}

                        @include('indicator_for_regions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection