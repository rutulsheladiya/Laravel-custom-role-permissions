<form method="POST" action="{{ route('update.company', ['companyId' => $company->id]) }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="company name" class="form-label">{{ __('Company Name') }}</label>
            <input class="form-control" name="company_name" type="text" id="company_name"
                placeholder="{{ __('Enter company Name') }}" value="{{ $company->name }}">
        </div>
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input class="form-control" name="email" type="email" id="email"
                placeholder="{{ __('Enter Your Email') }}" value="{{ $company->email }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
    </div>
</form>
