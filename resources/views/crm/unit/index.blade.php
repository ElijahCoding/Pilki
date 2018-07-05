@extends('crm.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($units as $unit)
                <div class="col-md-12">
                    {{ $unit->name }}
                </div>
            @endforeach
        </div>
    </div>
@endsection