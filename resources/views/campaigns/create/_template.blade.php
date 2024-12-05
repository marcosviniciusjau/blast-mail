<div>
    <x-input.richtext id="body" class="block mt-1 w-full" name="body" :value="old('body')"/>
     <x-input.error :messages="$errors->get('body')" class="mt-2" />
</div>
