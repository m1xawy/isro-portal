<img src="{{ asset('/images/sro/equipment/com_itemsign.PNG') }}" class="img-clear" style="display: inline-block">

@if($item['info']['sox'] || count($item['blues']) >= 1)
    <span style="color:#{{ $item['info']['sox'] ? 'f2e43d' : '50cecd' }};font-weight: bold;margin-left: 20px">
        {{ $item['info']['WebName'] }} {{ (($item['OptLevel'] + $item['nOptValue']) > 0) ? '[+' . ($item['OptLevel'] + $item['nOptValue']) . ']' : ''}}
    </span>
@else
    <span style="font-weight: bold;margin-left: 20px">
        {{ $item['info']['WebName'] }}
    </span>
@endif
<br />
<br />

@if($item['info']['Degree'] >= '1')
    @if($item['info']['sox'])
        <b style="color:#f2e43d;">{{ $item['info']['sox'] }}</b><br />
    @endif

    <span style="color:#efdaa4;">
        @isset($item['info']['Type'])
        Sort of item: {{ data_get($item['info'], 'Type', '') }}<br />
        @else
            @if(!in_array($item['info']['TypeID3'], [6, 4, 5, 2, 1], true))
                Sort of item: {{ $item['info']['TypeID3'] == 13 ? 'Avatar Dress' : ($item['info']['TypeID3'] == 14 ? 'Devil´s Spirit' : '') }}<br />
            @endif
        @endisset
        @isset($item['info']['Detail'])
        Mounting part: {{ data_get($item['info'], 'Detail', '') }}<br />
        @endisset
        @if($item['info']['ReqLevel1'])
        Degree: {{ data_get($item['info'], 'Degree', '') }} degrees<br />
        @endif
    </span>
    <br />
    @if($item['whitestats'])
        @foreach($item['whitestats'] as $iKey => $sWhites)
            {{ $sWhites }} <br />
        @endforeach
        <br />
    @endif

    @if($item['info']['ReqLevel1'])
        Reqiure level {{ $item['info']['ReqLevel1'] }}<br />
    @endif

    @isset($item['info']['Sex'])
        {{ $item['info']['Sex'] }}<br />
    @endisset

    @if(!in_array($item['info']['TypeID3'], [6, 4, 5, 2, 1], true))
        {{ $item['ReqGender'] == 0 ? 'Female' : 'Male' }}<br />
    @endif

    @isset($item['info']['Race'])
        {{ $item['info']['Race'] }}<br />
    @endisset

    @if(!in_array($item['info']['TypeID3'], [6, 4, 5, 2, 1], true))
        <br />
        <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span>
        <br />
    @endif

    @if(in_array($item['info']['TypeID3'], [6, 4, 5, 2], true))
        <br />
        <span style="color:#efdaa4;">Wheels Count: [{{ count($item['blues']) }}]</span><br />
        <span style="color:#efdaa4;">STR Count: [{{ count($item['blues']) }}]</span><br />
        <span style="color:#efdaa4;">INT Count: [{{ count($item['blues']) }}]</span><br />
    @endif

    @if($item['blues'])
        <br />
        @foreach($item['blues'] as $aBlues)
            <b style="color:#{{ $aBlues['color'] }}">{{ $aBlues['name'] }}</b><br />
        @endforeach
    @endif

    @if(in_array($item['info']['TypeID3'], [6, 4, 5, 2], true))
        @if(!$item['nOptValue'])
            Able to use Advanced elixir.
        @else
            <b>Advanced elixir is in effect [+{{ $item['nOptValue'] }}]</b>
        @endif
    @endif
@elseif($item['info']['Degree'])
    <br/>
    <br/>

    <span style="color:#efdaa4;">Sort of item: {{ $item['info']['Type'] }}</span>
    <br/>
    <br/>

    {{ $item['info']['Sex'] }}
    <br/>
    <br/>

    @if($item['info']['timeEnd'])
        <span style="color:#efdaa4;font-weight:bold;">Awaken period</span><br/>
        {{ $item['info']['timeEnd'] }}<br/>
    @endif

    @if(!$item['info']['timeEnd'] || $item['blues'])
        @if(in_array($item['info']['TypeID3'], [13, 14], true))
        <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span><br/>
        @endif
        @if($item['blues'])
            <br/>
            <br/>
            @foreach($item['blues'] as $iKey => $aBlues)
                <span style="color:#{{ $aBlues['color'] }};font-weight: bold;">{{ $aBlues['name'] }}</span><br/>
            @endforeach
       @endif
    @endif
@elseif(data_get($item['info'], 'PetType'))
    <br/>
    <br/>

    <span style="color:#efdaa4;">Sort of item: Summon Scroll</span>
    <br/>
    <br/>

    <span style="color:#efdaa4;font-weight:bold;">Pet information</span><br/>
    pet name: {{ data_get($item['info'], 'PetName') ?: 'No Name' }}<br/>

    @if(data_get($item['info'], 'PetType') == 1)
        pet level: {{ data_get($item['info'], 'PetLevel', 0) }}
    @else
        <span style="color:#efdaa4;font-weight:bold;">Rental period</span><br/>
        {{ data_get($item['info'], 'PetEndTime', 'Unknown time') }}
    @endif

    @if(data_get($item['info'], 'inventorySize'))
        <br/>
        <br/>
        <span style="color:#efdaa4;font-weight:bold;">Inventory</span><br/>
        {{ data_get($item['info'], 'inventoryEndTime', 'Unknown time') }}<br/>
        Size: {{ data_get($item['info'], 'inventorySize', 'unknown') }} Slots
    @endif
@endif
