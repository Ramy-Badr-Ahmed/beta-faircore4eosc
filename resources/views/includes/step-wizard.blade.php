<div class="stepwizard-row hidden">
    <div class="stepwizard-step" >
        <a type="button" @class( [ "btn", "btn-circle", "btn-success" => $viewFlags["panel1Success"] ?? false,
                                   "btn-primary" => !isset($viewFlags["panel1Success"]) && !isset($viewFlags["panel1Failed"]) ,
                                   "btn-danger" => $viewFlags["panel1Failed"] ?? false,
                                   ])
                         @style([ "color: snow" => $viewFlags["panel1Success"] ?? false ])
           wire:click="$set('viewPanel', 1)">1</a>
        <p>Step 1</p>
    </div>
    <div class="stepwizard-step">
        <a type="button" @class( [ "btn", "btn-circle", "btn-success" => $viewFlags["panel2Success"] ?? false,
                           "btn-primary" => !isset($viewFlags["panel2Success"]) && !isset($viewFlags["panel2Failed"]) ,
                           "btn-danger" => $viewFlags["panel2Failed"] ?? false,
                           "disabled" => $viewPanel<2 && !isset($viewFlags["panel2Success"])
                           ])
                         @style([ "color: snow" => $viewFlags["panel2Success"] ?? false ])
        wire:click="$set('viewPanel', 2)">2</a>
        <p>Step 2</p>
    </div>
    <div class="stepwizard-step">
        <a type="button" @class( [ "btn", "btn-circle", "btn-success" => $viewFlags["panel3Success"] ?? false,
                           "btn-primary" => !isset($viewFlags["panel3Success"]) && !isset($viewFlags["panel3Failed"]) ,
                           "btn-danger" => $viewFlags["panel3Failed"] ?? false,
                           "disabled" => $viewPanel<3 && !isset($viewFlags["panel3Success"])
                           ])
                         @style([ "color: snow" => $viewFlags["panel3Success"] ?? false ])
        wire:click="$set('viewPanel', 3)">3</a>
        <p>Step 3</p>
    </div>

</div>

<div class="wizard" style="margin-top: 20px">
    <div class="stepwizard-step" >
        <a type="button" @class( [ "btn", "btn-circle", "btn-success" => $viewFlags["panel1Success"] ?? false,
                                   "btn-primary" => !isset($viewFlags["panel1Success"]) && !isset($viewFlags["panel1Failed"]) ,
                                   "btn-danger" => $viewFlags["panel1Failed"] ?? false,
                                   ])
        @style([ "color: snow" => $viewFlags["panel1Success"] ?? false ])
        wire:click="$set('viewPanel', 1)">1</a>
        <p>Step 1</p>
    </div>
    <div class="stepwizard-step">
        <a type="button" @class( [ "btn", "btn-circle", "btn-success" => $viewFlags["panel2Success"] ?? false,
                           "btn-primary" => !isset($viewFlags["panel2Success"]) && !isset($viewFlags["panel2Failed"]) ,
                           "btn-danger" => $viewFlags["panel2Failed"] ?? false,
                           "disabled" => $viewPanel < 2 && !isset($viewFlags["panel2Allowed"])
                           ])
        @style([ "color: snow" => $viewFlags["panel2Success"] ?? false ])
        wire:click="$set('viewPanel', 2)">2</a>
        <p>Step 2</p>
    </div>
    <div class="stepwizard-step">
        <a type="button" @class( [ "btn", "btn-circle", "btn-success" => $viewFlags["panel3Success"] ?? false,
                           "btn-primary" => !isset($viewFlags["panel3Success"]) && !isset($viewFlags["panel3Failed"]) ,
                           "btn-danger" => $viewFlags["panel3Failed"] ?? false,
                           "disabled" => $viewPanel < 3 && !isset($viewFlags["panel3Allowed"])
                           ])
        @style([ "color: snow" => $viewFlags["panel3Success"] ?? false ])
        wire:click="$set('viewPanel', 3)">3</a>
        <p>Step 3</p>
    </div>
</div>
