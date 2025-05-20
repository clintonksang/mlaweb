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
                                    <th>@lang('Date')</th>
                                    <th>@lang('Start Day')</th>
                                    <th>@lang('Start Location')</th>
                                    <th>@lang('End Day')</th>
                                    <th>@lang('End Location')</th>
                                    <th>@lang('Notes')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($timesheets as $timesheet)
                                <tr>
                                    <td>{{ $timesheet->date->format('Y-m-d') }}</td>
                                    <td>{{ $timesheet->check_in ? $timesheet->check_in->format('H:i:s') : '-' }}</td>
                                    <td>{{ $timesheet->check_in_location ?? '-' }}</td>
                                    <td>{{ $timesheet->check_out ? $timesheet->check_out->format('H:i:s') : '-' }}</td>
                                    <td>{{ $timesheet->check_out_location ?? '-' }}</td>
                                    <td>{{ $timesheet->notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No timesheet records found') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($timesheets->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($timesheets) }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search by date..." />
    <a href="{{ route('admin.timesheets.export.pdf') }}" class="btn btn--primary">
        <i class="las la-file-pdf"></i> @lang('Export PDF')
    </a>
@endpush 