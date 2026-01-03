@extends('layouts.master')

@section('title', 'Users')
@section('nav', 'users')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mb-2">
                    <h1>Users</h1>
                    <div class="top-right-button-container">
                        <a href="#newUserModal" type="button" class="btn btn-primary btn-lg top-right-button mr-1" data-toggle="modal">ADD NEW</a>
                    </div>
                    
                </div>
                
                <div class="separator mb-5"></div>

                <div class="row mb-4">
                    
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- <h5 class="card-title">Light Heading</h5> -->

                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Verified</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    @if($user->image)
                                                    <img
                                                        src="{{ asset('img/profiles/' . ($user->image ?? 'default.png')) }}"
                                                        alt=""
                                                        style="width:35px;height:35px;border-radius:50%;object-fit:cover;"
                                                    >
                                                    @else
                                                    <img
                                                        src="{{ asset('img/profiles/default.png') }}"
                                                        alt=""
                                                        style="width:35px;height:35px;border-radius:50%;object-fit:cover;"
                                                    >
                                                    @endif
                                                    {{ $user->name }}
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- New User Modal -->
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('addUser') }}">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Name" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">Role *</label>
                                    <select name="role" class="form-control select2-single" id="idescription" data-width="100%" required>
                                        <option value="">Pick a Role</option>
                                        <option value="invigilator">Invigilator</option>
                                        <option value="lecturer">Lecturer</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p>User will be notified their account has been created with the Password.</p>
                            </div>
                        </div>


                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection