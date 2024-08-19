@extends('admin.partials.main')
@section('page_title', 'Roles')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @if (Auth::user()->hasPermission('create role'))
                <div class="text-end">
                    <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
                        data-title="{{ __('Create Role') }}" data-url="{{ route('create.role') }}" data-toggle="tooltip"
                        title="{{ __('Create Role') }}">
                        <i class="ti ti-plus"></i>
                    </a>
                </div>
            @endif
            <div class="row">
                @foreach ($roles as $role)
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{ $role->name }}</h4>
                                <div class="media">
                                    {{ $role->permissions_count }}
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    @if (Auth::user()->hasPermission('edit role'))
                                        <div class="media-body">
                                            <a href="{{ route('edit.role', ['role_id' => $role->id]) }}"
                                                class="btn btn-link">
                                                {{ __('Edit') }}
                                            </a>
                                        </div>
                                    @endif

                                    @if (Auth::user()->hasPermission('delete role'))
                                        <div class="media-body ms-2">
                                            <form action="{{ route('delete.role', ['role_id' => $role->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
