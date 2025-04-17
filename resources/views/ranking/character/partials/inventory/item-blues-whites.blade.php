<img src="{{ asset('/images/com_itemsign.PNG') }}" class="img-clear" style="display: inline-block">

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

@if($item['info']['sox'])
    <b style="color:#f2e43d;">{{ $item['info']['sox'] }}</b><br />
@endif

@isset($item['RareName'])
    <span style="color:#53EE92;font-weight: bold;">{{ $item['RareName'] }}</span><br />
@endisset

<span style="color:#efdaa4;">
    @if(count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
        @isset($item['info']['JobType'])
        Sort of item: {{ $item['info']['JobType'] }}<br />
        @endisset
    @else
        @isset($item['info']['Type'])
        Sort of item: {{ $item['info']['Type'] }}<br />
        @endisset
    @endif
    @if(!count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
        @if(count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
            @isset($item['info']['JobDetail'])
            Mounting part: {{ $item['info']['JobDetail'] }}<br />
            @endisset
            @isset($item['info']['JobDegree'])
            Level: {{ $item['info']['JobDegree'] }}<br />
            @endisset
        @else
            @isset($item['info']['Detail'])
            Mounting part: {{ $item['info']['Detail'] }}<br />
            @endisset
            @isset($item['info']['Degree'])
            Degree: {{ $item['info']['Degree'] }} degrees<br />
            @endisset
        @endif
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
    @if(count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
        Job level: {{ $item['info']['ReqLevel1'] }}<br />
    @else
        Reqiure level: {{ $item['info']['ReqLevel1'] }}<br />
     @endif
@endif

@if(!count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
    @isset($item['info']['Sex'])
        {{ $item['info']['Sex'] }}<br />
    @endisset
@endif

@isset($item['info']['Race'])
    {{ $item['info']['Race'] }}<br />
@endisset

@if(count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
    @if($item['info']['TypeID3'] == 14)
        Basic stats (HP/MP) increase when equipped.  Also, upon awakening the bracelet and activating it, the outer appearance becomes extravagant and divine power becomes available to the wearer for a time.
        <br />
        <br />
        When awakened, the Awakening Time is counted down.
    @elseif($item['info']['TypeID3'] == 13 && $item['MaxMagicOptCount'] == 0)
        Flag with enormous, magnificent dragon pattern engraved. Can be equipped in the job slot.<br />
    @else
        Dress worn by {{ $item['info']['WebName'] }}<br />
    @endif
    <br />
@endif

@if(count(array_intersect([13], explode(',', $item['info']['TypeID3']))))
    <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span>
    <br />
@elseif(count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
    <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span>
    <br />
@endif

@if(count(array_intersect([13], explode(',', $item['info']['TypeID3']))))
    @isset($item['info']['Sex'])
        <br />{{ $item['info']['Sex'] }}<br />
    @endisset
@endif

@if(count(array_intersect([14], explode(',', $item['info']['TypeID3']))))
    <br />
    <span style="color:#efdaa4;">Basic Option</span><br />
    MaximumHP 15% Increase<br />
    MaximumHP 15% Increase<br />
    <br />
@endif

@if(!count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
    @if(!count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
        @if($item['MagParam1'] >= 4611686018427387904)
            <span style="color:#ff2f51;">You may not use normal Magic Stone</span>
            <br />
            @php $aSTRCount = 0 @endphp
            @php $aINTCount = 0 @endphp
            @if($item['blues'])
                @foreach($item['blues'] as $aBlues)
                    @if($aBlues['code'] == 'MATTR_STR')
                        @php $aSTRCount += $aBlues['mValue'] @endphp
                    @endif
                    @if($aBlues['code'] == 'MATTR_INT')
                        @php $aINTCount += $aBlues['mValue'] @endphp
                    @endif
                @endforeach

                <span style="color:#efdaa4;">Wheels Count: [{{ count($item['blues']) }}]</span><br />
                <span style="color:#efdaa4;">STR Count: [{{ $aSTRCount }}]</span><br />
                <span style="color:#efdaa4;">INT Count: [{{ $aINTCount }}]</span><br />
            @endif
        @endif
    @endif
@endif

@if($item['blues'])
    <br />
    @foreach($item['blues'] as $aBlues)
        <b style="color:#{{ $aBlues['color'] }}">{{ $aBlues['name'] }} @if(isset($item['mLevel']) && $item['mLevel'] > 0) (+{{ round($aBlues['mValue'] / $aBlues['mLevel']) * 100 }}%) @endif</b><br />
    @endforeach
@endif

@if(!count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
    @if(!count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
        @if(!$item['nOptValue'])
            Able to use Advanced elixir.
        @else
            <b>Advanced elixir is in effect [+{{ $item['nOptValue'] }}]</b>
        @endif
    @endif
@endif

@if(count(array_intersect([14], explode(',', $item['info']['TypeID3']))))
    <br/><span style="color:#efdaa4;font-weight:bold;">Awaken period</span><br/>
    @isset($item['info']['devilTimeEnd'])
        {{ $item['info']['devilTimeEnd'] }}<br/>
    @endisset
@endif
