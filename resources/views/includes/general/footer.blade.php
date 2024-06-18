<section style="height:100px;"></section>

<div class="my-footer hidden navbar-fixed-bottom" style="border-top: 1px solid rgba(126, 183, 196, 0.46);">
    <div class="container-fluid">
        <div class="navbar-text pull-left">
            <a href="https://faircore4eosc.eu/" target='_blank' rel='noopener noreferrer' class="pull-left">
                <img class="fc4e" src="{{url('/images/fairLogo.svg')}}" height="25px" alt="fc4e"
                     style="margin-right: 20px; margin-top: -2px"/>
            </a>
            <span class="copyright">
                <span class="glyphicon glyphicon-copyright-mark" style="margin-right: 4px;font-size: 12px"></span>
                <span style="margin-right: 4px;">2022—{{ \App\Models\GlobalValues::where('key', 'copyright_year')->value('value') }}</span>
                    <a href="https://faircore4eosc.eu/eosc-core-components/eosc-research-software-apis-and-connectors-rsac" target='_blank' rel='noopener noreferrer'>
                        FairCore4EOSC Project
                    </a>
            </span>
        </div>
        <div class="navbar-text">
            <span id="github" style="margin-right: 13px">
                <img src="{{url('/images/github.svg')}}" width="16px" height="15px" style="margin-top: -2px;margin-right: 6px;" alt="github-logo" title="github">
                <a href="https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc/tree/dev-cont" target='_blank' rel='noopener noreferrer'>
                    GitHub
                </a>
            </span>
        </div>

        @if(request()->routeIs('home'))
            <p class="navbar-text pull-right" style="font-weight: bold">
                <img src="{{url('/images/qualys.svg')}}" width="25px" height="25px" alt="bwssl-qualys" title="bwssl-qualys" style="margin-right: 5px;">
                <a href="https://www.ssllabs.com/ssltest/analyze.html?d=1959e979-c58a-4d3c-86bb-09ec2dfcec8a.ka.bw-cloud-instance.org" target="_blank" rel="noopener noreferrer" style="margin-right: 5px;">
                    SSL Labs
                </a>
                <img src="{{url('/images/aplus.svg')}}" width="25px" height="25px" alt="bwssl-logo" title="bwssl">
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
