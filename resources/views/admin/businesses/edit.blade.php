@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Business
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                <?php //dd($business); ?>

                   {!! Form::model($business, ['route' => ['admin.businesses.update', $business->id], 'method' => 'patch']) !!}

                        @include('admin.businesses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection