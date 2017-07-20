@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="col-md-2">
                  @if(file_exists(public_path().'/uploads/files/'.$image))
                  <img src={{ "/uploads/files/".$image}} width="100" height="100" alt="Admin Image" class="pull-left gap-right">
                  @else
                  <img src={{ $image}} width="100" height="100" alt="Admin Image" class="pull-left gap-right">
                  @endif
                </div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
