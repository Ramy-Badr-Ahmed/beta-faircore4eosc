@if(session()->has('success-animation-codeMeta'))

    <div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromLeft">
        <div class="toast__cell">
            <div class="toast-style toast--green">
                <div class="toast-style__icon" style="margin-top: -5px;">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 50px;">
                        <circle class="path circle stay" fill="none" stroke="#A8B400" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle>
                        <polyline class="path check stay" fill="none" stroke="#A8B400" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 ">
                        </polyline>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Success</p>
                    <p class="toast__message">{!! session('success-animation-codeMeta') !!}</p>
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

@if(session()->has('tripMode') && !session()->has('validationErrors'))

    <div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromRight" style="right: 160px;top: -40px;">
        <div class="toast__cell">
            <div class="toast-style toast--blue">
                <div class="toast-style__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#4b79bf" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">TripMode Set!</p>
                    <p class="toast__message">{!! session('tripMode') !!}</p>
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

@if(session()->has('stepPass') )

    <div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromLeft">
        <div class="toast__cell">
            <div class="toast-style toast--green">
                <div class="toast-style__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#50a259" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Step Message</p>
                    <p class="toast__message">{!! session('stepPass') !!}</p>
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

@if(session()->has('erased-success') )

<div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromLeft">
    <div class="toast__cell">
        <div class="toast-style toast--green">
            <div class="toast-style__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#50a259" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
            </div>
            <div class="toast__content">
                <p class="toast__type">Step Message</p>
                <p class="toast__message">{!! session('erased-success') !!}</p>
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

@if(session()->has('stepErrors'))

    <div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromLeft">
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
                    <p class="toast__type">Step Message</p>
                    <p class="toast__message">{!! session('stepErrors') !!}</p>
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

@if (session()->has('stepEmpty'))

    <div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromRight" style="right: 200px;top: 70px;">
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
                    <p class="toast__type">Step Message</p>
                    <p class="toast__message">{!! session('stepEmpty') !!}</p>
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

@if (session()->has('Unsupported'))  {{--toastWarning--}}

<div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromRight" style="right: 200px;top: 70px;">
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
                <p class="toast__type">Unsupported</p>
                <p class="toast__message">{!! session('Unsupported') !!}</p>
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

@if(session()->has('schemeErrors'))

<div wire:key="session.{{$time}}" id="id-to-close" class="toast__containerFromLeft">
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
                <p class="toast__type">Scheme Errors</p>
                <p class="toast__message">{!! session('schemeErrors') !!}</p>
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

@if (session()->has('default-toast-success-codeMeta'))

    <div id="id-to-close" class="toast__container">
        <div class="toast__cell">
            <div class="toast-style toast--green">
                <div class="toast__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#4b79bf" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Info</p>
                    <p class="toast__message">{!! session('success-codeMeta') !!}</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session()->has('default toast-info-codeMeta'))

    <div id="id-to-close" class="toast__container">
        <div class="toast__cell">
            <div class="toast toast--blue">
                <div class="toast__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#4b79bf" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Info</p>
                    <p class="toast__message">{!! session('info-codeMeta') !!}</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session()->has('default toast-warning-codeMeta'))
    <div id="id-to-close" class="toast__container">
        <div class="toast__cell">
            <div class="toast toast--yellow">
                <div class="toast__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#d7995a" stroke-width="2" stroke-linecap="square" stroke-linejoin="round">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Warning</p>
                    <p class="toast__message">{!! session('warning-codeMeta') !!}</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" width="14" height="14" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session()->has('success-codeMeta-bootstrap'))

    <div class="container-fluid alert alert-dismissible fade in" data-dismiss="alert" style="color: #157788">
        <div class="row">
            <div class="col-md-2" >
                <div class="alert alert-success alert-dismissible fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="alert-heading">Success!</h5>
                    <p class="mb-0">{!! session('success-codeMeta') !!}</p>
                </div>
            </div>
            <div class="alert col-md-1">
                <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 50px;display: block; margin: 10px auto 0;">
                    <circle class="path circle" fill="none" stroke="#A8B400" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle>
                    <polyline class="path check" fill="none" stroke="#A8B400" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "></polyline>
                </svg>
            </div>
        </div>
    </div>

@endif

@if (session()->has('tripMode-bootstrap'))

    <div class="alert alert-dismissible fade in centered-content" data-dismiss="alert" style="border:none; color: #157788;">
        <div style="display:flex; justify-content: flex-end; border: none; position:relative;" >
            <div style="border:none; flex: 0 170px;" >
                <div class="alert alert-success alert-dismissible fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="alert-heading">TripMode Set!</h5>
                    <p class="mb-0">{!! session('tripMode') !!}</p>
                </div>
            </div>
            <div style="flex: 0 350px; border: none" >
                <svg version="1.1" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 50px;display: block; margin: 10px auto auto 12px;">
                    <circle class="path circle mode" fill="none" stroke="#A8B400" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle>
                    <polyline class="path check mode" fill="none" stroke="#A8B400" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "></polyline>
                </svg>
            </div>
        </div>
    </div>

@endif


