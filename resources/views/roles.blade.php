
@extends('layouts.app')

@section('title') Roles @endsection

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-key"></i> Roles</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>
                 
                    <td>{{ $role->name }}</td>
                    
                    <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>
                    <td>
                    <a href="#" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                    <a href="#" class="btn btn-danger" style="margin-right: 3px;">Delete</a>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="/admin/role/create" class="btn btn-success">Add Role</a>

</div>

@endsection
