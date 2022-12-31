<div>

      <form wire:submit.prevent="onYoutubeRegionRestrictionChecker">

        <div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
                                        
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>
    
            <div class="row">
            <label class="form-label">{{ __('Enter YouTube Video URL') }}</label>
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
                            <div wire:loading.inline wire:target="onYoutubeRegionRestrictionChecker">
                                <x-loading />
                            </div>
                            <span wire:target="onYoutubeRegionRestrictionChecker">{{ __('Check') }}</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header d-block text-start bg-success text-white">
                <h6 class="text-white mb-0">{{ __('World Map') }}</h6>
            </div>
            <div class="card-body border border-success">
                @if ( !empty($this->data) )
                    <p>
                        {{ __('Video: ') }}
                        <a class="text-bold" href="https://www.youtube.com/watch?v={{ $data['video_id'] }}" target="_blank">{{ $data['title'] }}</a>
                    </p>
                @endif
                <div wire:ignore id="world-map" style="width:100%;height:480px"></div>
            </div>
        </div>
        

        @if ( !empty($this->data) )
            <table class="table table-bordered">
                <thead class="bg-gradient-success text-white">
                    <tr>
                        <th>{{ __('Allowed countries') }}</th>
                        <th>{{ __('Blocked countries') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if ( !empty($allowed) )  
                                @foreach ($allowed as $value)
                                    <p>{{ $value }}</p>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ( !empty($blocked) )  
                                @foreach ($blocked as $value)
                                    <p>{{ $value }}</p>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
      </form>
</div>

<script src="{{ asset('assets/js/jquery-jvectormap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap.css') }}">
<script src="{{ asset('assets/js/jquery-jvectormap-world-mill.js') }}"></script>

<script>
  jQuery(function(){
        jQuery('#world-map').vectorMap({
            map: 'world_mill',
            backgroundColor: 'white',
            container: jQuery('#world-map'),
            regionStyle: {
                initial: { fill: "#4a9fc5" },
                stroke: 'red'
            },
            zoomButtons: true,
            series: {
                regions: [{
                    attribute: 'fill'
                }]
            }
        });
  });
</script>

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

            window.addEventListener('data', event => {

                var world_map = jQuery('#world-map').vectorMap('get', 'mapObject');

                var allowedArr = [];

                var blockedArr = [];

                var colors = {};

                for(var code in world_map.regions){
                    
                    if ( event.detail.allowed.length > 0) {

                        if ( event.detail.allowed.indexOf(code) > -1 ) {

                            colors[code] = "#4a9fc5";

                            allowedArr.push(world_map.regions[code].config.name);

                        } else {

                            colors[code] = "#ff0000";

                            blockedArr.push(world_map.regions[code].config.name);

                        }

                    }
                    else {

                        if ( event.detail.blocked.length > 0 && event.detail.blocked.indexOf(code) > -1 ) {

                            colors[code] = "#ff0000";

                            blockedArr.push(world_map.regions[code].config.name);

                        } else {

                            colors[code] = "#4a9fc5";

                            allowedArr.push(world_map.regions[code].config.name);

                        }
                    }

                }

                world_map.series.regions[0].setValues(colors);

                window.livewire.emit('onSetCountries', allowedArr, blockedArr)

            });
        });

  })( jQuery );
</script>