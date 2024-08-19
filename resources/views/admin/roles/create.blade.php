<form method="POST" action="{{ route('store.role') }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="role_name" class="form-label">{{ __('Enter Role Name') }}</label>
            <input class="form-control" name="role_name" type="text" id="role_name"
                placeholder="{{ __('Enter Role Name') }}" value="{{ old('role_name') }}" >
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
    </div>
</form>
