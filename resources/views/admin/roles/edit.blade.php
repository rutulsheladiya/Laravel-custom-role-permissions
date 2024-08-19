@extends('admin.partials.main')
@section('page_title', 'Roles')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Role</h4>
                            <form class="forms-sample" action="{{ route('update.role', ['role_id' => $role->id]) }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputName1">Role Name</label>
                                    <input type="text" class="form-control" value="{{ $role->name ?? '' }}" disabled>
                                </div>

                                <div class="col-12">
                                    <h5>{{ __('Role Permissions') }}</h5>
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                                <tr>
                                                    <td class="text-nowrap fw-semibold">{{ __('Company Access') }} <i
                                                            class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Allows a full access to the system"></i></td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="selectAll" />
                                                            <label class="form-check-label" for="selectAll">
                                                                {{ __('Select All') }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @foreach ($permissions as $scope => $permissionArr)
                                                    <tr>
                                                        <td class="text-nowrap fw-semibold  text-capitalize">
                                                            {{ $scope }}
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                @foreach ($permissionArr as $permission)
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                name="permissions[]"
                                                                                value="{{ $permission->id }}"
                                                                                type="checkbox" id="{{ $permission->name }}"
                                                                                {{ in_array($permission->id, $assignedPermissions) ? 'checked' : '' }} />
                                                                            <label class="form-check-label"
                                                                                for="{{ $permission->name }}">
                                                                                {{ $permission->name }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        // Get the selectAll checkbox
        var selectAllCheckbox = document.getElementById("selectAll");

        // Get all other checkboxes
        var permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
        

        
        // Add a click event listener to the selectAll checkbox
        selectAllCheckbox.addEventListener("click", function() {
            // Toggle the checked property for all other checkboxes based on the selectAll checkbox
            permissionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Function to update the state of the selectAll checkbox
        function updateSelectAll() {
            var allChecked = Array.from(permissionCheckboxes).every(function(checkbox) {
                return checkbox.checked;
            });

            selectAllCheckbox.checked = allChecked;
        }


        // Add a click event listener to each permission checkbox
        permissionCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener("click", function() {
                // Check if all other checkboxes are checked and update selectAll accordingly
                updateSelectAll();
            });
        });

        // Update the state of the selectAll checkbox on page load
        updateSelectAll();
    </script>
@endpush
