<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Mail\EmailCampaign;
use App\Models\CampaignMail;

use Illuminate\Support\Facades\Http;
class TrackingController extends Controller
{

    public function openings(CampaignMail $mail)
    {
        if (! $mail->campaign->track_open) {
            return response()->noContent();
        }
    
        $mail->opened_at = now();
        $mail->openings++;
        $mail->save();
    
        // Baixa a imagem do GitHub (não recomendado em produção por latência)
        $image = Http::get('https://avatars.githubusercontent.com/u/82465988?v=4');
    
        return response($image->body())
            ->header('Content-Type', 'image/png'); // Content-Type correto da imagem
    }
    

    public function clicks(CampaignMail $mail)
    {
        if ($mail->campaign->track_click) {
            $mail->clicks++;
            $mail->save();
        }

        return redirect()->away(request()->get('f'));
    }
}
