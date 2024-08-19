@extends('admin.partials.main')
@section('page_title', 'Users')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endpush
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @if (Auth::user()->hasPermission('create user'))
                <div class="text-end">
                    <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
                        data-title="{{ __('Create User') }}" data-url="{{ route('create.users') }}" data-toggle="tooltip"
                        title="{{ __('Create User') }}">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            @endif
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-3 mb-4">
                        <div class="card p-3 d-flex flex-column justify-content-between"
                            style="width: 18rem; height: 350px; position: relative;">
                            <span
                                class="badge bg-primary position-absolute top-0 start-0 mt-2 ms-2 p-2">{{ $user->type }}</span>
                            @if (Auth::user()->hasPermission('edit user') || Auth::user()->hasPermission('delete user'))
                                <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
                                    <button class="dropdown-button p-0" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        @if (Auth::user()->hasPermission('edit user'))
                                            <li>
                                                <a class="dropdown-item" data-ajax-popup="true" data-size="md"
                                                    data-title="{{ __('Create User') }}"
                                                    data-url="{{ route('edit.user', ['user_id' => $user->id]) }}"
                                                    data-toggle="tooltip"
                                                    title="{{ __('Edit User') }}">{{ __('Edit') }}</a>
                                            </li>
                                        @endif
                                        @if (Auth::user()->hasPermission('delete user'))
                                            <li>
                                                <form action="{{ route('delete.user',['userId' => $user->id]) }}"
                                                    onsubmit="return confirm('Are You Sure You Want To Delete This User !!')" method="POST">
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
                                <h5 class="card-title mb-2">{{ $user->name }}</h5>
                                <p class="card-text mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
