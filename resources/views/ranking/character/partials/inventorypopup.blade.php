<img src="{{ asset('/images/sro/equipment/com_itemsign.PNG') }}" class="img-clear" loading="lazy" style="display: inline !important;">
@if($aItem['info']['sox'] || count($aItem['blues']) >= 1)
    @php
        $color = $aItem['info']['sox'] ? '#f2e43d' : '#50cecd';
    @endphp
    <span style="color:{{ $color }};font-weight: bold;">
        {{ $aItem['info']['WebName'] }}
        @if(($aItem['OptLevel'] + $aItem['nOptValue']) > 0)
            (+{{ $aItem['OptLevel'] + $aItem['nOptValue'] }})
        @endif
    </span>
@else
    <span style="font-weight: bold;">
        {{ $aItem['info']['WebName'] }}
    </span>
@endif
@if($aItem['amount'] > 1)
    <br>
    <br>
    {{ __('inventory.amount', ['amount' => $aItem['amount']]) }}
@endif
@if($aItem['MaxStack'] > 1)
    <br>
    {{ __('inventory.stack', ['stack' => $aItem['MaxStack']]) }}
@endif

@if(data_get($aItem['info'], 'PetState'))
    <br>
    <br>
    <span style="color:#efdaa4;">
        {{ __('inventory.pet-summon') }}
    </span>
    <br>
    <br>
    <span style="color:#efdaa4;font-weight:bold;">
        {{ __('inventory.pet-info') }}
    </span>
    <br/>
    {{ __('inventory.pet-name', ['name' => data_get($aItem['info'], 'PetName') ?: 'No Name']) }}
    <br>
    @isset($aItem['info']['ReqLevel1'])
        {{ __('inventory.require', ['level' => $aItem['info']['ReqLevel1']]) }}
    @endisset
    <br>
    @if(data_get($aItem['info'], 'PetType') == 1)
        {{ __('inventory.pet-level', ['level' => data_get($aItem['info'], 'PetLevel', 0)]) }}
    @else
        <span style="color:#efdaa4;font-weight:bold;">
            {{ __('inventory.pet-rental') }}
        </span>
        <br/>
        {{ data_get($aItem['info'], 'PetEndTime', 'Unknown time') }}
    @endif

    @if(data_get($aItem['info'], 'inventorySize'))
        <br>
        <br>
        <span style="color:#efdaa4;font-weight:bold;">
            {{ __('inventory.pet-inventory') }}
        </span>
        <br>
        {{ data_get($aItem['info'], 'inventoryEndTime', 'Unknown time') }}
        <br>
        {{ __('inventory.pet-inventory-size', ['size' => data_get($aItem['info'], 'inventorySize', 'unknown')]) }}
    @endif
@else
    @if($aItem['info']['Degree'] >= '1')
        @isset($aItem['info']['sox'])
            <br>
            @if($aItem['info']['sox'])
                <br>
                <span style="color:#f2e43d;font-weight: bold;">
                    {{ $aItem['info']['sox'] }}
                </span>
            @endif
        @endisset
        <br>

        {{--    @if($aItem['info']['egy'])--}}
        {{--        <span style="color:#53EE92;font-weight: bold;">{{ $aItem['info']['egy'] }}</span>--}}
        {{--    @endif--}}

        <span style="color:#efdaa4;">
            {{ __('inventory.sort', ['type' => data_get($aItem['info'], 'Type', '')]) }}
            <br>
            @isset($aItem['info']['Detail'])
                {{ __('inventory.mounting', ['detail' => data_get($aItem['info'], 'Detail', '')]) }}
                <br>
            @endisset
            {{ __('inventory.degree', ['degree' => data_get($aItem['info'], 'Degree', '')]) }}
        </span>
        <br>
        <br>

        @foreach($aItem['whitestats'] as $iKey => $sWhites)
            {{ $sWhites }}
            <br>
        @endforeach
        <br>

        @isset($aItem['info']['ReqLevel1'])
            {{ __('inventory.require', ['level' => $aItem['info']['ReqLevel1']]) }}
            <br>
        @endisset
        @isset($aItem['info']['Sex'])
            {{ $aItem['info']['Sex'] }}
            <br>
        @endisset

        <span style="color:#efdaa4;">
            {{ __('inventory.max-unit', ['max' => $aItem['MaxMagicOptCount']]) }}
        </span>
        <br>
        @if($aItem['blues'])
            <br>
            @foreach($aItem['blues'] as $iKey => $aBlues)
                <span style="color:{{ '#' . $aBlues['color'] }};font-weight: bold;">
                    {{ $aBlues['name'] }}
                </span>
                <br>
            @endforeach
        @endif

        @if($aItem['nOptValue'] === null)
            {{ __('inventory.able-adv') }}
        @else
            <b>
                {{ __('inventory.adv-inuse', ['plus' => $aItem['nOptValue']]) }}
            </b>
        @endif
        <br>
    @elseif($aItem['info']['Degree'])
        <br>
        <br>
        <span style="color:#efdaa4;">
            {{ __('inventory.sort', ['type' => $aItem['info']['Type']]) }}
        </span>
        <br>
        <br>
        {{ $aItem['info']['Sex'] }}
        <br>
        <br>
        @isset($aItem['info']['timeEnd'])
            <span style="color:#efdaa4;font-weight:bold;">
                {{ __('inventory.awaken') }}
            </span>
            <br>
            {{ $aItem['info']['timeEnd'] }}
            <br>
        @else
            @isset($aItem['blues'])
                <span style="color:#efdaa4;">
                    {{ __('inventory.max-unit', ['max' => $aItem['MaxMagicOptCount']]) }}
                </span>
                <br>
                <br>
                @foreach($aItem['blues'] as $iKey => $aBlues)
                    <span style="color:{{ '#' . $aBlues['color'] }};font-weight: bold;">
                        {{ $aBlues['name'] }}
                    </span>
                    <br>
                @endforeach
            @endisset
        @endisset
    @endif
@endif
{{--
@if(!isset($gm_info))
    @if (Auth::user()->role == 'admin')
    <div id="gm-info" class="text-danger">
        <br>
        <p>
            {{ __('inventory.gm.title') }}<br>
            {{ __('inventory.gm.itemid', ['id' => $aItem['ID64'] ?: '-']) }}<br>
            {{ __('inventory.gm.refitemid', ['id' => $aItem['RefItemID'] ?: '-']) }}<br>
            {{ __('inventory.gm.serial64', ['id' => $aItem['Serial64'] ?: '-']) }}<br>
        </p>
    </div>
    @endif
@endif
--}}
