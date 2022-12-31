<div>

      <form wire:submit.prevent="onYoutubeChannelStatistics">

        <div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
                                        
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>
    
            <div class="row">
                <label class="form-label">{{ __('Enter YouTube Channel URL') }}</label>
                <div class="col">
                    <div class="input-group input-group-flat">
                        <input type="text" class="form-control" wire:model="link" placeholder="https://..." required />
                        <span class="input-group-text {{ ( Cookie::get('theme_mode') == 'theme-light' ) ? 'bg-white' : '' }}">
                            <a id="paste" class="link-secondary cursor-pointer" title="{{ __('Paste') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Paste') }}">
                                <i class="far fa-clipboard fa-fw {{ ( Cookie::get('theme_mode') == 'theme-dark') ? 'text-dark' : '' }}"></i>
                            </a>
                        </span>
                    </div>
                </div>

                <div class="col-auto">
                    <div class="form-group">
                        <button class="btn bg-gradient-info mx-auto d-block" wire:loading.attr="disabled">
                            <span>
                                <div wire:loading.inline wire:target="onYoutubeChannelStatistics">
                                    <x-loading />
                                </div>
                                <span wire:target="onYoutubeChannelStatistics">{{ __('Statistic') }}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            @if ( !empty($data) )
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped border">
                        <thead class="bg-gradient-success">
                            <tr>
                                <th colspan="2" class="text-center text-white h6">{{ __('Results') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Thumbnail') }}</td>
                                <td><img src="{{ $data['thumbnail'] }}" class="ms-0" /></td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white w-25">{{ __('Channel Title') }}</td>
                                <td>{{ $data['channelTitle'] }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Channel ID') }}</td>
                                <td>{{ $data['channelId'] }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Published at') }}</td>
                                <td>{{ $data['publishedAt'] }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Total Views') }}</td>
                                <td>{{ number_format( $data['viewCount'] ) }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Total Subscribers') }}</td>
                                <td>{{ number_format( $data['subscriberCount'] ) }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Total Videos') }}</td>
                                <td>{{ number_format( $data['videoCount'] ) }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Country') }}</td>
                                <td>{{ $data['country'] }}</td>
                            </tr>

                            <tr>
                                <td class="bg-gradient-success text-white">{{ __('Description') }}</td>
                                <td>{{ $data['description'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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