<div>

    <x-session.beta.messages />

    <div>
        <form>
            @csrf
            <div class="form-group row">
                <div class="col-md-1">
                    <label for="repos" >Repositories</label>
                </div>
                <div class="col-md-10">
                    <textarea wire:loading.attr="disabled" type="text" class="form-control" id="repos" placeholder="Type URLs here. https://.." name="textarea"
                              wire:model.lazy="repos" rows="7"></textarea>
                    <span id="helpRepos" style="color: #6c757d">Supported Repositories: GitHub, GitLab, and Bitbucket. <b>Note</b>: Please separate each URL entry in a newline (more readable) or with a comma.<br></span>

                    @error('repos')
                        @php
                            $messageSeperated = explode("--", $message)
                        @endphp
                        @for ($i = 0; $i < count($messageSeperated); $i++)
                            <span class="fadeIn"  style="background-color: #f9f2f4; font-family: Consolas, sans-serif; color: #cb365c">
                                {{ $messageSeperated[$i] }}
                            </span><br>
                        @endfor
                    @enderror
                </div>
            </div>

            <div class="form-group container">
                <div class="row text-center">
                    <div class="col-md-1">
                        <span id ="sub-btn" class="btn btn-danger -btn -btn-effect-erase" style="margin-right: 10px"
                                wire:loading.attr="disabled"
                                wire:target="archiveAllMassy, archiveAllSequentially, resetRepos"
                                wire:click.prevent="resetRepos()">Reset
                        </span>
                    </div>
                    <div class="col-md-9">
                        <span class="hidden transit-message" style="font-size: 14px; color: #3c763d"
                              wire:target="archiveAllMassy, archiveAllSequentially"
                              wire:loading.class.remove="hidden">
                            <span> Mass Archival in progress ..</span>
                        </span>
                        <button id ="sub-btn" class="btn btn-primary -btn -btn-effect-deposit"
                                wire:loading.class="hidden"
                                wire:target="archiveAllMassy, archiveAllSequentially"
                                wire:click.prevent="archiveAllSequentially()">Archive All
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
