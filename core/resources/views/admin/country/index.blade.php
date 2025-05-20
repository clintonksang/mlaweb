@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#countries">@lang('Countries')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#regions">@lang('Regions')</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <!-- Countries Tab -->
                        <div class="tab-pane fade show active" id="countries">
                            <div class="table-responsive--md table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Code')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($countries as $country)
                                            <tr>
                                                <td>{{ $countries->firstItem() + $loop->index }}</td>
                                                <td>{{ __($country->name) }}</td>
                                                <td>{{ __($country->code) }}</td>
                                                <td>@php echo $country->statusBadge; @endphp</td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                            data-resource="{{ $country }}" data-id="{{ $country->id }}" data-modal_title="@lang('Edit Country')"
                                                            data-has_status="1" data-type="country"> 
                                                            <i class="la la-pencil"></i>@lang('Edit')
                                                        </button>
                                                        @if ($country->status == Status::DISABLE)
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                                data-action="{{ route('admin.country.status', $country->id) }}"
                                                                data-question="@lang('Are you sure to enable this country?')">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                                data-action="{{ route('admin.country.status', $country->id) }}"
                                                                data-question="@lang('Are you sure to disable this country?')">
                                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($countries->hasPages())
                                <div class="card-footer py-4">
                                    {{ paginateLinks($countries) }}
                                </div>
                            @endif
                        </div>

                        <!-- Regions Tab -->
                        <div class="tab-pane fade" id="regions">
                            <div class="table-responsive--md table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Country')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($regions as $region)
                                            <tr>
                                                <td>{{ $regions->firstItem() + $loop->index }}</td>
                                                <td>{{ __($region->name) }}</td>
                                                <td>{{ __($region->country->name) }}</td>
                                                <td>@php echo $region->statusBadge; @endphp</td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                            data-resource="{{ $region }}" data-id="{{ $region->id }}" data-modal_title="@lang('Edit Region')"
                                                            data-has_status="1" data-type="region"> 
                                                            <i class="la la-pencil"></i>@lang('Edit')
                                                        </button>
                                                        @if ($region->status == Status::DISABLE)
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                                data-action="{{ route('admin.region.status', $region->id) }}"
                                                                data-question="@lang('Are you sure to enable this region?')">
                                                                <i class="la la-eye"></i> @lang('Enable')
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                                data-action="{{ route('admin.region.status', $region->id) }}"
                                                                data-question="@lang('Are you sure to disable this region?')">
                                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($regions->hasPages())
                                <div class="card-footer py-4">
                                    {{ paginateLinks($regions) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Cu Modal -->
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form id="cuForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group country-field">
                            <label>@lang('Code')</label>
                            <input type="text" name="code" class="form-control">
                        </div>
                        <div class="form-group region-field d-none">
                            <label>@lang('Country')</label>
                            <select name="country_id" class="form-control">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ __($country->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
        data-modal_title="@lang('Add New Country')" data-type="country">
        <i class="las la-plus"></i>@lang('Add New Country')
    </button>
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
        data-modal_title="@lang('Add New Region')" data-type="region">
        <i class="las la-plus"></i>@lang('Add New Region')
    </button>
@endpush

@push('script')
<script>
    $(document).on('click', '.cuModalBtn', function () {
        let type = $(this).data('type');
        let modalTitle = $(this).data('modal_title');
        let id = $(this).data('id');
        $('#cuModal .modal-title').text(modalTitle);
        $('#cuForm').attr('action', type === 'country' 
            ? "{{ route('admin.country.store') }}/" + id 
            : "{{ route('admin.region.store') }}/" + id);
        if (type === 'country') {
            $('.country-field').removeClass('d-none');
            $('.region-field').addClass('d-none');
        } else {
            $('.country-field').addClass('d-none');
            $('.region-field').removeClass('d-none');
        }
        $('#cuModal').modal('show');
    });
</script>
@endpush
