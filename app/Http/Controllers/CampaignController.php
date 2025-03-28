<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignShowRequest;
use App\Http\Requests\CampaignStoreRequest;
use App\Jobs\SendEmailsCampaign;
use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{
    use Conditionable;

    public function index()
    {
        $search = request()->get('search', null);
        $withTrashed = request()->get('withTrashed', false);

        return view('campaigns.index', [
            'campaigns' => Campaign::query()
                ->when($withTrashed, fn (Builder $query) => $query->withTrashed())
                ->when(
                    $search,
                    fn (Builder $query) => $query
                        ->where('name', 'like', "%$search%")
                        ->orWhere('id', '=', "%$search%")
                )
                ->paginate(5)
                ->appends(compact('search'), 'withTrashed'),
            'search' => $search,
            'withTrashed' => $withTrashed,
        ]);
    }

    public function show(CampaignShowRequest $request, Campaign $campaign, ?string $what = null)
    {
        if ($redirect = $request->checkWhat()) {
            return $redirect;
        }

        $search = request()->search;

        $query = $campaign->mails()
            ->when($what == 'statistics', fn(Builder $query) => $query->statistics())
            ->when($what == 'open', fn(Builder $query) => $query->openings($search))
            ->when($what == 'clicked', fn(Builder $query) => $query->clicks($search))
            ->simplePaginate(5)->withQueryString();

            if($what == 'statistics'){
                $query=$query->first()->toArray();
            }
        return view('campaigns.show', compact('campaign', 'what', 'search', 'query'));
    }


    public function create(?string $tab = null)
    {
        $data =  session()->get('campaigns::create', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null,
            'send_when' => 'now',
        ]);

        return view('campaigns.create', array_merge(
            $this->when(blank($tab), fn() => [
                'emailLists' => EmailList::query()->select(['id', 'title'])->orderBy('title')->get(),
                'templates' => Template::query()->select(['id', 'name'])->orderBy('name')->get(),
            ], fn() => []),
            $this->when($tab == 'schedule', fn() => [
                'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                'template' => Template::find($data['template_id'])->id,    
            ], fn() => []),
            [
                'tab' => $tab,
                'form' => match ($tab) {
                    'template' => '._template',
                    'schedule' => '._schedule',
                    default => '._config',
                },
                'data' => $data,
            ]
        ));
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return back()->with('message', __('Campaign deleted'));
    }

    public function store(CampaignStoreRequest $request, ?string $tab = null)
    {
        $data = $request->getData();
        $toRoute = $request->getToRoute();

        if ($tab == 'schedule') {
            $campaign = Campaign::create($data);
            $logs = [];
        
            if ($campaign) {
        
                if (!isset($data)) {
                    return response()->json([
                        'error' => 'O campo "recipient" é obrigatório para enviar o e-mail.'
                    ], 400);
                }
        
                try {
                      SendEmailsCampaign::dispatchSync($campaign);
                 
                    $logs[] = 'E-mail enviado com sucesso para ' ;
                    
                    return response()->redirectTo($toRoute);
                } catch (\Exception $e) {
                    $logs[] = 'Erro ao enviar e-mail: ' . $e->getMessage();
                }
            } else {
                $logs[] = 'Falha ao criar campanha.';
            }
        
            return response()->json(['logs' => $logs]);
        }

        return response()->redirectTo($toRoute);
    }

    public function restore(Campaign $campaign)
    {
        $campaign->restore();

        return back()->with('message', __('Campaign restored'));
    }
}
