@extends('layouts.single-column-page')

<x-beta.navigation-bar :isArchiveActive="true" :view="'Bundle'"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/beta/bundle-view.blade.php')))->format('d/M/y @H:i')"/>

@section('headline', 'Software Heritage API Archival Requests')

@section('subtitle') <h4 style="letter-spacing: 1px">Bundle View</h4> @endsection

@section('main')

    <div class="centered-content">

        <div class="centered-content" style="margin-top: 10px">
            <div style="text-align: center">
                <p style="margin-bottom: 20px">
                    You can Deposit/Archive a group of repositories all at once here.
                </p>
                <p style="margin-bottom: 20px">
                    Repository URLs and Resource-specific repository URLs are supported:
                </p>
                <p style="margin-bottom: 20px">
                    <a tabindex="0" role="button" data-toggle="urlPopoverGithub" title="Supported Propagation" data-html="true" data-placement="left"
                       data-content= "{{$URLPopover['github']}}">
                        <i class="glyphicon thin glyphicon-info-sign" style="margin-right: 6px;font-size: 12px"></i>
                    </a>
                    GitHub
                    <a tabindex="0" role="button" data-toggle="urlPopoverGitlab" title="Supported Propagation" data-html="true" data-placement="right"
                       data-content= "{{$URLPopover['gitlab']}}">
                        <i class="glyphicon thin glyphicon-info-sign" style="margin-left: 6px; margin-right: 6px;font-size: 12px"></i>
                    </a>
                    GitLab
                    <a tabindex="0" role="button" data-toggle="urlPopoverBitbucket" title="Supported Propagation" data-html="true" data-placement="right"
                       data-content= "{{$URLPopover['bitbucket']}}">
                        <i class="glyphicon thin glyphicon-info-sign" style="margin-left: 6px; margin-right: 6px;font-size: 12px"></i>
                    </a>
                    Bitbucket
                </p>
                <p style="margin-bottom: 20px">
                    <a tabindex="0" role="button" data-toggle="urlPopoverGithub" title="Supported Propagation" data-html="true" data-placement="left"
                       data-content= "{{$URLPopover['examples']}}">
                        <i class="glyphicon thin glyphicon-info-sign" style="margin-right: 6px;font-size: 12px"></i>
                    </a>
                    Examples
                </p>
            </div>
        </div>

        <div>
            @livewire('mass.bundle')
        </div>

        <div style="border:none; margin-top: 1.5cm; display:flex; flex-direction: row; flex-wrap: wrap;">
            <div style="border:none; flex: 40%;height: 50px">Periodically updated every 3s:</div>
            <div style="border:none; flex: 20%;text-align: left; height: 50px">Fetch Status:
                <span id="fetch-status"></span>
            </div>
            <div style="border:none; flex: 15%; text-align: end; height: 50px">
                <button id ="clean-btn" class="btn btn-sm btn-clean hide -btn -btn-effect-erase" style="background-color: rgba(203,88,16,0.87); color: #ffffff">Clean Table</button>
            </div>
            <div style="border:none; flex: 5%; text-align: end; height: 50px">
                <button id ="stop-btn" class="btn btn-sm btn-stop hide -btn -btn-effect-erase" style="background-color: #69a103; color: #ffffff">Stop</button>
            </div>
            <div style="border:none; flex: 5%; text-align: end; height: 50px">
                <button id ="run-btn" class="btn btn-sm btn-run hide -btn -btn-effect-refresh" style="background-color: #69a103; color: #ffffff">Fetch again</button>
            </div>
        </div>

        <div id="ajax-tabulator"></div>

        <div style="border:none; margin-top: 1.5cm; display:flex; flex-direction: row; flex-wrap: wrap;">
            <div style="border:none; flex: 40%;height: 50px">
                <p style="font-weight: bold">Additionally powered by
                    <a href="https://tabulator.info/" target='_blank' rel='noopener noreferrer'>Tabulator
                        <img src="{{url('/images/tabu.svg')}}" width="30px" height="30px" alt="Tabulator-logo" title="Tabulator">
                    </a> Library
                </p>
            </div>
        </div>

    </div>

@endsection

@section('modals')

    <x-modals.modal-ok id="latex-modal" title="Generated Latex">
        <x-slot name="msg">
            <div id="textarea-modal" style="border: none; display: flex; flex-direction:column; flex-wrap:nowrap; margin: auto;" ></div>
        </x-slot>
    </x-modals.modal-ok>

    <x-modals.modal-ok id="contextual-modal" title="Generated Contextual Software Heritage IDs">
        <x-slot name="msg">
            <div id="textarea-contextual-modal" style="border: none; display: flex; flex-direction:column; flex-wrap:nowrap; margin: auto;" >
            </div>
        </x-slot>
    </x-modals.modal-ok>

@endsection

@push('head')
    @livewireStyles
@endpush


@push('scripts')

    @livewireScripts

    <script type="text/javascript" nonce="{{request()->header('jsNonce')}}">

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

@push('scripts')

    <link href="{{ asset('css/tabulator-5.4.2.min.css') }}" rel="stylesheet" >

    <script type="text/javascript" src="{{ asset('js/tabulator-5.4.2.min.js') }}"></script>

    <script type="text/javascript" nonce="{{request()->header('jsNonce')}}">

        $(function() {

            const mainLivewire = {

                massComponent: null,

                initialize: function() {
                    this.massComponent = Livewire.find(componentID);
                    LiveWires.Listeners.addListeners();
                    LiveWires.Hooks.addHooks();
                },
            };

            const LiveWires = {

                Listeners: {
                    addListeners : function (){
                        this.fetchAgain();
                    },

                    fetchAgain: function(){
                        Livewire.on('fetchAgain', function() {
                            console.log('running again LW ...');
                            $el.btnFetch.addClass('hide');
                            $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#ab8025"}).text('Working..');
                            if(ajaxTabulator.interval === null) ajaxTabulator.updateTable()
                        });
                    },
                },

                Hooks: {
                    addHooks : function (){
                        this.messages();
                    },
                    messages: function(){
                        Livewire.hook('message.sent', (message, component) => {
                            const updateQueue = component.updateQueue[0];

                            if(updateQueue.type === 'callMethod' && updateQueue.payload.method.includes('archiveAll')){
                                console.log(updateQueue.type, updateQueue.payload.method)
                                Livewire.emit('fetchAgain');
                            }
                            console.log('message.sent');
                        });
                        Livewire.hook('message.failed', (message, component) => {
                            console.error('failed');
                        });
                        Livewire.hook('message.received', (message, component) => {
                            console.log('message.received');
                        });
                        Livewire.hook('message.processed', (message, component) => {
                            const updateQueue = message.updateQueue[0];

                            if(updateQueue.type === 'syncInput' && updateQueue.payload.name === 'repos'){
                                console.log(updateQueue.type, updateQueue.name)
                                updateQueue.el.value = updateQueue.el.value.replace(/,/g, '\n');
                            }
                            console.log('message.processed');
                        });
                    }
                }
            }

            mainLivewire.initialize();


            const $el = {
                btnFetch: $('#run-btn'),
                btnStop: $('#stop-btn'),
                btnClean: $('#clean-btn'),
                btnLatex: $('#btn-la'),
                btnSwh: $('.btn.btn-swh'),
                fetchStatus: $('#fetch-status'),
                selectRepo: $('#select-repo'),
                inputUrl: $('#input-url'),

                sessionSuccessMessage: $('.alert.alert-success')
            }

            const modal = {

                swhRoot : 'https://archive.softwareheritage.org/',

                showLatexModal: function(e, latexObj, originUrl) {

                    const $modal = $('#latex-modal');
                    console.log(Object.keys(latexObj).length)

                    let $latexModal = $(`#textarea-modal`);
                    $latexModal.empty()

                    $latexModal.append(`<p id='originUrl' class='well well-sm' style='font-size:12px;font-family: Consolas, sans-serif'>Repository: ${originUrl}</p>`);

                    for(let i in latexObj){

                        const $idx = $(`#${i}`);

                        $idx.off('click');

                        if(Object.keys($idx).length===0){
                            $latexModal.append(`
                                <div id="div-${i}" style="display: none;">
                                    <textarea id="textarea-${i}" rows="${latexObj[i].split(';').length +1 }"
                                        style="font-family: Consolas, sans-serif; width:100%;  background-image: linear-gradient(to bottom, #4e7baf, #4975a8, #4570a1, #406a9b, #3c6594); color: #efffea"></textarea>
                                </div>`);

                            $(`#div-${i}`).before(`<p id='${i}' style='font-size:17px;'>${i.replace('-', ' ')} <span style='font-size:18px;'>&#8644;</span> </p>`);

                            $(`#textarea-${i}`).val(latexObj[i].replace(/,/g, ',\n').replace(/&nbsp;/g, ' '));
                        }
                        else{
                            $(`#textarea-${i}`).val(latexObj[i]);
                        }
                        events.dropTextAreas(i);
                        events.copyToClipboard(`textarea-${i}`);
                    }

                    $modal.modal('show');
                    $('.btn-la').off('click');

                },
                showContextualModal: function(e, contextualObj, originUrl) {

                    const $modal = $('#contextual-modal');
                    console.log(contextualObj);
                    console.log(Object.keys(contextualObj).length)

                    let $contextualModal = $(`#textarea-contextual-modal`);
                    $contextualModal.empty()

                    $contextualModal.append(`<p id='originUrl' class='well well-sm' style='font-size:12px;font-family: Consolas, sans-serif'>Repository: ${originUrl}</p>`);

                    for(let i in contextualObj){

                        $(`#${i}`).off('click');

                        $contextualModal.append(`
                            <div id="div-${i}" style="display: none;">
                                <textarea id="textarea-${i}" rows="${contextualObj[i].split(';').length}"
                                    style="font-family: Consolas, sans-serif; width: 100%;  background-image: linear-gradient(to bottom, #468b84, #42847e, #3e7e77, #3b7771, #37716b); color: #f6f5f5"></textarea>
                                <p id='reslover-${i}' style='font-size:17px; text-align: center'>
                                    <i class="glyphicon glyphicon-new-window" style="margin-right: 6px;font-size: 14px"></i>
                                    <a href='${this.swhRoot}${contextualObj[i]}' target='_blank' rel='noopener noreferrer'>SWH Resolver</a>
                                </p>
                            </div>`);

                        $(`#div-${i}`).before(`<p id='${i}' style='font-size:17px;'>${i.replace('-', ' ')} <span style='font-size:18px;'>&#8644;</span> </p>`);

                        $(`#textarea-${i}`).val(contextualObj[i].replace(/;/g, ';\n'));

                        events.dropTextAreas(i);
                        events.copyToClipboard(`textarea-${i}`);
                    }

                    $modal.modal('show');
                    $('.btn-swh').off('click');
                },
            }
            const events = {

                listen: function(){
                    events.buttonRun();
                    events.buttonStop();
                    events.buttonClean();
                    events.captureRepo();
                },
                buttonRun: function() {

                    $el.btnFetch.on('click', function(e){
                        console.log('running again...');
                        $el.btnFetch.addClass('hide');
                        $el.btnStop.removeClass('hide');
                        $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#ab8025"}).text('Working...');

                        ajaxTabulator.updateTable(ajaxTabulator.table.getHeaderFilters());
                    });
                },
                buttonStop: function() {

                    $el.btnStop.on('click', function(e){
                        console.log('Stopping...');
                        ajaxTabulator.interruptInterval('Stopped!');
                    });
                },
                buttonClean: function() {

                    $el.btnClean.on('click', function(e){
                        console.log('Cleaning...');
                        $el.btnClean.addClass('hide');
                        $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#ab8025"}).text('Cleaning...');

                        let callIDs={};
                        let rowsArray = ajaxTabulator.table.searchRows("isValid", "=" , 0);
                        console.log(rowsArray);
                        rowsArray.forEach((row, idx)=>{

                            callIDs[`keyID-${idx+1}`] = row.getData().requestId;

                        })
                        callIDs = {'clean' : callIDs};
                        console.log(callIDs);

                        ajaxTabulator.table.setData(ajaxTabulator.table.ajaxURL, callIDs);

                    });
                },
                buttonLatex: function(latexObj, originUrl){

                    $('.btn-la').on('click', function(e){
                            console.log('button latex again...');
                            modal.showLatexModal(e, latexObj, originUrl);
                        }
                    );
                },
                captureRepo: function(){
                    $el.inputUrl.on({
                        keyup: function(e){
                            console.log('keyup');

                            let urlValue = $(this).val();

                            let patternsObject = {
                                'git': /(git|bitbucket)/i,
                                'bzr':/(bzr)/i,
                                'hg': /(hg)/i,
                                'svn': /(svn)/i
                            };
                            let type = 'None';
                            for(let key in patternsObject){

                                if(urlValue.match(patternsObject[key])){
                                    type = key;
                                    break;
                                }
                            }
                            $el.selectRepo.val(type);
                        },
                    })
                },
                dropTextAreas: function(idx){
                    $(`#${idx}`).on('click', function(e){
                        $(`#div-${idx}`).toggle(450);
                    });
                },
                buttonSwhIDs: function(contextualSwhIdsObj, originUrl){

                    $('.btn-swh').on('click', function(e){
                            console.log('button swhid clicked ...');
                            modal.showContextualModal(e, contextualSwhIdsObj, originUrl);
                        }
                    );
                },
                copyToClipboard: function(idx){
                    $(`#${idx}`).on('click', function(e){
                            console.log('Copy to clipboard ...');
                            const $target = $(e.currentTarget);
                            main.copyToClipboard($target[0]);
                        }
                    );
                },
            }
            const ajaxTabulator = {

                table: null,
                interval: null,

                swhidCellClicked: function(e, cell) {
                    console.log('swhid cell clicked');

                    if(!cell.getRow().isTreeExpanded()){

                        if(ajaxTabulator.interval){
                            clearInterval(ajaxTabulator.interval);
                            ajaxTabulator.interval=null;
                            $el.btnFetch.removeClass('hide');
                            $el.btnStop.addClass('hide');
                            $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#901b1b"}).text('Interrupted!');

                            let tableRows = ajaxTabulator.table.getRows();
                            tableRows.forEach((row)=>{
                                if(row.getData().swhids === undefined){
                                    row.reformat();
                                }
                            })
                        }
                        cell.getRow().treeExpand();
                    }
                },
                swhCellMouseEnter: function(e, cell){
                    if(!cell.getRow().getTreeParent()){
                        let contextualSwhIdsObj = cell.getRow().getData()['contextualSwhIds'],
                            originUrl = cell.getRow().getData()['originUrl'];

                        events.buttonSwhIDs(contextualSwhIdsObj, originUrl);
                    }
                },
                swhCellMouseLeave: function(e, cell){
                    if(!cell.getRow().getTreeParent()){
                        $('.btn-swh').off('click');
                    }
                },
                cellMouseEnter: function(e, cell){
                    if(!cell.getRow().getTreeParent()){
                        let latexObj = cell.getRow().getData()['latex-snippets'],
                            originUrl = cell.getRow().getData()['originUrl'];

                        events.buttonLatex(latexObj, originUrl);
                    }
                },
                cellMouseLeave: function(e, cell){
                    if(!cell.getRow().getTreeParent()){
                        $('.btn-la').off('click');
                    }
                },

                latexCellClicked: function(e, cell) {
                },

                updateTable: function(FilterObj=null){
                    console.log(FilterObj);

                    if(!FilterObj || FilterObj.length===0){
                        ajaxTabulator.interval = setInterval(function() {
                            ajaxTabulator.table.setData();
                            $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#39a4e3"}).text('Connecting..');
                        }.bind(this), 3000);
                    }
                    else{
                        let callIDs={};
                        let rowsArray = this.table.searchRows(FilterObj);
                        rowsArray.forEach((row, idx)=>{
                            callIDs[`keyID-${idx+1}`] = row.getData().requestId;
                        })
                        console.log(callIDs);
                        ajaxTabulator.table.clearHeaderFilter();
                        ajaxTabulator.interval = setInterval(function() {
                            ajaxTabulator.table.setData(ajaxTabulator.table.ajaxURL, callIDs);
                            $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#39a4e3"}).text('Connecting..');
                        }.bind(this), 3000);
                    }
                },
                interruptInterval: function (status = null) {
                    if(ajaxTabulator.interval){
                        clearInterval(ajaxTabulator.interval);
                        ajaxTabulator.interval=null;
                        $el.btnFetch.removeClass('hide');
                        $el.btnStop.addClass('hide');
                        $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#901b1b"}).text(status ?? 'Interrupted!');
                    }
                },
                dataLoaded: function(data){
                    console.log(`Data Loaded`);
                    console.log(data);
                    console.log(`Data Loaded Done`);
                },
                dataLoadError: function(err) {
                    if(ajaxTabulator.interval){
                        clearInterval(ajaxTabulator.interval);
                        ajaxTabulator.interval = null;
                        $el.btnFetch.removeClass('-hidden');
                        $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#901b1b"}).text("Error loading data! " + (err.status ?? err.name) );
                    }
                },
                dataProcessed: function(data){

                    $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#23901b"}).text('Running...');
                    $el.btnStop.removeClass('hide');
                    let repeat = false;

                    for (let rowObject of data){
                        console.log(rowObject);

                        rowArray = ajaxTabulator.table.searchRows('requestId', '=', rowObject.requestId);
                        row = rowArray[0];

                        let children=[];
                        for(let key in rowObject.swhids){
                            if(row.getTreeChildren().length===0){
                                row.addTreeChild({'swhid': rowObject.swhids[key]});
                                nextSubRow = row.getTreeChildren();
                            }
                            else{
                                subRow = children[(children.length)-1][0];
                                if(subRow.getTreeChildren().length===0){
                                    subRow.addTreeChild({'swhid': rowObject.swhids[key]});
                                    nextSubRow = subRow.getTreeChildren();
                                }
                            }
                            children.push(nextSubRow);
                        }

                        console.log(rowObject['btn-latex']);
                        console.log(rowObject['latex-snippets']);
                        console.log(rowObject['swhids']);
                        console.log(rowObject['contextualSwhIds']);

                        if(rowObject.swhids === undefined){
                            repeat = true;
                        }
                        if(rowObject.isValid===0){
                            $el.btnClean.removeClass('hide');
                        }
                    }
                    if(!repeat){
                        clearInterval(ajaxTabulator.interval);
                        ajaxTabulator.interval=null;
                        $el.btnFetch.removeClass('hide');
                        $el.btnStop.addClass('hide');
                        $el.fetchStatus.css({"font-weight": "bold", "font-family": "Consolas", "color": "#901b1b"}).text('Stopped!');
                    }
                },
                dataFiltering: function(filters){

                    if(filters.length!==0){
                        console.log("Got Filters, data filtering")
                        console.log(`Filters: ${filters}`);

                        ajaxTabulator.interruptInterval();
                    }
                },
                dataFiltered: function(filters, rows){

                    if(filters.length!==0){
                        if(rows.length!==0){
                            let rowsIDs=[], tableRowsIds=[];
                            console.log("filtered rows")

                            console.log(rows);
                            rows.forEach((row, idx)=>{
                                rowsIDs[`${idx}`] = row.getData().requestId;

                                if(row.getData().swhids === undefined){
                                    row.reformat();
                                }
                            })
                            console.log("rowsIDs:");
                            console.log(rowsIDs);
                            if(ajaxTabulator.table.getDataCount()!==rowsIDs.length) {
                                console.log('Unfiltered Rows');

                                rowsIDs.forEach((row) => {
                                    console.log("this row ", row)
                                    let unfilteredRowsArray = ajaxTabulator.table.searchRows("requestId", "!=", row);

                                    unfilteredRowsArray.forEach((row) => {
                                        if (!rowsIDs.includes(row.getData().requestId)) {
                                            row.delete()
                                        }
                                    })
                                });
                                console.log('final table');
                                console.log(ajaxTabulator.table.getRows());
                            }
                        }
                    }
                },
                pageLoaded: function(pageNo){
                    console.log(`pageNo ${pageNo}`);
                    ajaxTabulator.interruptInterval();
                },
                infoPopup: function(e, component, onRendered){
                    const element = document.getElementsByClassName('tabulator-popup');

                    if(component.getTreeParent() || $(e.target).is('.btn')) {
                        onRendered(function(){
                            $(element).css({'display': 'none'});
                        });
                        return null;
                    }

                    const row = component.getElement();

                    onRendered(function(){
                        $(row).css({'backgroundColor' : '#cbdcbd'});

                        $(element).css({
                            'border-radius': '10px',
                            'font-family' : 'Consolas, sans-serif',
                            'box-shadow' : 'inset 0 1px 0 0 hsla(0,0%,100%,.2), 0 1px 10px 0 rgba(0,0,0,.44)'});
                    });

                    let data = component.getData(),
                        container = document.createElement("div"),
                        contents = "<div style='font-size:1.1em; font-weight:bold; text-align: center; color: #2578ab;'>Save Request Info</div>" +
                            "<ul style='padding:0; margin-top:10px; margin-bottom:10px;'>";

                    contents += "<li><strong style='border'>Save Request ID:</strong> " + data.saveRequestId + "</li>";
                    contents += "<li><strong>Loading Task ID:</strong> " + data.loadingTaskId + "</li>";

                    contents += "</ul>";

                    contents += "<div style='font-size:1.1em; font-weight:bold; text-align: center; color: #2578ab;'>Visit Info</div>" +
                        "<ul style='padding:0; margin-top:10px; margin-bottom:10px;'>";

                    contents += "<li><strong>Visit Type:</strong> " + data.visitType + "</li>";
                    contents += "<li><strong>Visit Status:</strong> " + data.visitStatus + "</li>";
                    contents += "<li><strong>Visit Date:</strong> " + data.visitDate + "</li>";

                    contents += "</ul>";

                    container.innerHTML = contents;
                    return container;
                },
                popupClosed: function(component){
                    if(component._column !== undefined) return;

                    if(!component.getTreeParent()) {
                        const row = component.getElement();
                        $(row).css({'backgroundColor' : ''});
                    }
                },

                initialize: function() {
                    ajaxTabulator.table = new Tabulator('#ajax-tabulator', {
                        ajaxURL: '{{ route('api-ajax-tabulator') }}',
                        ajaxConfig: {
                            method: 'GET',
                            headers: { 'Authorization': 'Bearer {{ Auth::user()->api_token }}' },
                        },

                        dataLoader: ()=> this.table.getRows() === 0,

                        initialSort:[{
                            column:"saveRequestDate",
                            dir:"desc"
                        }],
                        pagination: true,
                        paginationSize:5*4,
                        paginationSizeSelector:[50, 100, 150, true],
                        paginationButtonCount:3,

                        paginationCounter: (pageSize, currentRow, currentPage, totalRows, totalPages)=>{
                            return "Displaying " + currentPage +  " of " + totalPages + " pages";
                        },
                        movableColumns:true,
                        dataTree:true,
                        dataTreeStartExpanded:[true, false],
                        dataTreeElementColumn: 'swhid',
                        dataTreeChildIndent: 3,
                        dataTreeFilter:false,
                        dataTreeSort:false,
                        clipboard:true,
                        clipboardCopyConfig:{
                            columnHeaders:false,
                            columnGroups:false,
                            rowGroups:false,
                            columnCalcs:false,
                            dataTree:false,
                            formatCells:false,
                        },

                        rowFormatter:function(rowComponent){
                            console.log('rowFormatter')
                            console.log(rowComponent.getTreeParent())
                            if(!rowComponent.getTreeParent()){
                                if(rowComponent.getData().swhids === undefined){
                                }
                                if(!ajaxTabulator.interval){
                                }
                            }
                        },
                        layout: 'fitColumns',
                        autoResize:true,
                        resizableColumnFit:true,
                        layoutColumnsOnNewData:true,

                        rowClickPopup: ajaxTabulator.infoPopup,
                        placeholder:"No Data",
                        index:'requestId',

                        columns: [
                            { title: 'Id', field: 'requestId', visible: false },
                            { title: 'Url', field: 'originUrl', headerHozAlign:'center', headerFilter: 'input',
                                headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: origin_url</span>",
                                headerFilterParams: {
                                    elementAttributes:{
                                        maxlength:"150",
                                    }},
                                formatter: 'html', frozen:true, tooltip:true,
                            },
                            { title: 'Request Date', field: 'saveRequestDate', headerHozAlign:'center', hozAlign:'center', headerFilter: 'input', formatter: 'html',
                                width: 200, tooltip:true, minWidth: 200,
                                headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: save_request_date</span>"
                            },

                            { title: 'Request Status', field: 'saveRequestStatus', headerHozAlign:'center', hozAlign:'center',

                                headerFilter: 'list',
                                headerFilterPlaceholder:'Filter by',
                                headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: save_request_status</span>",
                                headerFilterParams:{
                                    values:{"accepted":"accepted", "rejected":"rejected", "pending":"pending"},
                                    clearable:true,
                                    autocomplete:true,
                                    listOnEmpty:true,
                                },
                                resizable:true, maxWidth: 160, tooltip:false
                            },
                            { title: 'Task Status', field: 'saveTaskStatus', headerHozAlign:'center', hozAlign:'center',
                                headerFilter: 'list',
                                headerFilterPlaceholder:'Filter by',
                                headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: save_task_status</span>",
                                headerFilterParams:{
                                    values:{"not created":"not created", "not yet scheduled":"not yet scheduled", "running":"running", "scheduled":"scheduled",
                                        "succeeded":"succeeded", "failed":"failed"},
                                    clearable:true,
                                    autocomplete:true,
                                    listOnEmpty:true,
                                },
                                resizable:true, maxWidth: 140, tooltip:false
                            },
                            { title: 'SWHIDs', field: 'swhid', headerHozAlign:'center', formatter: 'html', minWidth: 440, frozen:true,
                                cellClick: ajaxTabulator.swhidCellClicked,
                                cellMouseEnter: ajaxTabulator.swhCellMouseEnter, cellMouseLeave: ajaxTabulator.swhCellMouseLeave,
                                headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH Core IDs & SWH Contextual IDs</span>",
                            },
                            { title: 'LaTeX<br>Snippets', field: 'btn-latex', headerHozAlign:'center', hozAlign: 'center', width: 110, resizable:true, frozen:true,
                                formatter: 'html', cellMouseEnter: ajaxTabulator.cellMouseEnter, cellMouseLeave: ajaxTabulator.cellMouseLeave,
                                headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH Contextual IDs Referencing</span>"
                            },

                            { title: 'Flag', field: 'isValid', visible: false },
                        ]
                    });
                },
                bindEvents: function() {
                    ajaxTabulator.table.on('dataLoadError', this.dataLoadError);
                    ajaxTabulator.table.on('dataProcessed', this.dataProcessed);
                    ajaxTabulator.table.on('dataFiltering', this.dataFiltering);
                    ajaxTabulator.table.on('dataFiltered', this.dataFiltered);
                    ajaxTabulator.table.on('pageLoaded', this.pageLoaded);
                    ajaxTabulator.table.on('popupClosed', this.popupClosed);
                },
            }
            const main = {

                initialize: function() {

                    $('[data-toggle = "urlPopoverGithub"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "550px"); });
                    $('[data-toggle = "urlPopoverGitlab"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "550px"); });
                    $('[data-toggle = "urlPopoverBitbucket"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "550px"); });

                    ajaxTabulator.initialize();

                    ajaxTabulator.bindEvents();

                    ajaxTabulator.updateTable();

                    events.listen();
                },
                hideTemporalSuccessMessage: function() {
                    setTimeout(function() {
                        $el.sessionSuccessMessage.addClass('-hidden');
                    }, 3000);
                },
                copyToClipboard: function(textOrInputElement) {
                    textOrInputElement.select();

                    document.execCommand("copy");
                },
            };
            main.initialize();
        });

    </script>
@endpush
