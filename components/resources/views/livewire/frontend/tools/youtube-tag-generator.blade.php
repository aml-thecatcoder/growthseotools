<div>

      <form wire:submit.prevent="onYoutubeTagGenerator">

        <div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
                                        
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>
    
            <div class="row">

                <div class="form-group mb-3 row">
                    <label class="form-label col-3 col-form-label">{{ __('Enter your keyword') }}</label>
                    <div class="col">
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control" wire:model="query" placeholder="seo" required />
                            <span class="input-group-text {{ ( Cookie::get('theme_mode') == 'theme-light' ) ? 'bg-white' : '' }}">
                                <a id="paste" class="link-secondary cursor-pointer" title="{{ __('Paste') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Paste') }}">
                                    <i class="far fa-clipboard fa-fw {{ ( Cookie::get('theme_mode') == 'theme-dark') ? 'text-dark' : '' }}"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">{{ __('Language') }}</label>
                <div class="col">
                    <select class="form-control form-select" wire:model="lang" required>
                      <option value="AF">{{ __('Afrikaans') }}</option>
                      <option value="SQ">{{ __('Albanian') }}</option>
                      <option value="AR">{{ __('Arabic') }}</option>
                      <option value="HY">{{ __('Armenian') }}</option>
                      <option value="EU">{{ __('Basque') }}</option>
                      <option value="BN">{{ __('Bengali') }}</option>
                      <option value="BG">{{ __('Bulgarian') }}</option>
                      <option value="CA">{{ __('Catalan') }}</option>
                      <option value="KM">{{ __('Cambodian') }}</option>
                      <option value="ZH">{{ __('Chinese (Mandarin)') }}</option>
                      <option value="HR">{{ __('Croatian') }}</option>
                      <option value="CS">{{ __('Czech') }}</option>
                      <option value="DA">{{ __('Danish') }}</option>
                      <option value="NL">{{ __('Dutch') }}</option>
                      <option value="EN">{{ __('English') }}</option>
                      <option value="ET">{{ __('Estonian') }}</option>
                      <option value="FJ">{{ __('Fiji') }}</option>
                      <option value="FI">{{ __('Finnish') }}</option>
                      <option value="FR">{{ __('French') }}</option>
                      <option value="KA">{{ __('Georgian') }}</option>
                      <option value="DE">{{ __('German') }}</option>
                      <option value="EL">{{ __('Greek') }}</option>
                      <option value="GU">{{ __('Gujarati') }}</option>
                      <option value="HE">{{ __('Hebrew') }}</option>
                      <option value="HI">{{ __('Hindi') }}</option>
                      <option value="HU">{{ __('Hungarian') }}</option>
                      <option value="IS">{{ __('Icelandic') }}</option>
                      <option value="ID">{{ __('Indonesian') }}</option>
                      <option value="GA">{{ __('Irish') }}</option>
                      <option value="IT">{{ __('Italian') }}</option>
                      <option value="JA">{{ __('Japanese') }}</option>
                      <option value="JW">{{ __('Javanese') }}</option>
                      <option value="KO">{{ __('Korean') }}</option>
                      <option value="LA">{{ __('Latin') }}</option>
                      <option value="LV">{{ __('Latvian') }}</option>
                      <option value="LT">{{ __('Lithuanian') }}</option>
                      <option value="MK">{{ __('Macedonian') }}</option>
                      <option value="MS">{{ __('Malay') }}</option>
                      <option value="ML">{{ __('Malayalam') }}</option>
                      <option value="MT">{{ __('Maltese') }}</option>
                      <option value="MI">{{ __('Maori') }}</option>
                      <option value="MR">{{ __('Marathi') }}</option>
                      <option value="MN">{{ __('Mongolian') }}</option>
                      <option value="NE">{{ __('Nepali') }}</option>
                      <option value="NO">{{ __('Norwegian') }}</option>
                      <option value="FA">{{ __('Persian') }}</option>
                      <option value="PL">{{ __('Polish') }}</option>
                      <option value="PT">{{ __('Portuguese') }}</option>
                      <option value="PA">{{ __('Punjabi') }}</option>
                      <option value="QU">{{ __('Quechua') }}</option>
                      <option value="RO">{{ __('Romanian') }}</option>
                      <option value="RU">{{ __('Russian') }}</option>
                      <option value="SM">{{ __('Samoan') }}</option>
                      <option value="SR">{{ __('Serbian') }}</option>
                      <option value="SK">{{ __('Slovak') }}</option>
                      <option value="SL">{{ __('Slovenian') }}</option>
                      <option value="ES">{{ __('Spanish') }}</option>
                      <option value="SW">{{ __('Swahili') }}</option>
                      <option value="SV">{{ __('Swedish ') }}</option>
                      <option value="TA">{{ __('Tamil') }}</option>
                      <option value="TT">{{ __('Tatar') }}</option>
                      <option value="TE">{{ __('Telugu') }}</option>
                      <option value="TH">{{ __('Thai') }}</option>
                      <option value="BO">{{ __('Tibetan') }}</option>
                      <option value="TO">{{ __('Tonga') }}</option>
                      <option value="TR">{{ __('Turkish') }}</option>
                      <option value="UK">{{ __('Ukrainian') }}</option>
                      <option value="UR">{{ __('Urdu') }}</option>
                      <option value="UZ">{{ __('Uzbek') }}</option>
                      <option value="VI">{{ __('Vietnamese') }}</option>
                      <option value="CY">{{ __('Welsh') }}</option>
                      <option value="XH">{{ __('Xhosa') }}</option>
                    </select>
                </div>
            </div>

                <div class="mx-auto d-block">
                    <div class="form-group">
                        <button class="btn bg-gradient-info mx-auto d-block" wire:loading.attr="disabled">
                            <span>
                                <div wire:loading.inline wire:target="onYoutubeTagGenerator">
                                    <x-loading />
                                </div>
                                <span wire:target="onYoutubeTagGenerator">{{ __('Generate') }}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            @if ( !empty($temp_data) )
                <fieldset class="form-fieldset bg-gradient-secondary rounded p-3">
                    <div class="form-group mb-0">
                        <label class="form-label text-white">{{ __('Click on a tag you like if you want to temporarily store it in the box below.') }}</label>
                        <div class="form-selectgroup">
                            @foreach ($temp_data as $value)
                                <label class="form-selectgroup-item" wire:click.prevent="onSetInList('{{ $value }}')">
                                    <input type="checkbox" name="name" value="{{ $value }}" class="form-selectgroup-input" />
                                    <span class="form-selectgroup-label">{{ $value }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </fieldset>
            @endif

            @if ( !empty($data) )
                <fieldset class="form-fieldset bg-gradient-secondary rounded p-3 mt-3">
                    <div class="form-group">
                      <label class="form-label text-white">{{ __('Your tag list') }}</label>
                      <textarea id="text" class="form-control" rows="6">@php

                            $count = 0;

                            $countData = count($data);

                            foreach ($data as $value) {
                                
                                $count++;

                                if ($count < $countData) 
                                {
                                    $value .= ", ";
                                }

                                echo $value;
                            }

                        @endphp</textarea>
                    </div>

                    <div class="form-group mb-0">
                        <a class="btn bg-gradient-success" value="copy" onclick="copyToClipboard()">{{ __('Copy selected tags') }}</a>
                        <a class="btn bg-gradient-warning" wire:click.prevent="onClearInList">{{ __('Clear selected tags') }}</a>
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