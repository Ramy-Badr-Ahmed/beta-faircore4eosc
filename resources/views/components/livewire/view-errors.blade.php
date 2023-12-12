
@isset($crossMark)
    @error($wiredFormData)
        <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"
                @style(["margin-right: 24px" => str_contains($wiredFormData, 'date'),
                        "margin-right: 12px" => str_contains($wiredFormData, 'license') || str_contains($wiredFormData, 'referencePublication') || str_contains($wiredFormData, 'relatedLink'),
                        "margin-right: 50px" => str_contains($wiredFormData, 'development')])>

        </span>
    @enderror
@else
    @if(!isset($errorArray))
        @if(isset($errorURLArray))
            @error($wiredFormData)
            @php($messageSeperated = explode("--", $message))
            <div class="flex-container fadeInUp" style="border:none; margin-top: 15px;">
                <div class="flex-Error-bell">
                    <i class="glyphicon glyphicon-bell bell text-danger"></i>
                </div>
                <div class="flex-Error-msg">
                    @for ($i = 0; $i < count($messageSeperated); $i++)
                        <span class="-error-msg">{{ $messageSeperated[$i] }}</span><br>
                    @endfor
                </div>
            </div>
            @enderror

        @else
            @error($wiredFormData)
            <div class="flex-container fadeInUp" style="border:none; margin-top: 15px;">
                <div class="flex-Error-bell">
                    <i class="glyphicon glyphicon-bell bell text-danger"></i>
                </div>
                <div class="flex-Error-msg">
                    <span class="-error-msg">{{ $message }}</span>
                </div>
            </div>
            @enderror
        @endif

    @endif

@endisset

@isset($errorArray)

    @if(is_array($wiredFormData))
        @if($errors->hasAny([$wiredFormData[0], $wiredFormData[1] ]))
            <div class="row center-block" style="border: none">
                <div class="form-group col-md-6 error-array">
                    @error($wiredFormData[0])
                    <div class="flex-container fadeInUp" style="border:none;">
                        <div class="flex-Error-bell-error-array">
                            <i class="glyphicon glyphicon-bell bell text-danger"></i>
                        </div>
                        <div class="flex-Error-msg">
                            @if(isset($funder) && $funderNumber === 1)
                                @php($message = preg_replace('/\d+/', "", $message))
                            @endif
                            <span class="-error-msg">{{ $message }}</span>
                        </div>
                    </div>
                    @enderror
                </div>
                @error($wiredFormData[1])
                <div class="form-group col-md-6 error-array" style="border: none">
                    <div class="flex-container fadeInUp" style="border:none;">
                        <div class="flex-Error-bell-error-array">
                            <i class="glyphicon glyphicon-bell bell text-danger"></i>
                        </div>
                        <div class="flex-Error-msg">
                            @if(isset($funder) && $funderNumber === 1)
                                @php($message = preg_replace('/\d+/', "", $message))
                            @endif
                            <span class="-error-msg">{{ $message }}</span>
                        </div>
                    </div>
                </div>
                @enderror
            </div>
        @endif
    @else

        @error($wiredFormData)
            <div class="row center-block" style="border: none; margin-bottom: 20px">
                <div class="col-md-12 error-array">
                    <div class="flex-container fadeInUp" style="border:none;">
                        <div class="flex-Error-bell-error-array">
                            <i class="glyphicon glyphicon-bell bell text-danger"></i>
                        </div>
                        <div class="flex-Error-msg">
                            @if(isset($funder) && $funderNumber === 1)
                                @php($message = preg_replace('/\d+/', "", $message))
                            @endif
                            <span class="-error-msg">{{ $message }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @enderror
    @endif

@endisset

