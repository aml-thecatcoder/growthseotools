<div>

      <form wire:submit.prevent="onUrlRewritingTool">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
                                    
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="row">
            <label class="form-label">{{ __('Enter URL') }}</label>
            <div class="form-group">
                <div class="input-group input-group-flat">
                    <input type="text" class="form-control" wire:model="link" placeholder="https://..." required />
                    <span class="input-group-text {{ ( Cookie::get('theme_mode') == 'theme-light' ) ? 'bg-white' : '' }}">
                        <a id="paste" class="link-secondary cursor-pointer" title="{{ __('Paste') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Paste') }}">
                            <i class="far fa-clipboard fa-fw {{ ( Cookie::get('theme_mode') == 'theme-dark') ? 'text-dark' : '' }}"></i>
                        </a>
                    </span>
                </div>
            </div>

            <div class="form-group text-center mb-0">
                    <button class="btn bg-gradient-info" wire:loading.attr="disabled">
                      <span>
                        <div wire:loading.inline wire:target="onUrlRewritingTool">
                          <i class="spinner-border spinner-border-sm me-1"></i>
                        </div>
                          <span wire:target="onUrlRewritingTool">{{ __('Rewrite') }}</span>
                      </span>
                  </button>

                  <button class="btn bg-gradient-success" wire:click.prevent="onSample" wire:loading.attr="disabled">
                      <span>
                        <div wire:loading.inline wire:target="onSample">
                          <i class="spinner-border spinner-border-sm me-1"></i>
                        </div>
                          <span wire:target="onSample">{{ __('Sample') }}</span>
                      </span>
                  </button>

                  <button class="btn bg-gradient-warning" wire:click.prevent="onReset" wire:loading.attr="disabled">
                      <span>
                        <div wire:loading.inline wire:target="onReset">
                          <i class="spinner-border spinner-border-sm me-1"></i>
                        </div>
                          <span wire:target="onReset">{{ __('Reset') }}</span>
                      </span>
                  </button>
            </div>
        </div>

        @if ( !empty($data) )

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="bg-gradient-secondary text-center text-white" colspan="2">{{ __('Type 1 - Single Page URL') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>{{ __('Generated URL') }}</th>
                      <td>{{ $data['arr1']['fexpl'] }}</td>
                    </tr>
                    <tr>
                      <th>{{ __('Example URL') }}</th>
                      <td>{{ $data['arr1']['expl'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <h6 class="bg-info text-white p-3 text-bold">{{ __('Create a .htaccess file with the code below The .htaccess file needs to be placed in') }} {{ $data['host'] }}</h6>
              <textarea rows="6" class="form-control">{{ $data['type1'] }}</textarea>

              <div class="table-responsive mt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="bg-gradient-secondary text-center text-white" colspan="2">{{ __('Type 2 - Single Page URL') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>{{ __('Generated URL') }}</th>
                      <td>{{ $data['arr2']['fexpl'] }}</td>
                    </tr>
                    <tr>
                      <th>{{ __('Example URL') }}</th>
                      <td>{{ $data['arr2']['expl'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <h6 class="bg-info text-white p-3 text-bold">{{ __('Create a .htaccess file with the code below The .htaccess file needs to be placed in') }} {{ $data['host'] }}</h6>
              <textarea rows="6" class="form-control">{{ $data['type2'] }}</textarea>

              <div class="table-responsive mt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="bg-gradient-secondary text-center text-white" colspan="2">{{ __('Type 3 - Single Page URL') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>{{ __('Generated URL') }}</th>
                      <td>{{ $data['arr3']['fexpl'] }}</td>
                    </tr>
                    <tr>
                      <th>{{ __('Example URL') }}</th>
                      <td>{{ $data['arr3']['expl'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <h6 class="bg-info text-white p-3 text-bold">{{ __('Create a .htaccess file with the code below The .htaccess file needs to be placed in') }} {{ $data['host'] }}</h6>
              <textarea rows="6" class="form-control">{{ $data['type3'] }}</textarea>

              <div class="table-responsive mt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="bg-gradient-secondary text-center text-white" colspan="2">{{ __('Type 4 - Single Page URL') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>{{ __('Generated URL') }}</th>
                      <td>{{ $data['arr4']['fexpl'] }}</td>
                    </tr>
                    <tr>
                      <th>{{ __('Example URL') }}</th>
                      <td>{{ $data['arr4']['expl'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <h6 class="bg-info text-white p-3 text-bold">{{ __('Create a .htaccess file with the code below The .htaccess file needs to be placed in') }} {{ $data['host'] }}</h6>
              <textarea rows="6" class="form-control">{{ $data['type4'] }}</textarea>
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