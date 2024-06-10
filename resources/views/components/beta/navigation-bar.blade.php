@section('header-banner')
    <div class="container-fluid header-banner">

        <a class="navbar-nav" href="https://faircore4eosc.eu/" target='_blank' rel='noopener noreferrer'><img src="{{url('/images/eosc.svg')}}" alt="eosc-logo"></a>

        <div class="row">
            @if(Auth::check())
                <div class="col-md-1">
                    <span style="font-weight: bold"> Welcome, {{Auth::user()->name}}! </span>
                </div>
            @endif
            <div class="col-md-7 -header-banner-helper">
                @if(Auth::check())
                    <ul class="nav nav-tabs" style="border: none">
                        <li role="presentation" @class(['active' => $isHomeActive ?? false])>
                            <a href="{{route('home')}}">
                                <span class="glyphicon glyphicon-home" style="margin-right: 6px;"></span>Home
                            </a>
                        </li>
                        <li role="presentation" @class(['dropdown', 'active' => $isArchiveActive ?? false])>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@isset($isArchiveActive)<span style="font-size: small">Archive-Reference/{{$view}}</span>@else Archive-Reference @endif<span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="Archive-Reference">
                                <li role="presentation"><a href={{route('tree-view')}}>Tree View</a></li>
                                <li role="separator" class="divider"></li>
                                <li role="presentation"><a href="{{route('on-the-fly-view')}}">On-the-fly View</a></li>
                                <li role="separator" class="divider"></li>
                                <li role="presentation"><a href="{{route('lw-mass-view')}}">Bundle View</a></li>
                            </ul>
                        </li>
                        <li role="presentation" @class(['active' => $isDescribeActive ?? false])><a href="{{route('lw-meta-form')}}">Describe-Cite</a></li>
                        <li role="presentation" @class(['active' => $isAPIActive ?? false])><a href="{{route('uc')}}">SWH API Client</a></li>
                        <li role="presentation" @class(['active' => $isFeedbackActive ?? false])>
                            <a href="{{route('feedback')}}">
                                <span class="glyphicon glyphicon-comment" style="font-size: 12px;margin-right: 6px;"></span>Feedback
                            </a>
                        </li>
                        <li role="presentation" @class(['active' => $isLogoutActive ?? false])>
                            <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="glyphicon glyphicon-log-out" style="margin-right: 6px;"></span>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                @endif

                @guest

                    <ul class="nav nav-tabs" style="border: none">
                        <li role="presentation" @class(['active' => $isHomeActive ?? false])>
                            <a href="{{route('home')}}">
                                <span class="glyphicon glyphicon-home" style="margin-right: 6px;"></span>Home
                            </a>
                        </li>
                        <li role="presentation" @class(['active' => $isLoginActive ?? false])>
                            <a href="{{route('login')}}">
                                <span class="glyphicon glyphicon-log-in" style="margin-right: 6px;"></span>&nbsp;Login
                            </a>
                        </li>
                        <li role="presentation" @class(['active' => $isRegisterActive ?? false])>
                            <a href="{{route('register')}}">
                                <span class="glyphicon glyphicon-edit" style="margin-right: 6px;"></span>&nbsp;Register
                            </a>
                        </li>
                    </ul>

                @endguest

            </div>

            <div class="col-md-3 -header-banner-helper" style="margin-top: 11px; border: none; text-align: right">
                @if(Auth::check() && Auth::user()->email_verified_at)
                    <span class="logo-text" style="color: #a14e1a">β-Page Last Modified: <span style="font-weight: bold">{{ $mtime }}</span></span>
                @endif

            </div>
        </div>
    </div>
@endsection
