@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.permissions.roles.update', $role->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('Role Name')</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                        </div>
                        <button type="submit" class="btn btn--primary">@lang('Update Role')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
