<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Carbon\Carbon;

use Response;
use Input;
use DB;

use App\User;
use App\Prodi;
use App\Fakultas;
use App\ChatLog;
use Telegram;

class FbBotController extends Controller
{
    public function privacyPolicy() {
      return view('facebookPrivacyPolicy.index');
    }

    public function webhook() {
      /* ---------------- For Verifying FB Messenger API Webhook ---------------- */
      $local_verify_token = env('FB_WEBHOOK_VERIFY_TOKEN');
      $hub_verify_token = Input::get('hub_verify_token');

      if($local_verify_token == $hub_verify_token) {
        return Input::get('hub_challenge');
      } else {
        return "Bad verify token";
      }
      /* ---------------- For Verifying FB Messenger API Webhook ---------------- */
    }

    public function updates(Request $request) {
      $responses = file_get_contents("php://input");
      $responses_convert = json_decode($responses);

      $userId = $responses_convert->entry[0]->messaging[0]->sender->id;

      // if(isset($responses_convert->entry[0]->message)) {
        $this->setRead($userId);
        $this->setTypingOn($userId);
        $this->sendMessage($userId);
        $this->setTypingOff($userId);
      // }

      $chatId = 253128578;
      $text = $responses;

      Telegram::sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
      ]);

      return response()->json("OK");
    }

    public function setRead($userId) {
      $data = array(
        'recipient'=>array('id'=>"$userId"),
        'sender_action'=>"mark_seen"
      );

      $opts = array(
        'http'=>array(
          'method'=>'POST',
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json\n"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }

    public function setTypingOn($userId) {
      $data = array(
        'recipient'=>array('id'=>"$userId"),
        'sender_action'=>"typing_on"
      );

      $opts = array(
        'http'=>array(
          'method'=>'POST',
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json\n"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }

    public function setTypingOff($userId) {
      $data = array(
        'recipient'=>array('id'=>"$userId"),
        'sender_action'=>"typing_off"
      );

      $opts = array(
        'http'=>array(
          'method'=>'POST',
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json\n"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }

    public function sendMessage($userId) {
        $data = array(
          'recipient'=>array('id'=>"$userId"),
          'message'=>array('text'=>"Halo juga")
        );

        $opts = array(
          'http'=>array(
            'method'=>'POST',
            'content'=>json_encode($data),
            'header'=>"Content-Type: application/json\n"
          )
        );
        $context = stream_context_create($opts);

        $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
        file_get_contents($website, false, $context);
    }
}
