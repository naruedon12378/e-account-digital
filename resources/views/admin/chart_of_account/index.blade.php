@extends('adminlte::page')
@php $pagename = __('chart_of_account.chart_of_account'); @endphp
@section('title', setting('title') . ' | ' . $pagename)

@section('content')
    @include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])

    <div class="ml-2 mb-3">
        @if (Auth::user()->hasAnyPermission(['*', 'all bank', 'create bank']))
            <a href="javascript:;" id="addAccount" class="btn {{ config('adminlte.classes_button.btn-outline-success') }}">
                <i class="fas fa-plus mr-2"></i>
                {{ __('chart_of_account.create_account') }}
            </a>
            <a href="" class="btn {{ config('adminlte.classes_button.btn-outline-success') }}" data-toggle="modal"
                data-target="#modal-bank-create">
                <i class="fas fa-plus mr-2"></i>
                {{ __('chart_of_account.create_bank') }}
            </a>
            <a href="" class="btn {{ config('adminlte.classes_button.btn-outline-success') }}">
                <i class="fas fa-plus mr-2"></i>
                {{ __('chart_of_account.export') }}
            </a>
        @endif
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-custom">
                <div class="card-body" style="overflow-y: auto; height:600px;">
                    @include('admin.chart_of_account.partials.chart-of-account', $accountClasses)
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8">
            <div class="card shadow-custom">
                <div class="card-header" style="border-bottom: none;">
                    <div class="d-flex justify-content-between flax-wrap">
                        <blockquote class="quote-success text-md" style="margin: 0 !important;">
                            {{ $account->account_code . ' - ' . $account->name_th }}
                        </blockquote>
                        @if ($account->company_id == 1)
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-success">Action</button>
                                <button type="button" class="btn btn-outline-success dropdown-toggle"
                                    data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="javascript:;" id="btnEdit"
                                        data-id="{{ $account->account_code }}"><i class="fas fa-edit"></i> Edit</a>
                                    <a class="dropdown-item text-danger" href="javascript:;"
                                        onclick="confirmDelete('{{ route('chart_of_account.destroy', $account->id) }}')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body px-5">
                    <dl class="row">
                        <dt class="col-sm-3">{{ __('chart_of_account.primary_account') . ' :' }} </dt>
                        <dd class="col-sm-9">{{ $account->primary_prefix . ' ' . $account->primary->name_th }}</dd>
                        <dt class="col-sm-3">{{ __('chart_of_account.secondary_account') . ' :' }} </dt>
                        <dd class="col-sm-9">{{ $account->secondary_prefix . ' ' . $account->secondary->name_th }}</dd>
                        <dt class="col-sm-3">{{ __('chart_of_account.sub_account') . ' :' }} </dt>
                        <dd class="col-sm-9">{{ $account->sub_prefix . ' ' . $account->subAccount->name_th }}</dd>
                        <dt class="col-sm-3">{{ __('chart_of_account.withholding_tax_rate') . ' :' }} </dt>
                        <dd class="col-sm-9">{{ $account->with_holding_tax_id }}</dd>
                        <dt class="col-sm-3">{{ __('chart_of_account.income_tax_rate') . ' :' }} </dt>
                        <dd class="col-sm-9">{{ $account->income_tax_id }}</dd>
                        <dt class="col-sm-3">{{ __('chart_of_account.description') . ' :' }} </dt>
                        <dd class="col-sm-9">{{ $account->description }}</dd>
                    </dl>
                </div>
            </div>
            <div class="card shadow-custom">
                <div class="card-header" style="border-bottom: none;">
                    <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
                        {{ __('payroll_setting.show_less') }}
                    </button>
                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                        {{ __('chart_of_account.sub_account') }}
                    </blockquote>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                        <thead class="bg-custom">
                            <tr>
                                <th class="text-center" style="width: 10%">{{ __('chart_of_account.no') }}</th>
                                <th class="text-center" style="width: 20%">
                                    {{ __('chart_of_account.sub_account') }}</th>
                                <th class="text-center">{{ __('chart_of_account.account_name') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                var accountObj = @json($account);
                toggleTreeView();

                $(document).on('click', '#btnEdit', function() {
                    for (const key in accountObj) {
                        $('#addAccountModal #frmAccount #' + key).val(accountObj[key]);
                    }
                    $('#primary_account_id option[value="' + accountObj.primary_account_id + '"]').attr(
                        'selected', 'selected');
                    getAccCategories(accountObj.primary_account_id, "secondary_account_id", accountObj
                        .secondary_account_id);
                    getAccCategories(accountObj.secondary_account_id, "sub_account_id", accountObj
                        .sub_account_id);

                    $('#addAccountModal').modal('show');
                });
            });

            $('input[name="search"]').keyup(function() {
                searchTreeView();
            });

            function searchTreeView() {
                let searchValue = $('input[name="search"]').val();
                if (searchValue.length > 0) {
                    $('#treeView').addClass('d-none');
                    $('#searchResult').removeClass('d-none');

                    $('#searchResult li').each(function() {
                        let accCode = $(this).attr('data-id');
                        if (!accCode.includes(searchValue)) {
                            $(this).addClass('d-none');
                        } else {
                            $(this).removeClass('d-none');
                        }
                    });
                } else {
                    $('#treeView').removeClass('d-none');
                    $('#searchResult').addClass('d-none');
                }
            }

            $('#addAccount').on('click', function() {
                $('#addAccountModal input').val('');
                $('#addAccountModal select').prop('selectedIndex', 0);
                $('#addAccountModal').modal('show');
            });

            $('#frmAccount #primary_account_id').on('change', function() {
                let primaryId = $(this).val();
                getAccCategories(primaryId, "secondary_account_id");
            });

            $('#frmAccount #secondary_account_id').on('change', function() {
                let secondaryId = $(this).val();
                getAccCategories(secondaryId, "sub_account_id");
            });

            $('#frmAccount #sub_account_id').on('change', function() {
                let subAccId = $(this).val();
                $.get('chart_of_account/get_last_acc_code/' + subAccId, function(data) {
                    $('#frmAccount #account_code').val(data.next_acc_code);
                    $('#frmAccount #primary_prefix').val(data.primary_prefix);
                    $('#frmAccount #secondary_prefix').val(data.secondary_prefix);
                    $('#frmAccount #sub_prefix').val(data.sub_prefix);
                    $('#frmAccount #running_number').val(data.next_running);
                });
            });

            function getAccCategories(parentId, inputName, selectedId = "") {
                let routeName = "";
                if (inputName === "secondary_account_id") {
                    routeName = "chart_of_account/get_secondary/" + parentId;
                } else if (inputName === "sub_account_id") {
                    routeName = "chart_of_account/get_subAcc/" + parentId;
                }
                $.get(routeName, function(data) {
                    $('#frmAccount #' + inputName).children().remove();
                    data.forEach((subAccount, index) => {
                        let option = "";
                        if (index === 0) {
                            option =
                                `<option value="">Select...</option><option value="${subAccount.id}">${subAccount.prefix} ${subAccount.local_name}</option>`;
                        } else {
                            option =
                                `<option value="${subAccount.id}">${subAccount.prefix} ${subAccount.local_name}</option>`;
                        }
                        $('#frmAccount #' + inputName).append(option);
                    });

                    if (inputName === "secondary_account_id") {
                        $('#secondary_account_id option[value="' + selectedId + '"]').attr('selected', 'selected');
                    } else if (inputName === "sub_account_id") {
                        $('#sub_account_id option[value="' + selectedId + '"]').attr('selected', 'selected');
                    }
                });
            }

            $('#frmAccount #btnSubmit').on('click', function() {
                let formData = new FormData($('#frmAccount')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ route('chart_of_account.store') }}",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        window.location.reload();
                    },
                    error: function(message) {
                        $('.invalid').html('');
                        for (const key in message.responseJSON.errors) {
                            if (key.includes('.')) {
                                let val = key.replace(key.slice(-2), '');
                                $('.invalid.' + val).html(message.responseJSON, errors[key]);
                            } else {
                                $('.invalid.' + key).html(message.responseJSON.errors[key]);
                            }
                        }
                    }
                });
            });

            $(function() {
                $('.tree li.parent_li > span').on('click', function(e) {
                    var children = $(this).parent('li.parent_li').find(' > ul > li');
                    if (children.is(":visible")) {
                        children.hide('fast');
                        $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign')
                            .removeClass('icon-minus-sign');
                    } else {
                        children.show('fast');
                        $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign')
                            .removeClass('icon-plus-sign');
                    }
                    e.stopPropagation();
                });
            });

            function toggleTreeView() {
                $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
                var children = $('.tree li.parent_li').find(' > ul > li');
                if (children.is(":visible")) {
                    children.hide('fast');
                } else {
                    children.show('fast');
                }
            }

            $('#treeViewHeader span').on('click', function() {
                toggleTreeView();
            });
        </script>
    @endpush

    @include('admin.chart_of_account.partials.create-bank-modal')
    @include('admin.chart_of_account.partials.create-modal')
@endsection
