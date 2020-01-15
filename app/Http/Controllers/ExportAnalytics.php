<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Export;
use App\Notifications\DownloadExport;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ZanySoft\Zip\Zip;

class ExportAnalytics extends Controller
{
    //
    public $task;
    public $arrayLimit = 100000;
    public $codeLimit = 12;
    public $count = 0;
    public $total = 0;
    public $user;
    public $zipName;


    public function makeDirectory()
    {
        $name = str_replace(" ", "_", $this->task->name);
        $this->zipName = $name;
        @$this->delete_files('exports/analytics/' . $name);
        @mkdir('exports/');
        @mkdir('exports/analytics/');
        @mkdir('exports/analytics/' . $name);

    }

    public function delete_files($target) {
        if(is_dir($target) && file_exists($target) ){
            chmod($target, 0777);
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->delete_files( $file );
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

    public function makeSubDirectory($name, $data)
    {
        @mkdir('exports/analytics/' . $this->zipName. '/' . $name);
            $count = 1;
            $counter = 1;
            while($count > 0) {
                $data = $data
                ->skip($this->count)
                ->orderBy('batch_id')
                ->with('batch')
                ->take($this->arrayLimit);
                // dd($data);
                $count = $data->count();
                if($count == 0) break;
                $file = fopen('exports/analytics/' . $this->zipName .'/'.$name .'/'. $counter . '.csv', 'wb');
                $this->build($data->get(), $file);
                if(is_resource($file)) {
                    fclose($file);
                }
                $this->count += $count;
                $counter++;
            }
    }

    public function export(State $state, int $batch = 0)
    {
        $this->task = $state;
        $this->user = $state->user;

        $this->makeDirectory();

        if($batch === 0) {
            // get all batch denominations and export then send email and return response
            $this->getMonthlyEntries($state);
            $this->createArchive('exports/analytics/'.$this->zipName);
            Export::where('user_id', $this->user->id)->update(['status' => 1]);
            return back()->with('message', 'Analytics exported successfully');
        }

        // return specified denomination
        $batch = Batch::find($batch);
        if($batch) {
            $this->task = $batch;
            if(!$batch->entries()) return response()->json(['error' => 'No analytics found'], 404);
            $this->getMonthlyEntries($state, $batch);
            $this->createArchive('exports/analytics/'.$this->zipName);
            Export::where('user_id', $this->user->id)->update(['status' => 1]);
            return back()->with('message', 'Analytics exported successfully');
        }
    }

    public function build($data, $file)
    {
        foreach ($data as $fields) {
            $array = [
                $fields->batch->name,
                $fields->code,
                $fields->cost,
                $fields->customer_name,
                $fields->customer_phone,
                date('d-M-Y h:i A', strtotime($fields->created_at)),
            ];

            fputcsv($file, $array);
        }
    }

    public function createArchive($path)
    {
        $zip = Zip::create($path.'.zip');
        $zip->add($path);
        $zip->close();


        $this->mailArchive($path. '.zip');
        // @$this->delete_files('exports/analytics/' . $this->zipName . '/');

    }

    public function mailArchive($location)
    {
        $data = new \stdClass;
        $data->location = $location;
        $data->campaign = $this->zipName;
        $data->title = $this->task->name . ' analytics Exported successfully';
        $data->email = 'emmanuel@mayapro1.com';

        User::where('admin', 1)->first()->notify(new DownloadExport($data));
        // $this->user->notify(new DownloadExport($data));
    }

    public function getMonthlyEntries($state, $batch = 0)
    {
        if($batch === 0) {
            for ($i=1; $i<=12; $i++){
                $month = $this->getMonthAcronym($i);
                $entryPerMonth = $state->entries()->whereMonth('created_at', date('m',strtotime('-'.$i.' month')));
                if($entryPerMonth->count() > 0) {
                    $this->makeSubDirectory($month, $entryPerMonth);
                }
            }
        }
        else {
            for ($i=1; $i<=12; $i++){
                $month = $this->getMonthAcronym($i);
                $entryPerMonth = $state->entries()->where('batch_id', $batch)->whereMonth('created_at', date('m',strtotime('-'.$i.' month')));
                if($entryPerMonth->count() > 0) {
                    $this->makeSubDirectory($month, $entryPerMonth);
                }
            }
        }
    }

    public function getMonthAcronym($month)
    {
        $result = 'Jan';
        switch ($month) {
            case 1:
                $result = 'Jan';
                break;
            case 2:
                $result = 'Feb';
                break;
            case 3:
                $result = 'Mar';
                break;
            case 4:
                $result = 'Apr';
                break;
            case 5:
                $result = 'May';
                break;
            case 6:
                $result = 'Jun';
                break;
            case 7:
                $result = 'Jul';
                break;
            case 8:
                $result = 'Aug';
                break;
            case 9:
                $result = 'Sep';
                break;
            case 10:
                $result = 'Oct';
                break;
            case 11:
                $result = 'Nov';
                break;
            case 12:
                $result = 'Dec';
                break;
            default:
                $result = 'Jan';
                break;
        }

        return $result;
    }
}
