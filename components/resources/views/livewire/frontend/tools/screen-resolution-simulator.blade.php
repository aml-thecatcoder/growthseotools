<div>

      <form wire:submit.prevent="onScreenResolutionSimulator">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
                                    
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="row">
            <label class="form-label">{{ __('Enter a website URL') }}</label>
            <div class="col">
                <div class="input-group input-group-flat">
                    <input type="text" class="form-control" wire:model="link" placeholder="https://..." required />
                    <span class="input-group-text {{ ( Cookie::get('theme_mode') == 'theme-light' ) ? 'bg-white' : '' }}">
                        <a id="paste" class="link-secondary cursor-pointer" title="{{ __('Paste') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Paste') }}">
                            <i class="far fa-clipboard fa-fw {{ ( Cookie::get('theme_mode') == 'theme-dark') ? 'text-dark' : '' }}"></i>
                        </a>
                    </span>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">{{ __('Select Screen Resolution:') }}</label>

                    <select class="form-control form-select" wire:model="resolution">
                        <option value="160x160">{{ __('160x160') }} {{ __('Pixels') }}</option>
                        <option value="320x320">{{ __('320x320') }} {{ __('Pixels') }}</option>
                        <option value="640x480">{{ __('640x480') }} {{ __('Pixels') }}</option>
                        <option value="800x600">{{ __('800x600') }} {{ __('Pixels') }}</option>
                        <option value="1024x768">{{ __('1024x768') }} {{ __('Pixels') }}</option>
                        <option value="1152x864">{{ __('1152x864') }} {{ __('Pixels') }}</option>
                        <option value="1280x720">{{ __('1280x720') }} {{ __('Pixels') }}</option>
                        <option value="1366x768">{{ __('1366x768') }} {{ __('Pixels') }}</option>
                        <option value="1600x1200">{{ __('1600x1200') }} {{ __('Pixels') }}</option>
                        <option value="1920x1080">{{ __('1920x1080') }} {{ __('Pixels') }}</option>
                        <option value="custom">{{ __('Custom') }}</option>
                    </select>
                </div>
                
                @if ( $resolution == 'custom')
                    <div class="form-group my-3">
                        <label class="form-label">{{ __('Enter Custom Resolution:') }}</label>
                        <input type="text" class="form-control" wire:model="custom_resolution" placeholder="900x900" />
                    </div>
                @endif

            </div>

            <div class="form-group mb-0">
                <button class="btn bg-gradient-info mx-auto d-block" wire:loading.attr="disabled">
                    <span>
                        <div wire:loading.inline wire:target="onScreenResolutionSimulator">
                            <x-loading />
                        </div>
                        <span wire:target="onScreenResolutionSimulator">{{ __('Simulate') }}</span>
                    </span>
                </button>
            </div>
        </div>

      </form>
</div>

<script>
   (function( $ ) {
      "use strict";

        document.addEventListener('livewire:load', function () {

              var el = document.getElementById('paste');

              if(el){

                el.addEventListener('click', function(paste) {

                    paste = document.getElementById('paste');

                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <line x1="4" y1="7" x2="20" y2="7"></line> <line x1="10" y1="11" x2="10" y2="17"></line> <line x1="14" y1="11" x2="14" y2="17"></line> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path> </svg>' === paste.innerHTML ? (link.value = "", paste.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path><rect x="9" y="3" width="6" height="4" rx="2"></rect></svg>') : navigator.clipboard.readText().then(function(clipText) {

                        @this.set('link', clipText);

                    }, paste.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <line x1="4" y1="7" x2="20" y2="7"></line> <line x1="10" y1="11" x2="10" y2="17"></line> <line x1="14" y1="11" x2="14" y2="17"></line> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path> </svg>');

                });
              }

            window.addEventListener('onSetScreenResolution', event => {
                window.open(event.detail.link, event.detail.resolution,'toolbar=yes,location=yes,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=no,copyhistory=yes,width='+event.detail.width+',height='+event.detail.height);  
            });
        });

  })( jQuery );
</script>