@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Recommendation
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($recommendation, ['route' => ['recommendations.update', $recommendation->id], 'method' => 'patch']) !!}

                        @include('recommendations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection