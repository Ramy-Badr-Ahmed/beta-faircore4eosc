@extends('layouts.single-column-page')

<x-beta.navigation-bar :isDescribeActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/includes/wizard')))->format('d/M/y @H:i')"/>

@section('headline', 'Software Metadata Dashboard')

@section('main')

    <div>
        <livewire:meta-data.meta-panels  />
    </div>

@endsection

@push('head')
    @livewireStyles
@endpush


@push('scripts')

    @livewireScripts

    <script type="text/javascript" nonce="{{request()->header('jsNonce')}}">

        $(function() {

            const main = {

                metaFormComponent: null,
                referenceDivs: {},
                lastSavedHeights: {},

                events: {
                    addEvents : function (){
                        this.onDehydrate();
                        this.triggerCSS();
                        this.showDropDown();
                        this.copy2ClipBoard();
                        this.selectLine();
                        this.playCheck();
                    },

                    addListeners: function () {
                        this.dismissToast();
                        this.dismissPopover();
                    },

                    onDehydrate: function () {
                        window.addEventListener('onDehydrate', (event) => {
                            this.keepLastHeights();
                            this.reTriggerPopOver();
                        });
                    },

                    reTriggerPopOver: function () {

                        let $popover = $('[data-toggle="popover"]'),
                            $modePopover = $('[data-toggle="modePopover"]'),
                            $rightPopover = $('[data-toggle = "rightPopover"]');

                        $popover.popover('destroy');
                        $modePopover.popover('destroy');

                        $popover.popover({trigger: "click", container : "body", html: true})
                            .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "430px"); })
                            .on("inserted.bs.popover", function (){

                                let descriptionWidth = $('.description-width'), verticalStackWidth = $('.vertical-stack');

                                if(parseFloat(verticalStackWidth.css('width')) > parseFloat(descriptionWidth.css('max-width'))){
                                    descriptionWidth.css('max-width', "100%");
                                }
                            })
                            .on("shown.bs.popover", function (){
                                let $popover = $(this), position = $popover.data("bs.popover").arrow().position();

                                $('#collapsible-btn1, #collapsible-btn2').on('click', function (){
                                    let target, targetID;
                                    targetID = $(this).next().attr('id');
                                    target = $(`#${targetID}`)

                                    $popover.data("bs.popover").arrow().css({"top": position.top.toFixed(2) + "px", "left": position.left.toFixed(2) + "px"});

                                    if (this.id === 'collapsible-btn1' && target.hasClass('collapse in')) {
                                        target.collapse('hide');
                                        return;
                                    }
                                    target.collapse('toggle');
                                })
                            });

                        $modePopover.popover({trigger: "hover", container : "body", html: true})
                            .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "276px"); });

                        $rightPopover.popover({trigger: "click", container : "body", html: true})
                            .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "276px"); });
                    },

                    keepLastHeights: function (){

                        let $leftPanel = $(`#left_panel`), $textArea = $(`#right_panel_box textarea`), events = this;

                        if(main.referenceDivs['right_panel'] !== $leftPanel.css('height')){
                            $textArea.each(function (){
                                if(typeof main.lastSavedHeights[$(this).attr('name')] !=='undefined'){
                                    events.equateHeights($(this).attr('name'))
                                }
                            });
                            return;
                        }

                        $textArea.each(function (){
                            $(this).css({'max-height': (typeof main.lastSavedHeights[$(this).attr('name')] !=='undefined')
                                    ?  main.lastSavedHeights[$(this).attr('name')].height
                                    :  $(this).css('height') + 'px'})
                        })
                    },

                    equateHeights: function (textArea){

                        const $rightBox = $(`#right_panel_box`), $textBox = $(`#id_${textArea}`),
                            $leftBox = $(`#left_panel_box`), $leftPanel = $(`#left_panel`);

                        if($rightBox.length === 0 || $textBox.length === 0){
                            return;
                        }

                        const topToTextArea = $textBox.offset().top - $rightBox.offset().top;
                        const bottomToTextarea = $rightBox.height() - topToTextArea - $textBox.height();

                        const marginError = parseFloat($leftPanel.css('height')) - parseFloat($leftBox.css('height'));

                        let textAreaHeightThreshold = parseFloat($leftPanel.css('height')) - marginError - (topToTextArea + bottomToTextarea) // 167.5;
                        $textBox.css({'max-height': textAreaHeightThreshold   + 'px'});

                        const boxError = parseFloat($leftBox.css('height')) - parseFloat($rightBox.css('height'));
                        $textBox.css({'max-height': textAreaHeightThreshold + boxError  + 'px'});

                        main.lastSavedHeights = Object.assign(main.lastSavedHeights, {
                            [textArea] : {
                                "height":  textAreaHeightThreshold + boxError
                            }
                        })
                    },

                    triggerCSS: function (){
                        window.addEventListener('triggerCSS', (e) =>{
                            if(!e.detail.ScrollOnly){
                                $('#left_panel').toggleClass('fadeIn');
                                $('#right_panel').toggleClass('fadeInUp');
                            }
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            this.dismissToast();
                        });
                    },

                    showDropDown: function (){
                        window.addEventListener('showDropdown', (event) =>{
                            $('#div_id_select_license').addClass((event.detail.view ?? 'show') + ' fadeIn');
                        });
                    },

                    copy2ClipBoard: function (){
                        window.addEventListener('copy2ClipBoard', (e) =>{
                            const textArea = document.getElementById(e.detail.textArea);
                            textArea.select();

                            document.execCommand("copy");

                            setTimeout(function()
                            {
                                textArea.setSelectionRange(0, 0);
                            }, 300);
                            $('#copy-btn').text('Copied!').attr('disabled', true).toggleClass('btn-danger');

                            setTimeout(function()
                            {
                                $('#copy-btn').html('<span class="glyphicon glyphicon-camera" aria-hidden="true" style="padding-right: 5px"></span>Copy')
                                    .attr('disabled', false).toggleClass('btn-danger');
                            }, 600);
                        });
                    },

                    selectLine: function (){
                        window.addEventListener('selectLine', (e) =>{
                            const textArea = document.getElementById("id_codeMetaImport");
                            textArea.select();
                            textArea.setSelectionRange(e.detail.Line, e.detail.Length, "forward");
                        });
                    },

                    playCheck: function (){
                        window.addEventListener('playCheck', (e) =>{
                            $('#playCheck').removeClass('hidden');
                            setTimeout(function()
                            {
                                $('#playCheck').addClass('hidden');
                                $('#id_codeMetaImport').addClass('fadeOut');
                                setTimeout(function()
                                {
                                    $('#id_codeMetaImport').addClass('hidden');
                                    Livewire.emit('fromJS', true);
                                }, 700);
                            }, 1400);
                        });
                    },

                    dismissToast: function (){
                        $('.toast__close').on('click', function(e){
                            e.preventDefault();
                            $('#id-to-close').fadeOut("slow", function() { $(this).remove(); } );
                        });
                    },

                    dismissPopover: function () {
                        $('body').on('click'  , function(e) {
                            let $popover, $target = $(e.target);

                            if ($target.hasClass('popover') || $target.closest('.popover').length) {
                                return;
                            }

                            $('[data-toggle="popover"]').each(function () {
                                $popover = $(this);

                                if (!$popover.is(e.target) && $popover.has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
                                {
                                    $popover.popover('hide');
                                } else {
                                    $popover.popover('toggle');
                                }
                            });
                        });
                    },
                },

                initialize: function() {

                    this.metaFormComponent = Livewire.find(componentID);

                    this.register();

                    this.events.addEvents();
                    this.events.addListeners();

                    LiveWires.Listeners.addListeners();
                    LiveWires.Hooks.addHooks();
                },

                register: function () {
                    $('[data-toggle="popover"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "430px"); })
                        .on("inserted.bs.popover", function (){
                            let descriptionWidth = $('.description-width'), verticalStackWidth = $('.vertical-stack');

                            if(parseFloat(verticalStackWidth.css('width')) > parseFloat(descriptionWidth.css('max-width'))){
                                descriptionWidth.css('max-width', "100%");
                            }
                        })
                        .on("shown.bs.popover", function (){
                            let $popover = $(this), position = $popover.data("bs.popover").arrow().position();

                            $('#collapsible-btn1, #collapsible-btn2').on('click', function (){
                                let target, targetID;
                                targetID = $(this).next().attr('id');
                                target = $(`#${targetID}`)

                                $popover.data("bs.popover").arrow().css({"top": position.top.toFixed(2) + "px", "left": position.left.toFixed(2) + "px"});

                                if (this.id === 'collapsible-btn1' && target.hasClass('collapse in')) { // first show
                                    target.collapse('hide');
                                    return;
                                }
                                target.collapse('toggle');
                            })
                        });

                    $('[data-toggle = "modePopover"]').popover({trigger: "hover", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "276px"); });

                    $('[data-toggle = "rightPopover"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "276px"); });

                    $('#left_panel').toggleClass('fadeIn');
                    $('#right_panel').toggleClass('fadeInUp');

                    this.removeToast();
                },

                removeToast: function (){
                    let $toast = $('[class^="toast__container"]');

                    if($toast.length > 0){

                        $toast.on('animationend', function(event) {
                            if(event.originalEvent.animationName.startsWith('exit')){
                                $(this).remove();
                            }
                        });
                    }
                }
            };

            const LiveWires = {

                Listeners: {
                    addListeners : function (){
                        this.playCheck();
                        this.equateHeights();
                        this.bounceTextArea();
                        this.scrollTo();
                        this.removePerson();
                        this.tripModeFromBlade();
                        this.closePopovers();
                    },

                    playCheck: function(){
                        Livewire.on('playCheck', function() {

                            $('#playCheck').removeClass('hidden');

                            const $checkMark = $('#playCheck polyline');

                            $checkMark.on('animationend', function(event) {
                                $('#playCheck').remove()
                                $('#id_codeMetaImport')
                                    .addClass('fadeOut')
                                    .on('animationend', function (event){

                                        $('#id_codeMetaImport').addClass('hidden');
                                        Livewire.emit('fromJS', true);
                                    })
                            });
                        });
                    },

                    equateHeights: function (){

                        Livewire.on('equateHeights', function(textArea) {

                            const $rightBox = $(`#right_panel_box`), $textBox = $(`#id_${textArea}`);

                            if($rightBox.length === 0 || $textBox.length === 0){
                                return;
                            }

                            const topToTextArea = $textBox.offset().top - $rightBox.offset().top;
                            const bottomToTextarea = $rightBox.height() - topToTextArea - $textBox.height();

                            const marginError = parseFloat(main.referenceDivs['right_panel']) - parseFloat(main.referenceDivs['left_panel_box']);

                            let textAreaHeightThreshold = parseFloat(main.referenceDivs['right_panel']) - marginError - (topToTextArea + bottomToTextarea) // 167.5;

                            $textBox.css({'max-height': textAreaHeightThreshold   + 'px'});

                            const boxError = parseFloat(main.referenceDivs['left_panel_box']) - parseFloat($rightBox.css('height'));

                            $textBox.css({'max-height': textAreaHeightThreshold + boxError  + 'px'});

                            main.lastSavedHeights = Object.assign(main.lastSavedHeights, {
                                [textArea] : {
                                    "height":  textAreaHeightThreshold + boxError
                                }
                            })
                        });
                    },

                    bounceTextArea: function(){

                        Livewire.on('bounceTextArea', function (textArea){
                            const $textBox = $(`#id_${textArea}`);
                            $textBox.addClass('bounce-rotate');
                        })
                    },

                    scrollTo: function (){
                        Livewire.on('scrollTo', function(property, propertyNumber){

                            const $person = $(`#div_h5_${property}_${propertyNumber - 1}`);
                            if($person.length === 0){
                                return;
                            }

                            $person.addClass('highlighted');

                            window.scrollTo({ top: $person.offset().top - 15, behavior: 'smooth' });

                            setTimeout(function() {
                                $person.fadeOut('fast', function() {

                                    $(this).removeClass('highlighted');

                                    $(this).fadeIn('fast');
                                });
                            }, 3000);
                        })
                    },
                    tripModeFromBlade: function (){
                        Livewire.on('tripModeFromBlade', function ($mode){
                            main.metaFormComponent.set('viewFlags.tripMode', $mode);
                        })
                    },
                    removePerson: function (){
                        Livewire.on('removePerson', function(property, propertyNumber, totalNumber = 0){

                            const $person = $(`[id^='row_'][id$='_${property}_${propertyNumber - 1}']`);

                            $person.addClass('fadeOut')
                                .on('animationend', function (event){
                                    main.metaFormComponent.set(property+"Number", totalNumber - 1);
                                })
                        })
                    },
                    closePopovers: function(){
                        Livewire.on('clearPops', function(){
                            //todo
                        });
                    }
                },

                Hooks: {
                    addHooks : function (){
                        this.messages();
                    },

                    messages: function(){
                        Livewire.hook('message.sent', (message, component) => {

                            main.referenceDivs['viewPanel'] = main.metaFormComponent.viewPanel;
                            main.referenceDivs['right_panel'] = $(`#right_panel`).css('height')
                            main.referenceDivs['left_panel_box'] = $(`#left_panel_box`).css('height')
                            console.log('message.sent');

                        });
                        Livewire.hook('message.failed', (message, component) => {
                            console.error('failed');
                        });
                        Livewire.hook('message.received', (message, component) => {
                            console.log('message.received');
                        });
                        Livewire.hook('message.processed', (message, component) => {

                            main.removeToast();
                            console.log('message.processed');
                        });
                    }
                }
            }
            main.initialize();
        });

        let componentID;

        const LiveWiresGlobal = {
            addListeners : function (){
                this.componentHook();
                this.onLoad();
                this.onError();
                this.onPageExpired();
            },

            componentHook: function (){
                Livewire.hook('component.initialized', component => {
                    console.log('component.initialized');
                    const LivewireComponentID = component.el.getAttribute('wire:id');
                    console.log('Component ID:', LivewireComponentID);
                })
            },

            onLoad: function (){
                Livewire.onLoad(() => {
                    console.log('Livewire loaded');
                    const LivewireComponentID = $('[wire\\:id]').attr('wire:id');
                    console.log('Component ID:', LivewireComponentID);
                    componentID = LivewireComponentID;
                })
            },
            onError: function (){
                Livewire.onError((statusCode, message) => {
                    console.error('Livewire error: ', message, "status code: ", statusCode);
                    console.log('Restarting ..');
                    Livewire.rescan();
                });
            },
            onPageExpired: function (){
                Livewire.onPageExpired((response, message) => {
                    console.log('pageExpired: ', response, message);
                    confirm('This page has expired.\nWould you like to refresh the page?') && window.location.reload()   // showExpiredMessage
                })
            }
        }

        LiveWiresGlobal.addListeners();

    </script>

@endpush

