<div>

      <form wire:submit.prevent="onArticleRewriter">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
                                    
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
        <div class="form-group mb-3">
            <label class="form-label">{{ __('Content to Rewrite') }}</label>
            <textarea class="form-control" wire:model="article" rows="10" placeholder="{{ __('Enter or Paste your content here...') }}" required></textarea>
        </div>

        <div class="form-group mb-3">
            <button class="btn bg-gradient-info mx-auto d-block" wire:loading.attr="disabled">
              <span>
                <div wire:loading.inline wire:target="onArticleRewriter">
                  <x-loading />
                </div>
                <span wire:target="onArticleRewriter">{{ __('Rewrite Article') }}</span>
              </span>
            </button>
        </div>

        @if ( !empty($data) )
          <div class="form-group position-relative mb-3">
              <textarea id="text" class="form-control" rows="10">{{ $data }}</textarea>
              <a value="copy" onclick="copyToClipboard()" class="btn bg-gradient-success btn-icon btn-icon-only cursor-pointer position-absolute top-0 end-0 m-2" title="{{ __('Copy') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Copy') }}">
                  <i class="fas fa-copy"></i>
              </a>
          </div>
        @endif
        
      </form>
</div>