@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.permissions.permissions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('Permission Name')</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn--primary">@lang('Create Permission')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
