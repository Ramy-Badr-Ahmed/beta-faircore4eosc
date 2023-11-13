<div class="panel-heading headerCard">
    <div id="panel-title" class="panel-title">
        <ul class="nav nav-pills ">
            <li role="presentation" @class(['-box-shadow' => $jsonActive, 'active' => $jsonActive]) >
                <a role="button" wire:click="activatePill('jsonActive')" style="letter-spacing: 1px;"
                   wire:target="activatePill" wire:loading.class="blur">CodeMeta
                </a>
            </li>

            <li role="presentation" @class(['-box-shadow'=> $swhXMLActive, 'active' => $swhXMLActive])>
                <a role="button" wire:click="activatePill('swhXMLActive')" style="letter-spacing: 1px;"
                   wire:target="activatePill" wire:loading.class="blur">SWH-Deposit
                </a>
            </li>

            <li role="presentation"  @class(['-box-shadow'=> $bibLaTexActive || $bibTexActive, 'dropdown',
                                                 'active' => $bibLaTexActive || $bibTexActive])>

                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"
                   wire:target="activatePill" wire:loading.class="blur">
                        <span class="latex" style="letter-spacing: 1px;">
                            @if($bibTexActive)<span style="font-size: small">L<sup>A</sup>T<sub>E</sub>X</span>/Bib<span class="tex">T<sub>e</sub>X</span>
                            @elseif($bibLaTexActive)<span style="font-size: small">L<sup>A</sup>T<sub>E</sub>X</span>/Bib<span class="latex">L<sup>a</sup>T<sub>e</sub>X</span>
                            @else L<sup>A</sup>T<sub>E</sub>X
                            @endif
                            </span>
                    <span class="caret"></span>
                </a>

                <ul @class(['dropdown-menu', 'animate', 'slideIn', 'dropdown-menu-right'=> $bibLaTexActive])>
                    <li role="presentation" @class(['-box-shadow'=> $bibTexActive, 'active' => $bibTexActive])>
                        <a role="button" wire:click="activatePill('bibTexActive')" style="letter-spacing: 1px;">BibTeX</a></li>
                    <li role="separator" class="divider"></li>
                    <li role="presentation" @class(['-box-shadow'=> $bibLaTexActive, 'active' => $bibLaTexActive])>
                        <a role="button" wire:click="activatePill('bibLaTexActive')" style="letter-spacing: 1px;">BibLaTeX</a></li>
                </ul>
            </li>

            <li role="presentation"  @class(['dropdown','-box-shadow'=> $dataCiteActive || $githubActive || $zenodoActive,
                                                 'active' => $dataCiteActive || $githubActive || $zenodoActive])>

                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"
                   wire:target="activatePill" wire:loading.class="blur" >
                        <span style="letter-spacing: 1px;">
                            @if($dataCiteActive) <span style="font-size: small">CrossWalk</span>/DateCite
                            @elseif($githubActive) <span style="font-size: small">CrossWalk</span>/Github
                            @elseif($zenodoActive) <span style="font-size: small">CrossWalk</span>/Zenodo
                            @else CrossWalk @endif
                        </span>
                    <span class="caret"></span>
                </a>

                <ul @class(['dropdown-menu', 'animate', 'slideIn', 'dropdown-menu-right'=> $dataCiteActive || $githubActive || $zenodoActive])>
                    <li role="presentation" @class(['-box-shadow'=> $dataCiteActive, 'active' => $dataCiteActive])>
                        <a role="button" wire:click="activatePill('dataCiteActive')" style="letter-spacing: 1px;">DataCite</a></li>

                    <li role="separator" class="divider"></li>

                    <li role="presentation" @class(['-box-shadow'=> $githubActive, 'active' => $githubActive])>
                        <a role="button" wire:click="activatePill('githubActive')" style="letter-spacing: 1px;">GitHub</a></li>

                    <li role="separator" class="divider"></li>

                    <li role="presentation" @class(['-box-shadow'=> $zenodoActive, 'active' => $zenodoActive])>
                        <a role="button" wire:click="activatePill('zenodoActive')" style="letter-spacing: 1px;">Zenodo</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
