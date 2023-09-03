<form class="card" wire:submit.prevent="submit" x-data="{ tabId: 'default', tabLabel: '{{ $mainTab['label'] }}' }">
    <div class="row g-0">
        <div class="col-12 col-md-3 border-end">
            <div class="card-body">
                <h4 class="subheader">Tabs</h4>
                <div class="list-group list-group-transparent">
                    @foreach ($tabs as $tab)
                        <a href="#" x-on:click="tabId = '{{ $tab['id'] }}'; tabLabel = '{{ $tab['label'] }}'"
                            class="list-group-item list-group-item-action d-flex align-items-center"
                            :class="{ 'active': tabId === '{{ $tab['id'] }}' }">{{ $tab['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-9 d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title" x-text="tabLabel">Card with side status</h3>

                @foreach ($groupFields as $tabfields => $fields)
                    <div x-show="tabId == '{{ $tabfields }}'">
                        @foreach ($fields as $field)
                            @if ($field['type'] == 'text')
                                <x-store-php-text-field label="{{ $field['label'] }}" model="{{ $field['model'] }}"
                                    :hint="$field['hint']" :required="str_contains($field['rules'], 'required')" />
                            @endif

                            @if ($field['type'] == 'select')
                                <x-store-php-select-field label="{{ $field['label'] }}" model="{{ $field['model'] }}"
                                    :options="$field['options']" :hint="$field['hint']" :required="str_contains($field['rules'], 'required')" :multiple="$field['multiple']" />
                            @endif

                            @if ($field['type'] == 'textarea')
                                <x-store-php-textarea-field label="{{ $field['label'] }}"
                                    model="{{ $field['model'] }}" :hint="$field['hint']" :required="str_contains($field['rules'], 'required')" />
                            @endif

                            @if ($field['type'] == 'date')
                                <x-store-php-date-field label="{{ $field['label'] }}" model="{{ $field['model'] }}"
                                    :hint="$field['hint']" :required="str_contains($field['rules'], 'required')" />
                            @endif

                            @if ($field['type'] == 'checkbox')
                                <x-store-php-checkbox-field label="{{ $field['label'] }}"
                                    model="{{ $field['model'] }}" :hint="$field['hint']" :required="str_contains($field['rules'], 'required')" />
                            @endif
                        @endforeach
                    </div>
                @endforeach

            </div>
            <div class="card-footer bg-transparent mt-auto">
                <div class="btn-list justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
