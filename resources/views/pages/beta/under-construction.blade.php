@extends('layouts.single-column-page')

<x-beta.navigation-bar :isAPIActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/beta/under-construction.blade.php')))->format('d/M/y @H:i')"/>

@section('headline', 'LZI — WP6.2 — Beta')

@section('main')

    <div class="centered-content">
        <div style="text-align: center; font-weight: bold">
            <p style="margin-top: 20px; word-spacing: 3px">
                The LZI — SWH API page: Under Construction
            </p>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 30px; border: none">
        <div class="row">
            <div class="col-md-12 text-center" style="letter-spacing: 1px; font-weight: bold; margin-bottom: 30px">
                LZI — SWH API Principles
            </div>
        </div>
        <hr style="margin-bottom:50px; border-top-color: rgba(126, 183, 196, 0.46);"/>
        <div class="row">
            <div class="col-md-7" style="border: none">
                <figure>
                    <img src="{{url('/images/swh-merkle-dag.svg')}}" width="95%" height="85%" alt="swh-merkle-dag-model" title="swh-merkle-dag">
                    <figcaption class="text-center" style="font-weight: bold; letter-spacing: 0.04em; margin-top: 10px; color: #229ad7">
                        API Interaction with Software Heritage Merkle DAG Model
                    </figcaption>
                </figure>
            </div>
            <div class="col-md-5" style="border: none">
                <figure style="margin-bottom: 20px;">
                    <pre>
                        {{ File::get(base_path('resources/views/SWH/ebnf-swhids.txt')) }}
                    </pre>
                    <figcaption class="text-center" style="font-weight: bold; letter-spacing: 0.04em;color: #229ad7">
                        API Implementation: EBNF Grammar for SwhID (Core identifiers)
                    </figcaption>
                </figure>
                <hr style="border-top-color: rgba(126, 183, 196, 0.46);"/>
                <figure>
                    <pre>
                        {{  File::get(base_path('resources/views/SWH/ebnf-swhids-qualifiers.txt')) }}
                    </pre>
                    <figcaption class="text-center" style="font-weight: bold; letter-spacing: 0.04em;color: #229ad7">
                        API Implementation: EBNF Grammar for SwhID with Qualifiers (Contextual IDs)
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
    <hr style="margin-bottom:50px; border-top-color: rgba(126, 183, 196, 0.46);"/>
    <div class="row">
      <div class="col-md-12 text-center" style="letter-spacing: 1px; font-weight: bold; margin-bottom: 30px">
             <i class="glyphicon glyphicon-new-window" style="margin-right: 6px;font-size: 14px"></i>
             <a href="https://github.com/dagstuhl-publishing/beta-faircore4eosc/blob/main/app/Modules/SwhApi/README.md" target='_blank' rel='noopener noreferrer'>Documentation</a>
      </div>
    </div>



@endsection
