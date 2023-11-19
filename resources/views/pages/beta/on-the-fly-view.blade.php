@extends('layouts.single-column-page')

<x-beta.navigation-bar :isArchiveActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/beta/on-the-fly-view.blade.php')))->format('d/M/y @H:i')"/>

@section('headline', 'SWH API Requests Status in DB')


@section('subtitle') <h4 style="letter-spacing: 1px">On-the-fly View</h4> @endsection

@section('main')

    <div class="centered-content">

        <x-session.beta.messages />

        <div class="centered-content" style="margin-top: 10px">
            <div style="text-align: center">
                <p style="margin-bottom: 20px">
                    You can Deposit/Archive anew here. Copy archiving and propagation results quickly.
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

        <form method="post">
            @csrf

            <div class="form-group">

                <div class="row">
                    <label for="input-url" class="col-sm-2">
                        Enter URL
                    </label>
                    <div class="col-sm-10">
                        <input id="input-url" type="text" class="form-control" autocomplete="off"
                               name="origin_url"
                               value="{{ old('origin_url') }}"
                               placeholder="https://..." />
                        <span style="color: #6c757d">Supported Repositories: GitHub, GitLab, and Bitbucket</span>

                        @if($errors->updateForm->has('origin_url'))
                            <span class="help-block">{{ $errors->updateForm->first('origin_url') }} </span>
                        @endif
                    </div>
                </div>

                <div class="row" style="margin-top: 10px">

                    <label for="select-repo" class="col-sm-2">
                        Choose Repository
                    </label>

                    <div class="col-sm-2">

                        <select name="format" id="select-repo" class="form-control">
                            <option value="None" selected="selected" disabled>Please select</option>
                            <optgroup label="Github | Gitlab | Bitbucket">
                                <option value="git" >git</option>
                            </optgroup>
                            <optgroup label="Bazaar" disabled>
                                <option value="bzr">bzr</option>
                            </optgroup>
                            <optgroup label="Mercurial" disabled>
                                <option value="hg">hg</option>
                            </optgroup>
                            <optgroup label="Apache Subversion" disabled>
                                <option value="svn">svn</option>
                            </optgroup>
                        </select>

                        @if($errors->updateForm->has('format'))
                            <span class="help-block">{{ $errors->updateForm->first('format') }} </span>
                        @endif

                    </div>

                </div>

                <div class="text-center">
                    <button type="submit" id ="sub-btn" class="btn btn-primary -btn -btn-effect-deposit">Deposit now</button>
                </div>

            </div>
        </form>

        <label for="copy-to-clipboard"></label>
        <input type="text" id="copy-to-clipboard" style="position: absolute; top: -200vh;" value="" />

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
                <button id ="fetch-btn" class="btn btn-sm btn-run -hidden -btn -btn-effect-refresh" style="background-color: #69a103; color: #ffffff">Update Table</button>
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

@push('scripts')

    <link href="{{ asset('css/tabulator-5.4.2.min.css') }}" rel="stylesheet" >

    <script type="text/javascript" src="{{ asset('js/tabulator-5.4.2.min.js') }}"></script>

    <script type="text/javascript" nonce="{{request()->header('jsNonce')}}">

        $(document).ready(function() {

            const view = {

                $el: {
                    btnFetch: $('#fetch-btn'),
                    btnStop: $('#stop-btn'),
                    btnClean: $('#clean-btn'),
                    fetchStatus: $('#fetch-status'),
                    selectRepo: $('#select-repo'),
                    inputUrl: $('#input-url'),

                    inputClipboard: $('#copy-to-clipboard'),
                    copyToClipboard: $('.copy-to-clipboard'),

                    sessionSuccessMessage: $('.alert.alert-success')
                },

                bindEvents: function() {
                    view.$el.btnFetch.on('click', view.eventHandlers.fetchTable);
                    view.$el.btnStop.on('click', view.eventHandlers.stopFetch);
                    view.$el.btnClean.on('click', view.eventHandlers.cleanTable);
                    view.$el.inputUrl.on('keyup', view.eventHandlers.autoDetectRepoType);
                    view.$el.copyToClipboard.on('click', view.eventHandlers.copyInputToClipboard);
                },

                eventHandlers: {

                    fetchTable: function() {
                        view.$el.btnFetch.addClass('-hidden');
                        view.$el.btnStop.removeClass('hide');
                        view.$el.fetchStatus.text('Working...');
                        view.ajaxTabulator.updateTable(view.ajaxTabulator.table.getHeaderFilters());
                    },
                    stopFetch: function() {

                        view.$el.btnStop.on('click', function(e){
                            view.ajaxTabulator.interruptInterval('Stopped!');
                        });
                    },
                    cleanTable: function() {
                        view.$el.btnClean.addClass('-hidden');
                        view.$el.fetchStatus.text('Cleaning...');

                        let callIDs={};
                        let rowsArray = view.ajaxTabulator.table.searchRows("isValid", "=" , 0);
                        rowsArray.forEach((row, idx)=>{
                            callIDs[`keyID-${idx+1}`] = row.getData().requestId;
                        })
                        callIDs = {'clean' : callIDs};

                        view.ajaxTabulator.table.setData(view.ajaxTabulator.table.ajaxURL, callIDs);
                    },

                    autoDetectRepoType: function() {
                        const urlValue = $(this).val();
                        const patternsObject = {
                            'git': /(git|bitbucket|github|gitlab)/i,
                            'bzr':/(bzr)/i,
                            'hg': /(hg)/i,
                            'svn': /(svn)/i
                        };
                        let type = 'None';
                        for (let key in patternsObject) {
                            if (urlValue.match(patternsObject[key])) {
                                type = key;
                                break;
                            }
                        }
                        view.$el.selectRepo.val(type);
                    },

                    copyInputToClipboard: function (e) {
                        const $target = $(e.currentTarget);
                        console.log($target)
                        view.copyToClipboard($target[0]);
                    }
                },

                copyToClipboard: function(textOrInputElement) {
                    let inputElement = textOrInputElement;

                    if (typeof textOrInputElement === 'string') {
                        view.$el.inputClipboard.val(textOrInputElement);
                        inputElement = view.$el.inputClipboard[0];
                    }
                    inputElement.select();
                    document.execCommand("copy");
                },

                hideTemporalSuccessMessage: function() {
                    setTimeout(function() {
                        view.$el.sessionSuccessMessage.addClass('-hidden');
                    }, 3000);
                },

                ajaxTabulator: {

                    table: null,
                    interval: null,

                    swhIdCellClicked: function(e, cell) {
                        if (!$(e.target).is('.btn-swh')) {
                            return;
                        }

                        const contextData = cell.getRow().getData()['contextualSwhIds'];

                        view.copyToClipboard(contextData['Directory-Context'] ?? contextData['Content-Context']);

                        cell.setValue('Copied!');

                        setTimeout(function() {
                            cell.setValue(cell.getOldValue());
                        }, 1000);
                    },
                    latexCellClicked: function(e, cell) {
                        if (!$(e.target).is('.btn-la')) {
                            return;
                        }

                        const latex = cell.getRow().getData()['latex-snippets'];

                        view.copyToClipboard(latex['Supplement-Latex'].replace(/&nbsp;/g, ' '));

                        cell.setValue('Copied!');

                        setTimeout(function() {
                            cell.setValue(cell.getOldValue());
                        }, 1000);
                    },
                    updateTable: function(filterObj) {

                        if (!filterObj || filterObj.length === 0) {

                            view.ajaxTabulator.interval = setInterval(function() {

                                view.ajaxTabulator.table.setData();
                                view.$el.fetchStatus.text('Connecting...');

                            }.bind(this), 3000);
                        }
                        else {
                            let callIDs = {};
                            const rowsArray = view.ajaxTabulator.table.searchRows(filterObj);
                            rowsArray.forEach((row, idx) => {
                                callIDs['keyID-' + (idx + 1)] = row.getData().requestId;
                            })
                            view.ajaxTabulator.table.clearHeaderFilter();
                            view.ajaxTabulator.interval = setInterval(function() {
                                view.ajaxTabulator.table.setData(view.ajaxTabulator.table.ajaxURL, callIDs);
                                view.$el.fetchStatus.text('Connecting...');
                            }.bind(this), 3000);
                        }
                    },
                    interruptInterval: function (status = null) {
                        if(view.ajaxTabulator.interval){
                            clearInterval(view.ajaxTabulator.interval);
                            view.ajaxTabulator.interval=null;
                            view.$el.btnFetch.removeClass('-hidden');
                            view.$el.btnStop.addClass('hide');
                            view.$el.fetchStatus.text(status ?? 'Interrupted!');
                        }
                    },
                    dataLoadError: function(err) {
                        if (view.ajaxTabulator.interval) {
                            clearInterval(view.ajaxTabulator.interval);
                            view.ajaxTabulator.interval = null;
                            view.$el.btnFetch.removeClass('-hidden');
                            view.$el.fetchStatus.text('Error loading data! ' + (err.status ?? err.name) );
                        }
                    },
                    dataProcessed: function(data) {
                        view.$el.fetchStatus.text('Running...');
                        view.$el.btnStop.removeClass('hide');

                        let repeat = false;

                        for (let rowObject of data) {
                            if (rowObject.contextualSwhIds === undefined){
                                repeat = true;
                            }
                            if (rowObject.isValid === 0) {
                                view.$el.btnClean.removeClass('hide');
                            }
                        }
                        if (!repeat) {
                            clearInterval(view.ajaxTabulator.interval);
                            view.ajaxTabulator.interval = null;
                            view.$el.btnFetch.removeClass('-hidden');
                            view.$el.btnStop.addClass('hide');
                            view.$el.fetchStatus.text('Stopped!');
                        }
                    },
                    dataFiltering: function(filters){
                        if (filters.length !== 0) {
                            view.ajaxTabulator.interruptInterval();
                        }
                    },
                    dataFiltered: function(filters, rows){

                        if (filters.length !== 0 && rows.length !== 0) {
                            let rowsIDs = [];

                            rows.forEach((row, idx) => {
                                rowsIDs[idx] = row.getData().requestId;

                                if(row.getData().swhids === undefined) {
                                    row.reformat();
                                }
                            });

                            if (view.ajaxTabulator.table.getDataCount() !== rowsIDs.length) {

                                console.log('Unfiltered Rows');
                                rowsIDs.forEach((row) => {
                                    console.log("this row ", row)
                                    const unfilteredRowsArray = view.ajaxTabulator.table.searchRows("requestId", "!=", row);
                                    unfilteredRowsArray.forEach((row) => {
                                        if (!rowsIDs.includes(row.getData().requestId)) {
                                            row.delete();
                                        }
                                    });
                                });
                            }
                        }
                    },
                    pageLoaded: function(pageNo){
                        view.ajaxTabulator.interruptInterval();
                    },
                    infoPopup: function(e, component, onRendered){
                        const element = document.getElementsByClassName('tabulator-popup');

                        if($(e.target).is('.btn')) {
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

                        contents += "<li><strong>Save Request ID:</strong> " + data.saveRequestId + "</li>";
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
                        const row = component.getElement();
                        $(row).css({'backgroundColor' : ''});
                    },
                    bindEvents: function() {
                        view.ajaxTabulator.table.on('dataLoadError', view.ajaxTabulator.dataLoadError);
                        view.ajaxTabulator.table.on('dataProcessed', view.ajaxTabulator.dataProcessed);
                        view.ajaxTabulator.table.on('dataFiltering', view.ajaxTabulator.dataFiltering);
                        view.ajaxTabulator.table.on('dataFiltered', view.ajaxTabulator.dataFiltered);
                        view.ajaxTabulator.table.on('pageLoaded', view.ajaxTabulator.pageLoaded);
                        view.ajaxTabulator.table.on('popupClosed', view.ajaxTabulator.popupClosed);
                    },

                    initialize: function() {

                        view.ajaxTabulator.table = new Tabulator('#ajax-tabulator', {
                            ajaxURL: '{{ route('api-ajax-tabulator') }}',
                            ajaxConfig: {
                                method: 'GET',
                                headers: { 'Authorization': 'Bearer {{ Auth::user()->api_token }}' },
                            },
                            dataLoader: () => view.ajaxTabulator.table.getRows() === 0,
                            initialSort: [{
                                column: 'saveRequestDate',
                                dir: 'desc'
                            }],
                            pagination: true,
                            paginationSize: 5*10,
                            paginationSizeSelector: [ 100, 150, 200, true ],
                            paginationButtonCount: 3,
                            paginationCounter: (pageSize, currentRow, currentPage, totalRows, totalPages) =>
                                'Displaying ' + currentPage +  ' of ' + totalPages + ' pages',
                            movableColumns: true,
                            clipboard: true,
                            clipboardCopyConfig: {
                                columnHeaders: false,
                                columnGroups: false,
                                rowGroups: false,
                                columnCalcs: false,
                                dataTree: false,
                                formatCells: false
                            },

                            layout: 'fitColumns',
                            autoResize:true,
                            resizableColumnFit:true,
                            layoutColumnsOnNewData: true,
                            rowClickPopup: view.ajaxTabulator.infoPopup,
                            placeholder: 'No Data',
                            index: 'requestId',
                            columns: [
                                { title: 'Id', field: 'requestId', visible: false },
                                { title: 'Url', field: 'originUrl', headerHozAlign:'center', headerFilter: 'input',
                                    headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: origin_url</span>",
                                    headerFilterParams: {
                                        elementAttributes:{
                                            maxlength: '150',
                                        }
                                    },
                                    formatter: 'html', frozen: true, tooltip: true,
                                },
                                { title: 'Request Date', field: 'saveRequestDate', headerHozAlign:'center', hozAlign:'center',
                                    headerFilter: 'input', formatter: 'html', width: 200, tooltip:true, minWidth: 200,
                                    headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: save_request_date</span>"
                                },
                                { title: 'Request Status', field: 'saveRequestStatus', headerHozAlign:'center', hozAlign:'center',
                                    headerFilter: 'list',
                                    headerFilterPlaceholder: 'Filter by',
                                    headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: save_request_status</span>",
                                    headerFilterParams: {
                                        values: { 'accepted': 'accepted', 'rejected': 'rejected', 'pending': 'pending' },
                                        clearable: true,
                                        autocomplete: true,
                                        listOnEmpty: true,
                                    },
                                    resizable: true, maxWidth: 160, tooltip: false
                                },
                                { title: 'Task Status', field: 'saveTaskStatus', headerHozAlign:'center', hozAlign:'center',
                                    headerFilter: 'list',
                                    headerFilterPlaceholder: 'Filter by',
                                    headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH-key: save_task_status</span>",
                                    headerFilterParams: {
                                        values: {
                                            'not created': 'not created',
                                            'not yet scheduled': 'not yet scheduled',
                                            'running': 'running',
                                            'scheduled': 'scheduled',
                                            'succeeded': 'succeeded',
                                            'failed': 'failed'
                                        },
                                        clearable: true,
                                        autocomplete: true,
                                        listOnEmpty: true,
                                    },
                                    resizable: true, maxWidth: 140, tooltip: false
                                },
                                { title: 'SWHIDs', field: 'swhid', headerHozAlign:'center', formatter: 'html', width: 150, frozen: true,
                                    cellClick: view.ajaxTabulator.swhIdCellClicked,
                                    headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH Core IDs & SWH Contextual IDs</span>",
                                },
                                { title: 'LaTeX', field: 'btn-latex', headerHozAlign:'center', hozAlign: 'center', width: 120,
                                    resizable: true, frozen: true, formatter: 'html', cellClick: view.ajaxTabulator.latexCellClicked,
                                    headerPopup:"<span style='font-size:1.0em; color: #2578ab; font-weight: bold; font-family: Consolas, sans-serif;'>SWH Contextual IDs Referencing</span>"
                                },
                                { title: 'Flag', field: 'isValid', visible: false },
                            ],
                        });

                    }
                },

                initialize: function() {
                    $('[data-toggle = "urlPopoverGithub"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "550px"); });
                    $('[data-toggle = "urlPopoverGitlab"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "550px"); });
                    $('[data-toggle = "urlPopoverBitbucket"]').popover({trigger: "click", container : "body", html: true})
                        .on("show.bs.popover", function(){$(this).data("bs.popover").tip().css("max-width", "550px"); });

                    view.ajaxTabulator.initialize();
                    view.ajaxTabulator.bindEvents();
                    view.ajaxTabulator.updateTable();

                    view.bindEvents();
                    view.hideTemporalSuccessMessage();
                }
            };

            view.initialize();
        });

    </script>
@endpush
