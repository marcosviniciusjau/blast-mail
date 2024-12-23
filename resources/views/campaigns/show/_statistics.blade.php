<div class="gap-4 flex-col flex">
  <x-alert noIcon success :title=" __('Your campaign has been sent to ' . $query['total_subscribers'] . ' subscribers of the list '. $campaign->emailList->title)"/>
  <div class="bg-blue-100 grid grid-cols-3 gap-5">
    <x-dashboard.card :heading="$query['total_openings']" subheading="{{__('Opens')}}" />
    <x-dashboard.card :heading="$query['unique_openings']" subheading="{{__('Uniques opens')}}" />
    <x-dashboard.card heading="{{$query['openings_rate']}}%" subheading="{{__('Open rate')}}" />
    <x-dashboard.card :heading="$query['total_clicks']" subheading="{{__('Clicks')}}" />
    <x-dashboard.card :heading="$query['unique_clicks']" subheading="{{__('Unique clicks')}}" />
    <x-dashboard.card heading="{{$query['clicks_rate']}}%" subheading="{{__('Clicks rate')}}" />
  </div>
</div>
