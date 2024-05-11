@if(session()->has('reportError') || session()->has('feedbackError'))

    <div id="id-to-close" class="toast__containerFromLeftNoExit">
        <div class="toast__cell">
            <div class="toast-style toast--yellow">
                <div class="toast-style__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#d7995a" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div class="toast__content">
                    @if(session()->has('reportError'))
                        <p class="toast__type">Internal Error</p>
                    @else
                        <p class="toast__type">Missing Fields</p>
                    @endif
                    <p class="toast__message">{!! session('reportError') ?? session('feedbackError') !!}</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="https://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session()->has('emailError') || session()->has('verifyError'))

    <div id="id-to-close" class="toast__containerFromLeftNoExit">
        <div class="toast__cell">
            <div class="toast-style toast--yellow">
                <div class="toast-style__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#d7995a" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div class="toast__content">
                    @if(session()->has('emailError'))
                        <p class="toast__type">Sending Email Failed</p>
                    @else
                        <p class="toast__type">Verification Failed</p>
                    @endif
                    <p class="toast__message">{!! session('emailError') ?? session('verifyError') !!}</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="https://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif


@if(session()->has('feedback-received') || session()->has('verification-mail-sent') || session()->has('email-verified'))

    <div id="id-to-close" class="toast__containerFromLeftNoExit">
        <div class="toast__cell">
            <div class="toast-style toast--green">
                <div class="toast-style__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#50a259" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Success</p>
                    <p class="toast__message">
                        {!! session('feedback-received') ?? (session('verification-mail-sent') ?? session('email-verified')) !!}
                    </p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="https://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session()->has('status') || session()->has('resent') || session()->has('logged_in'))

    <div id="id-to-close" class="toast__containerFromLeftNoExit">
        <div class="toast__cell">
            <div class="toast-style toast--green">
                <div class="toast-style__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#50a259" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Success</p>
                    <p class="toast__message">
                        {!! session('status') ?? (session('resent') ?? session('logged_in')) !!}
                    </p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="https://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')

    <script type="text/javascript" nonce="{{request()->header('jsNonce')}}">

        $(function() {

            const main = {
                dismissToast: function (){
                    $('.toast__close').on('click', function(e){
                        e.preventDefault();
                        $('#id-to-close').fadeOut("slow", function() { $(this).remove(); } );
                    });
                },
                initialize: function() {
                    this.dismissToast();
                },
            }
            main.initialize();
        });

    </script>

@endpush


