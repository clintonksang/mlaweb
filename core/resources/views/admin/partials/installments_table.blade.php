<div class="card ">
    <div class="card-body p-0">
        <div class="table-responsive--md table-responsive">
            <table class="table table--light style--two">
                <thead>
                    <tr>
                        <th>@lang('S.N.')</th>
                        <th>@lang('Installment Date')</th>
                        <th>@lang('Given On')</th>
                        <th>@lang('Delay')</th>
                        <th>@lang('Charge')</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($installments as $installment)
                        <tr>
                            <td>{{ __($loop->index + $installments->firstItem()) }}</td>
                            <td
                                class="{{ !$installment->given_at && $installment->installment_date < today() ? 'text--danger' : '' }}">
                                {{ showDateTime($installment->installment_date, 'd M, Y') }}
                            </td>
                            <td>
                                @if ($installment->given_at)
                                    {{ showDateTime($installment->given_at, 'd M, Y') }}
                                @else
                                    @lang('Not yet')
                                @endif
                            </td>
                            <td>
                                @if ($installment->given_at)
                                    {{ $installment->given_at->diffInDays($installment->installment_date) }}
                                    @lang('Day')
                                @else
                                    ...
                                @endif
                            </td>

                            <td>
                                {{ showAmount($installment->delay_charge) }}
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

    @if ($installments->hasPages())
        <div class="card-footer py-4">
            {{ paginateLinks($installments) }}
        </div>
    @endif
</div>

@push('style')
    <style>
        .list-group {
            gap: 1rem;
        }

        .list-group-item {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            border: 0;
            padding: 0;
        }

        .caption {
            font-size: 0.8rem;
            color: #b7b7b7;
        }

        .value {
            font-size: 1rem;
            color: #787d85;
            font-weight: 500;
        }
    </style>
@endpush
