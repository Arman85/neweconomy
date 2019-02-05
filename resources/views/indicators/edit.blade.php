@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Indicator
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($indicator, ['route' => ['indicators.update', $indicator->id], 'method' => 'patch']) !!}

                        @include('indicators.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection