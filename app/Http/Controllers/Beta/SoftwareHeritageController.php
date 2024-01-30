<?php

namespace App\Http\Controllers\Beta;

use App\Http\Controllers\Controller;
use App\Models\SoftwareHeritageRequest;
use App\Modules\SwhApi\Archive;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\Foundation\Application as ContractsApplication;
use Illuminate\Support\Str;
use PDOException;
use Throwable;
use UnhandledMatchError;
use Illuminate\Support\Facades\Log;
use App\Mail\EOSCMailer;
use Illuminate\Support\Facades\Mail;

class SoftwareHeritageController extends Controller
{
    protected array $supportedURLs = [];

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    public function __construct()
    {
        $fileNames=[];
        foreach (File::files(base_path('resources/views/URLs')) as $file){
            $fileNames[] = Str::of($file->getFilename())->match('/.*(?=\.)/')->value();
            $this->supportedURLs[] = File::get($file);
        }
        $this->supportedURLs = array_combine($fileNames, $this->supportedURLs);
    }
#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    public function archivalRequests(Request $request, $validator = NULL): View|Application|Factory|Redirector|SoftwareHeritageController|ContractsApplication|RedirectResponse
    {
        [$thisView, $thisRoute]  = str_contains($request->getPathInfo(), 'archival-view-1')
            ? [ view('pages.beta.tree-view')->with('URLPopover', $this->supportedURLs),
                route('tree-view')
            ]
            : [ view('pages.beta.on-the-fly-view')->with('URLPopover', $this->supportedURLs),
                route('on-the-fly-view')
            ];

        if ($request->isMethod('get')) {
            return $thisView;
        }
        else {
            try{
                if($validator === Null) {
                    return self::validateForArchivalRequests($request);
                }

                $url = $request->input('origin_url');
                $url = preg_replace('/\/$/', '', $url);
                $visitType = $request->input('format');

                $archivalRequest = SoftwareHeritageRequest::where(['originURL' => $url])
                    ->where('createdBy_id', '=', Auth::user()->id)
                    ->first();

                if (isset($archivalRequest)) {            //entry exists in db

                    if (!isset($archivalRequest->swhIdList)) {
                        return redirect($thisRoute)
                            ->with('warning-message', 'Info! - Your new entry exists with an unfinished archival Status. Please wait while we synchronise with SWH.');
                    } else {
                        DB::beginTransaction();
                        $archivalRequest->delete();
                    }
                }

                $depositArchival = new Archive($url, $visitType);

                $saveResponse = $depositArchival->save2Swh();

                if($saveResponse instanceof Throwable){
                    return redirect($thisRoute)
                        ->with('error-message', "Archive Internal Error {$saveResponse->getMessage()}");
                }

                $saveResponse["origin_url"] = $url;

                $newUrl = new SoftwareHeritageRequest();

                $newUrl->populateFromPostForm($saveResponse);

                DB::commit();

                return redirect($thisRoute)
                    ->with('success-message', 'Info: Archival in progress...');

            }catch(UnhandledMatchError|PDOException|Throwable $e){

                DB::rollBack();

                Log::error($e->getMessage(). " in line: ". $e->getLine());

                return match(true){
                    $e instanceof UnhandledMatchError => redirect($thisRoute)->with('error-message', "Non-supported repository URL. If this was a git or bitbucket instance, please report a bug!"),
                    $e instanceof PDOException => redirect($thisRoute)->with('error-message', "DB operation failed. DB Error code: {$e->getCode()}"),
                    default => redirect($thisRoute)->with('error-message', "Internal Error. Please try again and kindly report it if the problem persists.")
                };
            }
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    public function validateForArchivalRequests($requestObj): self|RedirectResponse
    {
        $validator = Validator::make($requestObj->all(),
            [
                'origin_url' => 'url|max:255|required',
                'format' => 'required',
            ],
            [
                'origin_url'=>"The :attribute field with input: ':input' is wrong.",
                'format'=>'The :attribute field is missing. Please select it!'
            ]
        );
        if ($validator->fails()) {

            return back()
                ->withErrors($validator, 'updateForm')
                ->withInput()
                ->with('error-message', 'Please correct your input!');
        }
        else {
            return self::archivalRequests($requestObj, $validator);
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    public function underConstruction(): View|Application|Factory|ContractsApplication
    {
        return view('pages.beta.under-construction');
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#
    public function feedbackForm(Request $request,  $validator = NULL): Factory|Application|View|RedirectResponse|ContractsApplication
    {
        if($request->isMethod('get')){
            return view('pages.beta.feedback-form');

        }else{

            if($validator === Null) {
                return self::validateForFeedbackForm($request);
            }

            $mailData = [
                'user' => $request->input('user'),
                'email' => $request->input('email'),
                'subject' => 'Feedback Form --> '.implode(', ',$request->input('subject')),
                'message' => $request->input('message'),
            ];

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new EOSCMailer($mailData));

            return redirect()
                ->route('feedback')
                ->with('feedback-received', 'Feedback submitted. Thank you!');
        }
    }

#__________________________________________________________________________________________________________________________________________________________________________________________________
#

    public function validateForFeedbackForm($requestObj): self|RedirectResponse
    {
        $validator = Validator::make($requestObj->all(),
            [
                'subject' => 'required',
                'message' => 'required',
            ],
            [
                'subject' => 'The :attribute field is missing. Please select.',
                'message'=> 'The :attribute field is missing. Please fill it in.'
            ]
        );
        if ($validator->fails()) {

            return back()
                ->withErrors($validator, 'feedbackForm')
                ->with('feedbackError', 'Please fill in all required fields');
        }
        else {
            return self::feedbackForm($requestObj, $validator);
        }
    }

}
