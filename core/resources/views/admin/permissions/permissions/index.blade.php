@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Guard')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $loop->index }}</td>
                                        <td>{{ __($permission->name) }}</td>
                                        <td>{{ __($permission->guard_name) }}</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.permissions.permissions.edit', $permission->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-pencil"></i> @lang('Edit')
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-action="{{ route('admin.permissions.permissions.delete', $permission->id) }}"
                                                    data-question="@lang('Are you sure to delete this permission?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">@lang('No permissions found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($permissions->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($permissions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.permissions.permissions.create') }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i> @lang('Add New Permission')
    </a>
@endpush
