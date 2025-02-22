<?php

namespace App\Http\Controllers\Install;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Module\Install as InstallRequest;
use App\Events\Install\UpdateCacheCleared;
use App\Events\Install\UpdateCopied;
use App\Events\Install\UpdateDownloaded;
use App\Events\Install\UpdateUnzipped;
use App\Jobs\Install\CopyFiles;
use App\Jobs\Install\DownloadFile;
use App\Jobs\Install\FinishUpdate;
use App\Jobs\Install\UnzipFile;
use App\Utilities\Versions;
use Illuminate\Support\Facades\Cache;

class Updates extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $updates = Versions::getUpdates();

        $core = null;

        $modules = [];

        if (isset($updates['core'])) {
            $core = $updates['core'];
        }

        $rows = module()->all();

        if ($rows) {
            foreach ($rows as $row) {
                $alias = $row->get('alias');

                if (!isset($updates[$alias])) {
                    continue;
                }

                $m = new \stdClass();
                $m->name = $row->getName();
                $m->alias = $row->get('alias');
                $m->installed = $row->get('version');
                $m->latest = $updates[$alias]->latest;
                $m->errors = $updates[$alias]->errors;
                $m->message = $updates[$alias]->message;

                $modules[] = $m;
            }
        }

        return view('install.updates.index', compact('core', 'modules'));
    }

    public function changelog()
    {
        return Versions::changelog();
    }

    /**
     * Check for updates.
     *
     * @return Response
     */
    public function check()
    {
        // Clear cache in order to check for updates
        Cache::forget('updates');
        Cache::forget('versions');

        event(new UpdateCacheCleared(company_id()));

        return redirect()->back();
    }

    /**
     * Run the update.
     *
     * @param  $alias
     * @param  $version
     * @return Response
     */
    public function run($alias, $version)
    {
        if ($alias == 'core') {
            $name = 'Ovds ' . $version;

            $installed = version('short');
        } else {
            // Get module instance
            $module = module($alias);

            $name = $module->getName();

            $installed = $module->get('version');

            if (version_compare($installed, $version, '>=')) {
                flash(trans('modules.warning.latest_version', ['module' => $name]))->warning()->important();

                return $this->check();
            }
        }

        return view('install.updates.edit', compact('alias', 'name', 'installed', 'version'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  $request
     *
     * @return Response
     */
    public function steps(InstallRequest $request)
    {
        $steps = [];

        $name = $request['name'];

        // Download
        $steps[] = [
            'text' => trans('modules.installation.download', ['module' => $name]),
            'url'  => route('updates.download'),
        ];

        // Unzip
        $steps[] = [
            'text' => trans('modules.installation.unzip', ['module' => $name]),
            'url'  => route('updates.unzip'),
        ];

        // Copy files
        $steps[] = [
            'text' => trans('modules.installation.file_copy', ['module' => $name]),
            'url'  => route('updates.copy'),
        ];

        // Finish/Apply
        $steps[] = [
            'text' => trans('modules.installation.finish', ['module' => $name]),
            'url'  => route('updates.finish'),
        ];

        // Redirect
        $steps[] = [
            'text' => trans('modules.installation.redirect', ['module' => $name]),
            'url'  => route('updates.redirect'),
        ];

        return response()->json([
            'success' => true,
            'error' => false,
            'data' => $steps,
            'message' => null
        ]);
    }

    /**
     * Download the file
     *
     * @param  $request
     *
     * @return Response
     */
    public function download(InstallRequest $request)
    {
        set_time_limit(900); // 15 minutes

        try {
            $path = $this->dispatch(new DownloadFile($request['alias'], $request['version']));

            event(new UpdateDownloaded($request['alias'], $request['version'], $request['installed']));

            $json = [
                'success' => true,
                'error' => false,
                'message' => null,
                'data' => [
                    'path' => $path,
                ],
            ];
        } catch (\Exception $e) {
            $json = [
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }

        return response()->json($json);
    }

    /**
     * Unzip the downloaded file
     *
     * @param  $request
     *
     * @return Response
     */
    public function unzip(InstallRequest $request)
    {
        set_time_limit(900); // 15 minutes

        try {
            $path = $this->dispatch(new UnzipFile($request['alias'], $request['path']));

            event(new UpdateUnzipped($request['alias'], $request['version'], $request['installed']));

            $json = [
                'success' => true,
                'error' => false,
                'message' => null,
                'data' => [
                    'path' => $path,
                ],
            ];
        } catch (\Exception $e) {
            $json = [
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }

        return response()->json($json);
    }

    /**
     * Copy files
     *
     * @param  $request
     *
     * @return Response
     */
    public function copyFiles(InstallRequest $request)
    {
        set_time_limit(900); // 15 minutes

        try {
            $path = $this->dispatch(new CopyFiles($request['alias'], $request['path']));

            event(new UpdateCopied($request['alias'], $request['version'], $request['installed']));

            $json = [
                'success' => true,
                'error' => false,
                'message' => null,
                'data' => [
                    'path' => $path,
                ],
            ];
        } catch (\Exception $e) {
            $json = [
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }

        return response()->json($json);
    }

    /**
     * Finish the update
     *
     * @param  $request
     *
     * @return Response
     */
    public function finish(InstallRequest $request)
    {
        set_time_limit(900); // 15 minutes

        try {
            $this->dispatch(new FinishUpdate($request['alias'], $request['version'], $request['installed'], company_id()));

            $json = [
                'success' => true,
                'error' => false,
                'message' => null,
                'data' => [],
            ];
        } catch (\Exception $e) {
            $json = [
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }

        return response()->json($json);
    }

    /**
     * Redirect back
     *
     * @param  $request
     *
     * @return Response
     */
    public function redirect()
    {
        $json = [
            'success' => true,
            'errors' => false,
            'redirect' => route('updates.index'),
            'data' => [],
        ];

        return response()->json($json);
    }
}
