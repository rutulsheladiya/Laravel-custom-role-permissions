@extends('admin.partials.main')
@section('page_title', 'Companies')
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @endpush

    <div class="main-panel">
        <div class="content-wrapper">
            @if (Auth::user()->hasPermission('create company'))
                <div class="text-end">
                    <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
                        data-title="{{ __('Create Company') }}" data-url="{{ route('create.company') }}"
                        data-toggle="tooltip" title="{{ __('Create Company') }}">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            @endif

            <div class="row">
                @foreach ($allCompanies as $company)
                    <div class="col-md-3 mb-4">
                        <div class="card p-3 d-flex flex-column justify-content-between"
                            style="width: 18rem; height: 350px; position: relative;">
                            <span
                                class="badge bg-primary position-absolute top-0 start-0 mt-2 ms-2 p-2">{{ $company->type }}</span>
                            @if (Auth::user()->hasPermission('edit company') || Auth::user()->hasPermission('delete company'))
                                <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                    <button class="dropdown-button p-0" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        @if (Auth::user()->hasPermission('edit company'))
                                            <li>
                                                <a class="dropdown-item" href="#" data-ajax-popup="true"
                                                    data-size="md" data-title="{{ __('Edit Company') }}"
                                                    data-url="{{ route('edit.company', ['companyId' => $company->id]) }}"
                                                    data-toggle="tooltip"
                                                    title="{{ __('Edit Company') }}">{{ __('Edit') }}</a>
                                            </li>
                                        @endif
                                        @if (Auth::user()->hasPermission('delete company'))
                                            <li>
                                                <form action="{{ route('delete.company', ['companyId' => $company->id]) }}"
                                                    method="POST" onsubmit="return confirm('Are You Sure ?  You Want To Delete The Company.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item">{{ __('Delete') }}</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            <div class="d-flex justify-content-center align-items-center my-3" style="height: 150px;">
                                <img src="{{ asset('assets/images/avatar/avatar.png') }}"
                                    class="card-img-top rounded-circle w-50">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title mb-2">{{ $company->name }}</h5>
                                <p class="card-text mb-0">{{ $company->email }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('assets/js/custom.js') }}"></script>
