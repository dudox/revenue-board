<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

use App\Card;
use App\Denomination;
use App\Entry;
use App\Batch;
use App\Notifications\DownloadExport;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZanySoft\Zip\Zip;

class CardController extends Controller
{
    public $arrayLimit = 5000;
    public $exportLimit = 100000;
    public $codeLimit = 12;
    public $count = 0;
    public $total = 0;
    public $denomination;
    public $batch;
    public $zipName;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public static function getCustomerEntries($user) : int
    {
        if(!$user->state) return 0;
        $batches = $user->state->batches;
        if(!$batches) return 0;
        $count = 0;
        foreach($batches as $batch) {
            $count += $batch->entries()->count();
        }

        return $count;
    }

    public static function getStateCustomerEntries($state) : int
    {
        $batches = $state->batches;
        if(!$batches) return 0;
        $count = 0;
        foreach($batches as $batch) {
            $count += $batch->entries()->count();
        }

        return $count;
    }

    public static function allWeeklyEntries()
    {
        return Entry::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public static function allWeeklyCards()
    {
        return Card::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public static function userWeeklyCards($user)
    {
        if(!$user->state) return 0;
        // dd($user->state->batches);
        $batches = $user->state->batches;
        if(!$batches) return 0;
        $count = 0;
        foreach($batches as $batch) {
            $count += $batch->cards()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        }

        return $count;
    }

    public static function getUsedCards($user) : int
    {
        if(!$user->state) return 0;
        // dd($user->state->batches);
        $batches = $user->state->batches;
        if(!$batches) return 0;
        $count = 0;
        foreach($batches as $batch) {
            $count += $batch->cards()->count();
        }

        return $count;
    }

    public static function getStateUsedCards($state) : int
    {
        if(!$state->batches) return 0;
        // dd($user->state->batches);
        $batches = $state->batches;
        if(!$batches) return 0;
        $count = 0;
        foreach($batches as $batch) {
            $count += $batch->cards()->count();
        }

        return $count;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }

    public function generate(int $limit)
    {
        return substr(rand(111111111111, 999999999999), 0, $limit);
    }

    public function ongoing(Batch $batch)
    {
        // return $batch;

        $ongoing = $batch->denominations()->where('amount', '>', 0)->first();
        if(!$ongoing) return response()->json(['error' => 'No ongoing generation'], 404);
        return $this->makeDenomination($ongoing, $ongoing->amount, $ongoing->batch_id, $ongoing->progress);
    }

    public function viewDenominationCards(Denomination $id)
    {
        return view('admin.batches.cards')->with('cards', $id->cards()->paginate(20))->with('denomination', $id);
    }

    public function makeDenomination(Denomination $denomination, int $total, int $batch, $count = 0)
    {
        if($count === 0) {
            $count = $denomination->progress;
        }
        $this->total = $total;
        $this->count = $count;
        $this->denomination = $denomination;
        $denomination->update([
            'amount' => $total,
            'progress' => $count,
        ]);


        $response = new StreamedResponse (function() use ($batch, $denomination) {
            while($this->count < $this->total) {
                $this->makeCards($this->total, $batch);
                $ended = false;
                if($this->total === $this->count) $ended = true;
                $data = new \stdClass();
                $data->total = number_format($this->total);
                $data->progress = number_format($this->count);
                $data->denomination = number_format($this->denomination->cost);
                $data->percent = number_format($this->count / $this->total * 100, 1);
                $data->ended = $ended;
                $data->present = $this->count;
                $data->end = $this->total;

                echo 'data: ' . json_encode($data) . "\n\n";
                ob_flush();
                flush();
            }


            $denomination->update([
                'amount' => 0,
                'progress' => 0,
            ]);
            $this->count = 0;
            $this->total = 0;
            return response()->json(['error' => 'Card generation completed'], 404);
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        return $response;



    }

    public function makeCards($amount, $batch)
    {
        $cards = [];
        while(count($cards) < $this->arrayLimit) {
            $cards[] = [
                'code' => $this->generate($this->codeLimit),
                'amount' => $amount,
                'batch_id' => $batch,
                'denomination_id' => $this->denomination->id,
                'amount' => $amount,
                'created_at' => Carbon::now(),
            ];
            if(count($cards) + $this->count  == $this->total) {
                break;
            }
        }

        $this->count += count($cards);
        $this->storeCards($cards);

        $this->denomination->update([
            'progress' => $this->count,
        ]);
    }

    public function storeCards($cards)
    {
        Card::insert($cards);
    }

    public function makeDirectory()
    {
        $name = str_replace(" ", "_", $this->batch->name);
        $this->zipName = $name;
        @$this->delete_files('exports/cards/' . $name);
        @mkdir('exports/');
        @mkdir('exports/cards/');
        @mkdir('exports/cards/' . $name);

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

    public function makeSubDirectory($name)
    {
        @mkdir('exports/cards/' . $this->zipName. '/' . $name);
    }

    public function export(Batch $batch, int $denomination = 0)
    {
        $this->batch = $batch;

        $this->makeDirectory();

        if($denomination === 0) {
            // get all batch denominations and export then send email and return response
            $this->exportAll($batch);
            $this->createArchive('exports/cards/'.$this->zipName);
            return response()->json(['message' => 'Cards exported successfully'], 200);
        }

        // return specified denomination
        $denomination = Denomination::find($denomination);
        if($denomination) {
            if(!$denomination->cards()) return response()->json(['error' => 'No cards found'], 404);
            $this->exportDenomination($denomination);
            $this->createArchive('exports/cards/'.$this->zipName);
            return response()->json(['message' => 'Cards exported successfully'], 200);
        }
    }

    public function exportDenomination($denomination)
    {
        $cards = $denomination->cards()->with('denomination');
        if($cards->count() > 0) {
            $name = str_replace(" ", "_", $denomination->cost . ' ' . $denomination->duration->name);
            $this->makeSubDirectory($name);
            $count = 1;
            $counter = 1;
            while($count > 0) {
                $data = $cards
                ->skip($this->count)
                ->take($this->exportLimit)
                ->get();
                $count = $data->count();
                if($count == 0) break;
                $file = fopen('exports/cards/' . $this->zipName .'/'.$name .'/'. $counter . '.csv', 'wb');
                $this->build($data, $file);
                if(is_resource($file)) {
                    fclose($file);
                }
                $this->count += $count;
                $counter++;
            }
        }

    }

    public function build($data, $file)
    {
        foreach ($data as $fields) {
            $array = [
                $fields->code,
                $fields->denomination->cost,
                $fields->status ? 'Used' : 'Valid',
                Carbon::parse($fields->created_at)->format('d-M-Y h:i A'),
            ];

            fputcsv($file, $array);
        }
    }

    public function exportAll($batch)
    {
        foreach($batch->denominations as $denomination) {
            $this->exportDenomination($denomination);
        }
    }

    public function createArchive($path)
    {
        $zip = Zip::create($path.'.zip');
        $zip->add($path);
        $zip->close();


        $this->mailArchive($path. '.zip');
        // @$this->delete_files('exports/cards/' . $this->zipName . '/');

    }

    public function mailArchive($location)
    {

        $data = new \stdClass;
        $data->location = $location;
        $data->campaign = $this->zipName;
        $data->title = $this->batch->name . ' cards Exported successfully';
        $data->email = 'info@mayapro1.com';

        User::where('admin', 1)->first()->notify(new DownloadExport($data));
    }
}
