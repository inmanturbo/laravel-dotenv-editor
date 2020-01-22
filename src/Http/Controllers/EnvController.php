<?php

/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 19.07.16
 * Time: 06:17
 */

namespace Quickweb\DotenvEditor\Http\Controllers;

use Quickweb\DotenvEditor\DotenvEditor as Env;
use Quickweb\DotenvEditor\Exceptions\DotEnvException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class EnvController extends BaseController
{

    public function getConfig()
    {
        return new Env('dotenveditor');
    }
    // protected $env;
    /**
     * [__construct description]
     *
     * @param Env $env DotenvEditor
     */
    // public function __construct(Env $env)
    // {
    //     $env->setConfig('setup');
    //     $this->env = $env;
    //     // $this->env->setConfig('setup');
    // }

    /**
     * Shows the overview, where you can visually edit your .env-file.
     *
     * @param Request $request request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview(Request $request)
    {
        $env = $this->getConfig();

        // $data['values'] = $this->env->getContent();
        $data['values'] = $env->getContent();
        //$data['json'] = json_encode($data['values']);
        try {
            // $data['backups'] = $this->env->getBackupVersions();
            $data['backups'] = $env->getBackupVersions();
        } catch (DotEnvException $e) {
            $data['backups'] = false;
        }

        $data['url'] = $request->path();
        // return view(config($this->env->config . '.overview'), $data);
        return view(config($env->config . '.overview'), $data);
    }

    /**
     * Adds a new entry to your .env-file.
     *
     * @param Request $request request
     *
     * @return none
     */
    public function add(Request $request)
    {

        $env = $this->getConfig();
        // $this->env->addData(
        $env->addData(
            [
                $request->key => $request->value,
            ]
        );
        return response()->json([]);
    }

    /**
     * Updates the given entry from your .env.
     *
     * @param Request $request request
     *
     * @return void
     */
    public function update(Request $request)
    {
        $env = $this->getConfig();
        // $this->env->changeEnv(
        $env->changeEnv(
            [
                $request->key => $request->value,
            ]
        );
        return response()->json([]);
    }

    /**
     * Returns the content as JSON
     *
     * @param null $timestamp timespamp
     *
     * @return string
     */
    public function getDetails($timestamp = null)
    {
        $env = $this->getConfig();
        // return $this->env->getAsJson($timestamp);
        return $env->getAsJson($timestamp);
    }

    /**
     * Creates a backup of the current .env.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createBackup()
    {
        $env = $this->getConfig();
        // $this->env->createBackup();
        $env->createBackup();
        return back()->with('dotenv', trans('dotenv-editor::views.controller_backup_created'));
    }

    /**
     * Delete Backup
     *
     * @param string $timestamp timestamp
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBackup($timestamp)
    {
        $env = $this->getConfig();
        // $this->env->deleteBackup($timestamp);
        $env->deleteBackup($timestamp);
        return back()->with('dotenv', trans('dotenv-editor::views.controller_backup_deleted'));
    }

    /**
     * Restore a backup
     *
     * @param void $backuptimestamp backuptimestamp
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($backuptimestamp)
    {
        $env = $this->getConfig();
        // $this->env->restoreBackup($backuptimestamp);
        $env->restoreBackup($backuptimestamp);
        return redirect(config($this->env->config . '.route.prefix'));
    }

    /**
     * Deletes the given entry from your .env-file
     *
     * @param Request $request request
     *
     * @return void
     */
    public function delete(Request $request)
    {
        $env = $this->getConfig();
        // $this->env->deleteData([$request->key]);
        $env->deleteData([$request->key]);
    }

    /**
     * Lets you download the choosen backup-file.
     *
     * @param bool $filename filename
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($filename = false)
    {
        $env = $this->getConfig();
        if ($filename) {
            // $file = $this->env->getBackupPath() . $filename . '_env';
            $file = $env->getBackupPath() . $filename . '_env';
            return response()->download($file, $filename . '.env');
        }
        return response()->download(base_path('.env'), '.env');
    }

    /**
     * Upload a .env-file and replace the current one
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function upload(Request $request)
    {
        $env = $this->getConfig();
        $file = $request->file('backup');
        $file->move(base_path(), '.env');
        // return redirect(config($this->env->config . '.route.prefix'));
        return redirect(config($env->config . '.route.prefix'));
    }
}
