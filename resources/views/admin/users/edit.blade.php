<form method="POST" action="{{ route('update.user',['user_id'=>$user->id]) }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="emp_name" class="form-label">{{ __('Enter Employee Name') }}</label>
            <input class="form-control" name="emp_name" type="text" id="emp_name"
                placeholder="{{ __('Enter Employee Name') }}" value="{{ $user->name }}">
        </div>

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Enter Employee Email') }}</label>
            <input class="form-control" name="email" type="text" id="email"
                placeholder="{{ __('Enter Role Email') }}" value="{{ $user->email }}">
        </div>

        <div class="form-group">
            <label for="role">{{ __('Select Role') }}</label>
            <select class="form-select" id="role" name="role">
                <option selected disabled>{{ __('Select Role') }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->type == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
    </div>
</form>
