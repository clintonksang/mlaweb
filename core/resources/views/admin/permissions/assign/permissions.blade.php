@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.permissions.assign.permissions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="role_id">@lang('Select Role')</label>
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">@lang('Select One')</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ isset($selectedRole) && $selectedRole->id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="permissions">@lang('Assign Permissions')</label>
                            <select name="permissions[]" id="permissions" class="form-control" multiple required style="height: 200px;">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->name }}" {{ in_array($permission->name, $selectedPermissions) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn--primary">@lang('Assign Permissions')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
