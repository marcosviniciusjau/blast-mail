<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Jobs\SendEmailCampaign;
use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\Conditionable;

use function PHPUnit\Framework\isNull;

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

    public function show(Campaign $campaign, ?string $what = null)
    {
        if(isNull($what)){
            return to_route('campaigns.show', ['campaign' => $campaign, 'what' => 'statistics']);
        }
        abort_unless(in_array($what, ['statistics', 'open', 'clicked']), 404);

        return view('campaigns.show', compact('campaign','what'));
    }

    public function create(?string $tab = null)
    {
        $data = session()->get('campaings::create', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null,
            'send_when' => 'now',
        ]);

        return view('campaigns.create',
            array_merge(
                $this->when(blank($tab), fn () => [
                    'emailLists' => EmailList::query()->select(['id', 'title'])->orderBy('title')->get(),
                    'templates' => Template::query()->select(['id', 'name'])->orderBy('name')->get(),
                ], fn () => []),
                $this->when($tab == 'schedule', fn () => [
                    'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                    'template' => Template::find($data['template_id'])->name,
                ], fn () => []),
                [
                    'tab' => $tab,

                    'form' => match ($tab) {
                        'template' => '_template',
                        'schedule' => '_schedule',
                        default => '_config',
                    },
                    'data' => $data,
                ]
            )
        );
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

            SendEmailCampaign::dispatchAfterResponse($campaign);
        }

        return response()->redirectTo($toRoute);
    }

    public function restore(Campaign $campaign)
    {
        $campaign->restore();

        return back()->with('message', __('Campaign restored'));
    }
}
