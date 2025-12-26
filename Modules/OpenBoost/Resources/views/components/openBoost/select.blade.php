<select 
    id="{{ $id }}" 
    class="openBoost-select form-select"
    data-openboost-select="true"
    data-openboost-select-lib="{{ $lib }}"
    data-openboost-select-search="{{ $search ? '1' : '0' }}"
    data-openboost-select-theme="bootstrap-5"
    data-openboost-select-multiple="{{ $multiple ? '1' : '0' }}"
    {{ $multiple ? 'multiple' : '' }}
    {{ $attributes }}
>
    {{ $slot }}
</select>
