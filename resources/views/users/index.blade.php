@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Permission')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/app-access-roles.js')}}"></script>
<script src="{{asset('assets/js/modal-add-role.js')}}"></script>
@endsection

@section('content')

@if (session('success'))
      <div class="alert alert-success" role="alert">
          {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger" role="alert">
          {{ session('error') }}
      </div>
    @endif

<div class="card">
  <div class="card-header d-flex justify-content-between m-5 mb-2">
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus p-2 pt-0 pb-0"></i>Add a User</a>
    <div class="search-container ">
      <form action="{{ route('users.index') }}" method="GET">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search Role..." name="search" value="">
          <button class="btn  btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
      </form>
    </div>
    <form action="{{ route('users.index') }}" method="GET">
      <div class="input-group ">
        <select name="filter" class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon" equired>
          <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Role</option>
          <option value="1" {{ $filter == '1' ? 'selected' : '' }}>Activated Role</option>
          <option value="0" {{ $filter == '0' ? 'selected' : '' }}>InActivated Role</option>
        </select>
        <button class="btn btn-outline-primary" type="submit">Filter</button>
      </div>
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive text-nowrap">

    <table class="table">
      <thead class="table-dark">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Role</th>
          <th>Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($users->isEmpty())
          <tr >
            <td colspan="5" class="text-center text-danger h5">No data available</td>
          </tr>
        @endif
        @foreach ($users as $user)
            <tr>
              <td>{{ $user->first_name }}</td>
              <td>
                @foreach ($user->role as $role)
                  {{ $role->role_name . ", "}}
                @endforeach
              </td>
              <td>
                <form action="{{ route('users.updateIsActive', ['id' => $user->id]) }}" method="POST">
                  @csrf
                  <input type="hidden" name="is_active" value="">
                  <div class="form-check form-switch">
                      <input class="form-check-input" onchange="submit()" type="checkbox" role="switch" id="switchCheckDefault" {{ $user->is_active == 1 ? 'checked' : '' }}>
                  </div>
                </form>
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('users.edit', ['id' => $user->id]) }}"><i class="ti ti-pencil me-1"></i> Edit</a>
                    <form action="{{ route('users.delete', ['id' => $user->id]) }}" method="post" dropdown-item>
                      @csrf
                      <button type="submit"  class="btn text-danger" id="confirm-text"><i class="ti ti-trash me-1"></i> Delete</button>
                    </form>
                    {{-- <button data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn text-primary add-new-role"><i class="fa-solid fa-plus p-2 pt-0 pb-0"></i> Add New Role</button> --}}
                    <a data-bs-target="#addRoleModal" data-bs-toggle="modal" class="dropdown-item add-new-role "><i class="ti ti-pencil me-1"></i> Reset Password</a>
                  </div>
                </div>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    </div>
  </div>
</div>

@include('users.resetPassword')

@endsection
