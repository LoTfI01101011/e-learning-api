<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['email' ,'required']
        ]);
        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us17'
        ]);

        $response = $mailchimp->lists->addListMember('bc9fea622c', [
            "email_address" => $request->email,
            "status" => "subscribed",
        ]);
        return response()->json($response);
    }
}
