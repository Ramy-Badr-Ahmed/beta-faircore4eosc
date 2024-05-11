<?php

namespace App\Http\Controllers\Beta;

use App\Http\Controllers\Controller;

use App\Models\SoftwareHeritageRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ApiController extends Controller
{

#__________________________________________________________________________________________________________________________________________________________________________________________________

    public function __construct()
    {
        $this->middleware('auth');
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param Request $request
     * @return Response
     */

    public function apiAjaxTabulator(Request $request): Response
    {
        $requestParameters = $request->input();
        $rows = [];

        if($request->input('clean')){

            SoftwareHeritageRequest::whereIn('id', $request->input('clean'))->delete();

            $requestParameters=[];
        }

        $archivalRequests = empty($requestParameters)
            ? SoftwareHeritageRequest::where('createdBy_id', '=', Auth::user()->id)->get()
            : SoftwareHeritageRequest::whereIn('id', $request->input())->get();

        if($archivalRequests->isEmpty()){
            return response($rows, ResponseAlias::HTTP_ACCEPTED);
        }

        foreach ($archivalRequests as $archivalRequest){

            $newRow = [
                'requestId' => $archivalRequest->id,
                'saveRequestId' => $archivalRequest->saveRequestId,
                'originUrl' => $archivalRequest->originUrl,
                'visitType' => $archivalRequest->visitType,
                'saveRequestDate' => $archivalRequest->saveRequestDate,
                'saveRequestStatus' => $archivalRequest->saveRequestStatus,
                'saveTaskStatus' => $archivalRequest->saveTaskStatus,
                'visitStatus' => $archivalRequest->visitStatus,
                'visitDate' => $archivalRequest->visitDate,
                'loadingTaskId' => $archivalRequest->loadingTaskId
            ];

            if($archivalRequest->isValid === 0){

                if($archivalRequest->saveTaskStatus === "failed"){
                    $newRow['swhid'] = '<span style="font-weight: bold; color: #bd5656; margin-left: 34%;">Archival Failed</span>';
                    $newRow['btn-latex'] = '<span style="font-weight: bold; color: #bd5656">Archival Failed</span>';
                }
                else{
                    if($archivalRequest->hasConnectionError === 1){
                        $newRow['swhid'] = '<span style="font-weight: bold; color: #bd5656; margin-left: 15%;">SWH Connection Error</span>';
                        $newRow['btn-latex'] = '<span style="font-weight: bold; color: #bd5656">SWh Connection Error</span>';
                    }else{
                        $newRow['swhid'] = '<span style="font-weight: bold; color: #bd5656; margin-left: 34%;">URL Error</span>';
                        $newRow['btn-latex'] = '<span style="font-weight: bold; color: #bd5656">URL Error</span>';
                    }
                }
                $newRow['isValid'] = $archivalRequest->isValid;
            }
            elseif(!isset($archivalRequest->latexSnippets)){  // if null
                $newRow ['swhid'] =  '<span style="font-weight: bold; color: #47754e; margin-left: 34%;">Awaiting Archival</span>';
                $newRow ['btn-latex'] = '<span style="font-weight: bold; color: #47754e">Awaiting Archival</span>';
            }
            else {
                $newRow['swhid'] = "<span style='color:#3c5944 ; font-weight: normal;background-color: #f5e0c6; /*margin-left: 20%*/; margin-bottom: 1.5%;margin-top: 0.85%;'
                                          class='btn btn-xs btn-swh -btn -btn-effect-deposit'>Contextual Information</span>";

                $newRow['swhids'] = $archivalRequest->swhIdList;
                $newRow['contextualSwhIds'] = $archivalRequest->contextualSwhIds;

                $newRow['btn-latex'] = "<span style='color:#3c5944 ; font-weight: normal;background-color: #f5e0c6; margin-top: 3%;' class='btn btn-xs btn-la -btn -btn-effect-deposit'>Latex</span>";
                $newRow['latex-snippets'] = $archivalRequest->latexSnippets;
            }

            $rows[]=$newRow;
        }
        return response($rows, ResponseAlias::HTTP_OK);
    }
}
