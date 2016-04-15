@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in! Note everyone can view this page
                    <br>
                    @role('admin')
                    I'm a admin!
                    @else
                    I'm not admin...
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
