<?php

namespace App\Http\Requests;

use App\Models\Template;
use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tab = $this->route('tab');
        $rules = [];
        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null,
            'send_when' => null,
        ], $this->all());

        if (blank($tab)) {
            $rules = [
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['required', 'exists:email_lists,id'],
                'template_id' => ['required', 'exists:templates,id'],
            ];
        }

        if ($tab == 'template') {
            $rules = [
                'body' => ['required'],
            ];
        }

        if ($tab == 'schedule') {
            if ($map['send_when'] == 'now') {
                $map['sent_at'] = now()->format('Y-m-d');
            } elseif ($map['send_when'] == 'later') {
                $rules = [
                    'sent_at' => ['required', 'date', 'after:today'],
                ];
            } else {
                $rules = ['send_when' => ['required']];
            }
        }

        // --
        $session = session('campaigns::create', $map);

        foreach ($session as $key => $value) {
            $newValue = data_get($session, $key);

            if ($key == 'track_click' || $key == 'track_open') {
                $session[$key] = $newValue;
            } elseif (filled($newValue)) {
                $session[$key] = $newValue;
            }
        }
        // --

        if ($templateId = $session['template_id'] && blank($session['body'])) {
            $template = Template::find($templateId);
            $session['body'] = $template->body;
        }

        session()->put('campaigns::create', $session);

        return $rules;
    }

    public function getData()
    {
        $session = session()->get('campaigns::create');

        unset($session['_token']);
        unset($session['send_when']);

        $session['track_click'] = $session['track_click'] ?: false;
        $session['track_open'] = $session['track_open'] ?: false;

        return $session;
    }

    public function getToRoute()
    {
        $tab = $this->route('tab');

        if (blank($tab)) {
            return route('campaigns.create', ['tab' => 'template']);
        }

        if ($tab == 'template') {
            return route('campaigns.create', ['tab' => 'schedule']);
        }

        return route('campaigns.index');
    }
}