@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card  ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Plan')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Application Charge')</th>
                                    <th>@lang('Limit')</th>
                                    <th>@lang('Installment')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                    <tr>
                                        <td>{{ __($loop->index + $plans->firstItem()) }}</td>

                                        <td>
                                            <span class="fw-bold text--primary">{{ __($plan->name) }}</span>
                                            @if ($plan->is_featured)
                                                <i class="las la-certificate text--warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="@lang('Featured')"></i>
                                            @endif
                                            <br>
                                            @lang('For')
                                            <span class="fw-bold">
                                                {{ $plan->total_installment * $plan->installment_interval }}
                                            </span>
                                            @lang('days')
                                        </td>

                                        <td><b>{{ __(@$plan->category->name) }}</b>
                                            <small class="d-block"> {{__(@$plan->subheading)}}</small>
                                        </td>

                                        <td>
                                            <span class="fw-bold">@lang('Fixed'):</span>
                                            {{ showAmount($plan->application_fixed_charge) }}
                                            <br>
                                            <span class="fw-bold">@lang('Percent'):</span>
                                            {{ showAmount($plan->application_percent_charge, currencyFormat:false) }}%
                                        </td>
                                        <td>
                                            <span class="fw-bold">@lang('Min'):</span>
                                            {{ showAmount($plan->minimum_amount) }}
                                            <br>
                                            <span class="fw-bold">@lang('Max'):</span>
                                            {{ showAmount($plan->maximum_amount) }}
                                        </td>

                                        <td>
                                            <span class="text--primary">{{ $plan->per_installment + 0 }}%</span>
                                            @lang('every')
                                            <span class="text--primary">{{ $plan->installment_interval }}</span>
                                            @lang('Days')
                                            <br>
                                            @lang('for') <span
                                                class="text--primary">{{ $plan->total_installment }}</span>
                                            @lang('Times')
                                        </td>

                                        <td> @php echo $plan->statusBadge; @endphp </td>

                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.plans.loan.edit', $plan->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </a>

                                                @if ($plan->status)
                                                    <button type="button"
                                                        data-action="{{ route('admin.plans.loan.status', $plan->id) }}"
                                                        data-question="@lang('Are you sure to disable this plan?')"
                                                        class="btn btn-sm confirmationBtn btn-outline--danger">
                                                        <i class="la la-la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        data-action="{{ route('admin.plans.loan.status', $plan->id) }}"
                                                        data-question="@lang('Are you sure to enable this plan?')"
                                                        class="btn btn-sm confirmationBtn btn-outline--success">
                                                        <i class="la la-la la-eye"></i>@lang('Enable')
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
                </div>
                @if ($plans->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($plans) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <a href="{{ route('admin.plans.loan.create') }}" class="btn btn-sm btn-outline--primary">
        <i class="la la-plus"></i> @lang('Add New')
    </a>
@endpush
