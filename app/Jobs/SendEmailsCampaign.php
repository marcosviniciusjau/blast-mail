<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Mail\EmailCampaign;
use App\Models\CampaignMail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

use Resend\Laravel\Facades\Resend;
class SendEmailsCampaign implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels,Dispatchable;
   
    public function __construct(public Campaign $campaign) {}

    public function handle(): void
    { 
        $env_email = env('MAIL_FROM_ADDRESS');

        foreach ($this->campaign->emailList->subscribers as $subscriber) {

            $mail = CampaignMail::create([
                'campaign_id' => $this->campaign->id,
                'subscriber_id' => $subscriber->id,
                'sent_at' => $this->campaign->send_at,
            ]);

            Resend::emails()->send([
                'from' => "Teste Emails <{$env_email}>",
                'to' => [$subscriber->email],
                'body' => (new EmailCampaign($this->campaign, $mail))->render(),
                'subject' => $this->campaign->subject,
                'html' => (new EmailCampaign($this->campaign, $mail))->render(),
            ]);
                       
        }

    }
}
