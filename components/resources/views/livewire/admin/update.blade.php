<div>

    <form wire:submit.prevent="onUpdateDatabase" class="row">

        <!-- Begin:Update -->
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-4 p-sm-5">

                    <img src="{{ asset('assets/img/update.svg') }}" height="128" class="mb-n2">
                    <h3 class="mt-5">{{ __('Update') }}</h3>
                    <p class="text-muted">{{ __('Click the button below to update the database to the latest version!') }}</p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                                                
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <div class="form-group mb-0">
                        <button class="btn bg-gradient-primary">
                            <span>
                                <div wire:loading wire:target="onUpdateDatabase">
                                    <x-loading />
                                </div>
                                <span>{{ __('Start') }}</span>
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- End:Update -->

    </form>

</div>