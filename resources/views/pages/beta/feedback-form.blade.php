@extends('layouts.single-column-page')

<x-beta.navigation-bar :isFeedbackActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/beta/feedback-form.blade.php')))->format('d/M/y @H:i')"/>

@section('headline', 'LZI — WP6.2 — Beta')

@section('subtitle') <h4 style="letter-spacing: 2px">Feedback/Corrections/Bugs ?</h4> @endsection

@section('main')

    <div class="centered-content" style="margin-top: 10px">
        <div style="text-align: center;">
            <p style="margin-bottom: 20px">
                We're looking forward to hearing from you!
            </p>
        </div>

        <div class="container col-md-8 col-md-offset-2" style="margin-top: 30px; margin-bottom: 100px">
            <div class="panel panel-info bodyShadow-forms fadeIn">
                <div class="panel-heading headerCard">
                    <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('Submit Feedback') }}</div>
                </div>
                <div class="panel-body" >
                    <form class="form-horizontal" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-2" for="user">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="user" name="user" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="email">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}" readonly>
                            </div>
                        </div>
                        <div class="form-group @if($errors->feedbackForm->has('subject')) has-error @endif">
                            <label class="control-label col-md-2" for="subject">Subject</label>
                            <div class="col-md-6">
                                <select name="subject[]" id="subject" class="form-control" multiple size = 10>
                                    <option value="None" selected="selected" disabled>Please select</option>
                                    <optgroup label="Archive - Reference">
                                        <option value="Tree-View" >Tree-View</option>
                                        <option value="On-the-fly-View" >On-the-fly-View</option>
                                        <option value="Bundle-View" >Bundle-View</option>
                                    </optgroup>
                                    <optgroup label="Describe - Cite" >
                                        <option value="CodeMeta Import">CodeMeta Import</option>
                                        <option value="CodeMeta Export">CodeMeta Export</option>
                                        <option value="SWH XML Format">SWH XML Format</option>
                                        <option value="BibTex">BibTex</option>
                                        <option value="BibLaTex">BibLaTex</option>
                                        <option value="DataCite">DataCite</option>
                                    </optgroup>
                                </select>
                                <span>Multiple selections possible</span>

                                @if($errors->feedbackForm->has('subject'))
                                    <span class="help-block">{{ $errors->feedbackForm->first('subject') }} </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group @if($errors->feedbackForm->has('message')) has-error @endif">
                            <label class="control-label col-md-2" for="message">Message</label>
                            <div class="col-md-10">
                                <textarea type="text" class="form-control has-error" id="message" placeholder="Please write in here" name="message" rows="7"></textarea>
                                @if($errors->feedbackForm->has('message'))
                                    <span class="help-block">{{ $errors->feedbackForm->first('message') }} </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-9 text-center">
                                <button type="submit" id ="sub-btn" class="btn btn-primary -btn -btn-effect-deposit">Submit now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection
