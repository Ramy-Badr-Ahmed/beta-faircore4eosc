<?php


use App\Http\Controllers\Beta\SoftwareHeritageController;
use Laravel\Octane\Facades\Octane;
use Illuminate\Http\Response;



Octane::route('GET', '/octane', function() {

    $octaneResponse = new Response((new SoftwareHeritageController)->underConstruction());  // new Response(view('pages.beta.under-construction'));
    $octaneResponse->header('Octane-Landed', Str::uuid());

    return $octaneResponse;
});

/*Octane::route('GET', '/api/ajaxdb/tabulator', function (Request $request){
    return (new ApiController())->apiAjaxTabulator($request);
});*/




