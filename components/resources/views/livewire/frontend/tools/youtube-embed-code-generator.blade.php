<div>

      <form wire:submit.prevent="onYoutubeEmbedCodeGenerator">

            <div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                                            
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
            </div>
        
            <div class="form-group">
                <label class="form-label">{{ __('Enter YouTube Video URL') }}</label>
                <div class="input-group input-group-flat">
                    <input type="text" class="form-control" wire:model="link" placeholder="https://..." required />
                    <span class="input-group-text {{ ( Cookie::get('theme_mode') == 'theme-light' ) ? 'bg-white' : '' }}">
                        <a id="paste" class="link-secondary cursor-pointer" title="{{ __('Paste') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Paste') }}">
                            <i class="far fa-clipboard fa-fw {{ ( Cookie::get('theme_mode') == 'theme-dark') ? 'text-dark' : '' }}"></i>
                        </a>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('Size') }}</label>
                (<small class="text-sm">{{ __('Leave blank if you do not want to specify. Default: 560x315') }}</small>)
                <div class="input-group">
                    <input type="text" class="form-control" wire:model="size_width" placeholder="{{ __('Width') }}">
                    <div class="input-group-prepend bg-secondary">
                        <span class="input-group-text bg-secondary border-0 text-white">{{ __('x') }}</span>
                    </div>
                    <input type="text" class="form-control ps-2" wire:model="size_height" placeholder="{{ __('Height') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('Start time') }}</label>
                (<small class="text-sm">{{ __('Leave blank if you do not want to specify') }}</small>)
                <div class="input-group">
                    <input type="text" class="form-control" wire:model="start_min" placeholder="{{ __('Minute(s)') }}">
                    <div class="input-group-prepend bg-secondary">
                        <span class="input-group-text bg-secondary border-0 text-white">{{ __(':') }}</span>
                    </div>
                    <input type="text" class="form-control ps-2" wire:model="start_sec" placeholder="{{ __('Second(s)') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('End time') }}</label>
                (<small class="text-sm">{{ __('Leave blank if you do not want to specify') }}</small>)
                <div class="input-group">
                    <input type="text" class="form-control" wire:model="end_min" placeholder="{{ __('Minute(s)') }}">
                    <div class="input-group-prepend bg-secondary">
                        <span class="input-group-text bg-secondary border-0 text-white">{{ __(':') }}</span>
                    </div>
                    <input type="text" class="form-control ps-2" wire:model="end_sec" placeholder="{{ __('Second(s)') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label ms-0">
                    <span class="badge badge-pill badge-lg bg-gradient-success rounded-1">{{ __('Options') }}</span>
                </label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="loop_video">
                  <label class="custom-control-label">{{ __('Loop video') }}</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="auto_play_video">
                  <label class="custom-control-label">{{ __('Auto play video') }}</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="hide_full_screen_button">
                  <label class="custom-control-label">{{ __('Hide Full-screen button') }}</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="hide_player_controls">
                  <label class="custom-control-label">{{ __('Hide player controls') }}</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="hide_youtube_logo">
                  <label class="custom-control-label">{{ __('Hide YouTube logo') }}</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="no_cookie">
                  <label class="custom-control-label">{{ __('Privacy enhanced (only cookie when user starts video)') }}</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" wire:model="responsive">
                  <label class="custom-control-label">{{ __('Responsive (auto scale to available width)') }}</label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn bg-gradient-info mx-auto d-block" wire:loading.attr="disabled">
                    <span>
                        <div wire:loading.inline wire:target="onYoutubeEmbedCodeGenerator">
                            <x-loading />
                        </div>
                        <span wire:target="onYoutubeEmbedCodeGenerator">{{ __('Generate') }}</span>
                    </span>
                </button>
            </div>

            @if ( !empty($data) )

                <fieldset class="form-fieldset bg-gradient-secondary rounded p-3 mt-3">
                    <div class="form-group">
                      <label class="form-label text-white">{{ __('HTML embed code') }}</label>
                      <textarea id="text" class="form-control" rows="6">{{ $data }}</textarea>
                    </div>

                    <div class="form-group mb-0">
                        <a class="btn bg-gradient-success" value="copy" onclick="copyToClipboard()">{{ __('Copy HTML to clipboard') }}</a>
                    </div>
                </fieldset>

                <fieldset class="form-fieldset bg-gradient-secondary rounded p-3 mt-3">
                    <div class="form-group">
                        <label class="form-label text-white">{{ __('Preview') }}</label>
                    </div>
                    
                    <div class="form-group">
                      {!! $data !!}
                    </div>
                </fieldset>
            @endif
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
        });

  })( jQuery );
</script>