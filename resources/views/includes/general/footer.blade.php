<section style="height:100px;"></section>

<div class="my-footer hidden navbar-fixed-bottom" style="border-top: 1px solid rgba(126, 183, 196, 0.46);">
    <div class="container-fluid">
        <div class="navbar-text pull-left">
            <a href="https://www.dagstuhl.de/en/publications/" target='_blank' rel='noopener noreferrer' class="pull-left">
                <img class="publishing-logo" src="{{url('/images/pubLogo-yellow.svg')}}" height="25px" alt="Dagstuhl Publishing"
                     style="margin-right: 20px; margin-top: -2px"/>
            </a>
            <span class="copyright">
                <span class="glyphicon glyphicon-copyright-mark" style="margin-right: 4px;font-size: 12px"></span>
                <span style="margin-right: 4px;">2022—{{ \App\Models\GlobalValues::where('key', 'copyright_year')->value('value') }}</span>
                    <a href="https://www.dagstuhl.de" target='_blank' rel='noopener noreferrer'>
                        Schloss Dagstuhl – LZI GmbH
                    </a>
            </span>
        </div>
        <div class="navbar-text">
            <span id="imprint" style="margin-right: 13px">
                <span class="glyphicon glyphicon-link" style="margin-right: 6px; font-size: 12px"></span>
                <a href="https://www.dagstuhl.de/en/publishing/team" target='_blank' rel='noopener noreferrer'>
                    Team
                </a>
            </span>
            <span id="github" style="margin-right: 13px">
                <img src="{{url('/images/github.svg')}}" width="16px" height="15px" style="margin-top: -2px;margin-right: 6px;" alt="github-logo" title="github">
                <a href="https://github.com/dagstuhl-publishing/beta-faircore4eosc" target='_blank' rel='noopener noreferrer'>
                    Github
                </a>
            </span>
            <span id="imprint" style="margin-right: 13px">
                <span class="glyphicon glyphicon-briefcase" style="margin-right: 6px;font-size: 12px"></span>
                <a href="{{ route('imprint') }}">
                    Imprint
                </a>
            </span>
            <span id="privacy">
                <span class="glyphicon glyphicon-sunglasses" style="margin-right: 6px;font-size: 12px"></span>
                <a href="{{ route('privacy') }}">
                    Privacy
                </a>
            </span>
        </div>

        @if(request()->routeIs('home'))
            <p class="navbar-text pull-right" style="font-weight: bold">
                <img src="{{url('/images/qualys.svg')}}" width="25px" height="25px" alt="arielssl-qualys" title="arielssl-qualys" style="margin-right: 5px;">
                <a href="https://www.ssllabs.com/ssltest/analyze.html?d=ariel.dagstuhl.de" target="_blank" rel="noopener noreferrer" style="margin-right: 5px;">
                    SSL Labs
                </a>
                <img src="{{url('/images/aplus.svg')}}" width="25px" height="25px" alt="arielssl-logo" title="arielssl">
            </p>
        @endif
    </div>
</div>

@push('scripts')

    <script type="text/javascript" nonce="{{request()->header('jsNonce')}}">

        $(function() {

            const main = {
                checkFooterVisibility: function (){
                    const footer = $('.my-footer');
                    const scrollHeight = $(document).height();
                    const scrollPosition = $(window).height() + $(window).scrollTop();
                    const tolerance = 10;

                    if (scrollPosition + tolerance >= scrollHeight) {
                        footer.removeClass('hidden');
                    } else {
                        footer.addClass('hidden');
                    }

                },
                initialize: function() {
                    $(window).on('scroll', this.checkFooterVisibility);
                    $(window).on('resize', this.checkFooterVisibility);
                    this.checkFooterVisibility();
                },
            }
            main.initialize();
        });

    </script>

@endpush
