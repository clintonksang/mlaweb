@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card  ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Agent Name')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Loans Processed')</th>
                                    <th>@lang('Loan Amount Processed')</th>
                                    <th>@lang('New Users')</th>
                                    <th>@lang('New Applications')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($targets as $target)
                                    <tr>
                                        <td>{{ $targets->firstItem() + $loop->index }}</td>
                                        <td>{{ $target->user->fullname }}</td> <!-- Display agent's name from the relationship -->
                                        <td>{{ ucfirst($target->type) }}</td>
                                        <td>{{ $target->loans_processed }}</td>
                                        <td>{{ $target->loan_amount_processed }}</td>
                                        <td>{{ $target->new_users }}</td>
                                        <td>{{ $target->new_applications }}</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                    data-resource="{{ $target }}" data-id="{{ $target->id }}" data-modal_title="@lang('Edit Target')">
                                                    <i class="la la-pencil"></i> @lang('Edit')
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.targets.delete', $target->id) }}"
                                                    data-question="@lang('Are you sure to delete this target?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($targets->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($targets) }}
                    </div>
                @endif
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
                <form id="cuForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Agent Name')</label>
                            <select placeholder="Select Field Agent" name="user_id" class="form-control" required>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->firstname . " ". $agent->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Type')</label>
                            <select placeholder="Select Target Type" name="type" class="form-control" required>
                                <option value="daily">@lang('Daily')</option>
                                <option value="monthly">@lang('Monthly')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Loans Processed')</label>
                            <input type="number" name="loans_processed" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Loan Amount Processed')</label>
                            <input type="number" name="loan_amount_processed" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('New Users')</label>
                            <input type="number" name="new_users" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('New Loan Applications')</label>
                            <input type="number" name="new_applications" class="form-control" required>
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
        data-modal_title="@lang('Add New Target')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
<script>
    $(document).on('click', '.cuModalBtn', function () {
        let modalTitle = $(this).data('modal_title');
        let resource = $(this).data('resource') || null;
        let id = resource ? resource.id : ''; // Get the id if editing, otherwise empty for create

        $('#cuModal .modal-title').text(modalTitle);
        $('#cuForm').attr('action', "{{ route('admin.targets.store') }}/" + id);

        // Populate fields for edit or clear for create
        $('select[name="user_id"]').val(resource ? resource.user_id : '');
        $('select[name="type"]').val(resource ? resource.type : '');
        $('input[name="loans_processed"]').val(resource ? resource.loans_processed : '');
        $('input[name="loan_amount_processed"]').val(resource ? resource.loan_amount_processed : '');
        $('input[name="new_users"]').val(resource ? resource.new_users : '');
        $('input[name="new_applications"]').val(resource ? resource.new_applications : '');

        $('input[name="loans_processed"]').attr('placeholder', resource ? resource.loans_processed : 'Enter Loans Processed');
        $('input[name="loan_amount_processed"]').attr('placeholder', resource ? resource.loan_amount_processed : 'Enter Loan Amount Processed');
        $('input[name="new_users"]').attr('placeholder', resource ? resource.new_users : 'Enter New Users');
        $('input[name="new_applications"]').attr('placeholder', resource ? resource.new_applications : 'Enter New Loan Applications');
        
        $('#cuModal').modal('show');
    });
</script>
@endpush
