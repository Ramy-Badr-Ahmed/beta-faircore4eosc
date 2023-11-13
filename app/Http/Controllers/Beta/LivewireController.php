<?php

namespace App\Http\Controllers\Beta;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application as ContractsApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LivewireController extends Controller
{
    protected array $supportedURLs = [];

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @throws FileNotFoundException
     */

    public function __construct()
    {
        $fileNames=[];
        foreach (File::files(base_path('resources/views/URLs')) as $file){
            $fileNames[] = Str::of($file->getFilename())->match('/.*(?=\.)/')->value();
            $this->supportedURLs[] = File::get($file);
        }
        $this->supportedURLs = array_combine($fileNames, $this->supportedURLs);
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param Request $request
     * @return View|Application|Factory|ContractsApplication
     */

    public function metaPanels(Request $request): View|Application|Factory|ContractsApplication
    {
        return view('pages.beta.metaPanels');
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param Request $request
     * @return View|Application|Factory|ContractsApplication
     */

    public function bundle(Request $request): View|Application|Factory|ContractsApplication
    {
        return view('pages.beta.bundle-view')->with('URLPopover', $this->supportedURLs);
    }
}
