<form method="POST" action="{{ route('store.user') }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="emp_name" class="form-label">{{ __('Enter Employee Name') }}</label>
            <input class="form-control" name="emp_name" type="text" id="emp_name"
                placeholder="{{ __('Enter Employee Name') }}" value="{{ old('emp_name') }}">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Enter Employee Email') }}</label>
            <input class="form-control" name="email" type="text" id="email"
                placeholder="{{ __('Enter Role Email') }}" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">{{ __('Enter Password') }}</label>
            <input class="form-control" name="password" type="text" id="password"
                placeholder="{{ __('Enter Role Password') }}" value="{{ old('password') }}">
        </div>

        <div class="form-group">
            <label for="role">{{ __('Select Role') }}</label>
            <select class="form-select" id="role" name="role">
                <option selected disabled>{{ __('Select Role') }}</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option> 
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
    </div>
</form>
