<div class="gap-4 flex-col flex">
  <x-alert noIcon success :title="__('Success')">
      {{ __('Your campaign has been sent to :count recipients.') }}
  </x-alert>
  <div class="bg-blue-100 grid grid-cols-3 gap-5">
    <x-dashboard.card heading="01" subheading="{{__('Opens')}}" />
    <x-dashboard.card heading="02" subheading="{{__('Uniques opens')}}" />
    <x-dashboard.card heading="20%" subheading="{{__('Open rate')}}" />
    <x-dashboard.card heading="0" subheading="{{__('Clicks')}}" />
    <x-dashboard.card heading="0" subheading="{{__('Unique clicks')}}" />
    <x-dashboard.card heading="200" subheading="{{__('Clicked')}}" />
  </div>
</div>
