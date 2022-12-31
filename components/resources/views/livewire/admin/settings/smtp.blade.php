<div>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
	<form wire:submit.prevent="onUpdateSMTP" wire:ignore>
	
		<div class="card">
			<div class="card-header bg-gradient-info">
				<h6 class="card-title text-white mb-0">{{ __('SMTP Configuration Settings') }}</h6>
			</div>
			<div class="card-body">
				<table class="table table-hover settings">

					<tr>
						<td><label for="mail_from_address" class="form-label">{{ __('From Email Address') }}</label></td>
						<td>
							<input id="mail_from_address" class="form-control ms-auto" type="text" wire:model="mail_from_address" placeholder="noreply@themeluxury.com">
							<small class="form-hint">{{ __('This email address will be used in the \'From\' field.') }}</small>
						</td>
					</tr>

					<tr>
						<td class="align-middle"><label for="host" class="form-label">{{ __('Host') }}</label></td>
						<td class="align-middle">
							<input id="host" class="form-control ms-auto" type="text" wire:model="host" placeholder="smtp.gmail.com">
							<small class="form-hint">{{ __('Your mail server.') }}</small>
						</td>
					</tr>

					<tr>
						<td class="align-middle"><label for="port" class="form-label">{{ __('Port') }}</label></td>
						<td class="align-middle">
							<input id="port" class="form-control ms-auto" type="text" wire:model="port" placeholder="587">
							<small class="form-hint">{{ __('The port to your mail server.') }}</small>
						</td>
					</tr>

					<tr>
						<td class="align-middle"><label for="username" class="form-label">{{ __('Username') }}</label></td>
						<td class="align-middle">
							<input id="username" class="form-control ms-auto" type="text" wire:model="username" placeholder="themeluxury@gmail.com">
							<small class="form-hint">{{ __('The username to login to your mail server.') }}</small>
						</td>
					</tr>

					<tr>
						<td class="align-middle"><label for="password" class="form-label">{{ __('Password') }}</label></td>
						<td class="align-middle">
							<input id="password" class="form-control ms-auto" type="password" wire:model="password" placeholder="hpnsegxygohzob">
							<small class="form-hint">{{ __('The password to login to your mail server.') }}</small>
						</td>
					</tr>

					<tr>
						<td><label for="encryption" class="form-label">{{ __('Encryption') }}</label></td>
						<td>
							<select id="encryption" class="form-control ms-auto" type="text" wire:model="encryption">
								<option value="tls">TLS</option>
								<option value="ssl">SSL</option>
							</select>
							<small class="form-hint">{{ __('For most servers SSL/TLS is the recommended option.') }}</small>
						</td>
					</tr>

				</table>			

			</div>
		</div>

		<div class="form-group mt-4">
			<button class="btn bg-gradient-primary float-end">
				<span>
					<div wire:loading wire:target="onUpdateSMTP">
						<x-loading />
					</div>
					<span>{{ __('Save Changes') }}</span>
				</span>
			</button>
		</div>

	</form>

</div>

<script>
(function( $ ) {
	"use strict";

	document.addEventListener('livewire:load', function () {
		
		window.addEventListener('alert', event => {
			toastr[event.detail.type](event.detail.message);
		});

	});

})( jQuery );
</script>