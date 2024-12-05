<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;

class CampaignController extends Controller
{
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

    public function create(?string $tab = null){
        return view('campaigns.create',[
            'tab' => $tab,
            'form'=> match($tab){
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config',
            },
        ]);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return back()->with('message', __('Campaign deleted'));
    }

    public function store(?string $tab = null){
        if(blank($tab)){
          $data = request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'subject' => ['required', 'string', 'max:40'],
                'email_list_id'=>['nullable'],
                'template_id'=>['nullable'],
            ]);
            session()->put('campaings::create', $data);
            return to_route('campaigns.create', ['tab' => 'template']);
        }
    }

    public function restore(Campaign $campaign)
    {
        $campaign->restore();

        return back()->with('message', __('Campaign restored'));
    }
    
}
