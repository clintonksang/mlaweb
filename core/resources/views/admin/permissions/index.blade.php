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
                                @forelse($roles as $role)
                                    <tr>
                                        <td>{{ $roles->firstItem() + $loop->index }}</td>
                                        <td>{{ __($role->name) }}</td>
                                        <td>{{ __($role->guard_name) }}</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.permissions.assign.permissions', ['role_id' => $role->id]) }}"
                                                    class="btn btn-sm btn-outline--info ms-1">
                                                    <i class="la la-key"></i> @lang('Assign Permissions')
                                                </a>
                                                <a href="{{ route('admin.permissions.roles.edit', $role->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-pencil"></i> @lang('Edit')
                                                </a>    
                                                <button type="button"
                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-action="{{ route('admin.permissions.roles.delete', $role->id) }}"
                                                    data-question="@lang('Are you sure to delete this role?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">@lang('No roles found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($roles->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($roles) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <a href="{{ route('admin.permissions.roles.create') }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i> @lang('Add New Role')
    </a>
@endpush
