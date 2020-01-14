<?php

namespace App\Http\Controllers\API\USSD;

use App\Card;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Screen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class Process extends Controller
{
    //
    public $type = 1;
    public $count = 0;
    public $text = '';
    public $sessionId = '';
    public $serviceCode = '';
    public $phone = '';

    public function index(Request $request)
    {
        $this->sessionId = $request->sessionId;
        $this->serviceCode = $request->serviceCode;
        $this->phone = str_replace('+', '', $request->phoneNumber);
        $text = $request->text;
        $this->text = explode("*", $text);
        $this->count = count($this->text);

        if($text == "") {
            // $this->renderScreens();
        }

        // dd($->text);

        if($this->count < 2) {
            $this->renderErrorScreen();
        }

        if($this->text !== "") {
            $this->setType();
        }

        if($this->count === 2) {
            if($this->type == 2) {
                // Verify user card
                $this->checkValidity();
            }
            $this->checkCard();
            $this->renderNameEntry();
        }

        if($this->count === 3) {
            // dd($this->text);
            if($this->type == 1 ) {
                // Activate user card
                $this->useCard();
            }


        }

        else {
            echo $this->end('Invalid request');
            exit;
        }
    }

    public function renderChosenScreen()
    {
        $screen = Screen::where('type', $this->type)->first();
        echo $this->con($screen->message);
        die;
    }

    public function renderErrorScreen()
    {
        $message = "Invalid input format.\n Dial *347*800*1*PIN# to activate. \n And *347*800*2*PIN# to verify your card number";
        echo $this->end($message);
        die;
    }

    public function renderNameEntry()
    {
        echo $this->con('Please enter your full name');
        die;
    }

    public function setType()
    {
        $this->type = $this->text[0];
        $check = Screen::where('type', $this->type)->first();
        if(!$check) {
            echo $this->end('Invalid request');
            exit;
        }
    }

    public function con($message)
    {
        return "CON {$message}";
    }

    public function end($message)
    {
        return "END {$message}";
    }

    public function renderScreens()
    {
        $screens = Screen::all();
        // dd($screens);
        $response = "CON Welcome, please select an option.\n";
        foreach ($screens as $key => $value) {
            $step = $key + 1;
            $response = $response . $step . ". " . $value->message . ".\n";
        }

        echo $response;
        die;
    }

    public function getValidity($entry)
    {
        $expiry = Carbon::parse($entry->expires);
        $end = $expiry->format('d/m/y h:i A');
        $start = date("d/m/y h:i A", strtotime($entry->created_at));
        if($expiry->gt(Carbon::now())) {
            $message = "This Revenue Card was used by {$entry->customer_name} on {$start} and expires on {$end}";
        }
        else {
            $message = "This Revenue Card was used by {$entry->customer_name} and expired on {$end}";
        }
        return $message;
    }

    public function checkValidity()
    {
        $message = 'Invalid Card supplied';
        $entry = Entry::where('code', $this->text[1])->first();
        if($entry) {
            $expires = $this->getValidity($entry);
            $message = $expires;
        }
        else {
            $card = Card::where('code', $this->text[1])->first();
            if($card) {
                $cost = number_format($card->denomination->cost, 2);
                $message = "Inputed card is yet to be used and valued at {$cost} as {$card->denomination->duration->name} payment to {$card->batch->state->user->name}";
            }
        }

        echo $this->end($message);
        die;
    }

    public function calculateExpiry($card)
    {
        $duration = '';
        $date = $card->denomination->duration;
        switch ($date->type) {
            case 'day':
                $duration = Carbon::now()->addDays($date->value);
                break;
            case 'week':
                $duration = Carbon::now()->addWeeks($date->value);
                break;
            case 'month':
                $duration = Carbon::now()->addMonths($date->value);
                break;
            case 'year':
                $duration = Carbon::now()->addYears($date->value);
                break;

            default:
                $duration = Carbon::now()->addMonths($date->value);
                break;
        }

        $data = new stdClass();
        $data->expiry = $duration;
        $data->name = $date->name;

        return $data;
    }

    public function useCard()
    {
        $message = 'You have entered an Invalid Revenue Card';
        $card = Card::where('code', $this->text[1])->first();
        if($card) {
            if($card->status) {
                $message = 'You have entered a used Revenue Card';
            }
            else {
                $time = $this->calculateExpiry($card);
                Entry::create([
                    'code' => $card->code,
                    'batch_id' => $card->batch_id,
                    'denomination_id' => $card->denomination_id,
                    'state_id' => $card->batch->state->id,
                    'customer_phone' => $this->phone,
                    'customer_name' => $this->text[2],
                    'expires' => $time->expiry,
                    'cost' => $card->denomination->cost,
                    'session_id' => $this->sessionId,
                ]);
                $card->update([
                    'status' => 1,
                ]);
                $user = $card->batch->state->user->name;
                $cost = number_format($card->denomination->cost, 2);
                $expiryDate = date("d.m.Y.", strtotime($time->expiry));
                $message = "Your revenue payment of {$cost} to {$user} was successful. \n Validity expires on {$expiryDate} \n Dial *347*800*2*PIN#  to check expiry date anytime.";
            }
        }
        echo $this->end($message);
        die;
    }

    public function checkCard()
    {
        $card = Card::where('code', $this->text[1])->first();
        if(!$card) {
            $message = 'You have entered an Invalid Revenue Card';
            echo $this->end($message);
            die;
        }

        if($card) {
            if($card->status) {
                $message = 'You have entered a used Revenue Card';
                echo $this->end($message);
                die;
            }
        }
    }


}
