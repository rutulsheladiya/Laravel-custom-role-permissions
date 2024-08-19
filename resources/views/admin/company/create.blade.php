<form method="POST" action="{{ route('store.company') }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="company name" class="form-label">{{ __('Company Name') }}</label>
            <input class="form-control" name="company_name" type="text" id="company_name"
                placeholder="{{ __('Enter company Name') }}" value="{{ old('company_name') }}" >
        </div>
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input class="form-control" name="email" type="email" id="email"  
                placeholder="{{ __('Enter Your Email') }}" value="{{ old('email') }}">
        </div>

        <div class="form-group ps_div ">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input class="form-control" name="password" type="password" autocomplete="new-password" id="password"
                placeholder="{{ __('Enter Your Password') }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
    </div>
</form>
