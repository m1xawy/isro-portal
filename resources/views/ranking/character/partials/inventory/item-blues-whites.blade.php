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

    @isset($item['info']['Race'])
        {{ $item['info']['Race'] }}<br />
    @endisset

    @if(count(array_intersect([13], explode(',', $item['info']['TypeID3']))))
        <br />
        <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span>
        <br />
    @endif

    @if($item['MagParam1'] == 4611686018427387904)
        <span style="color:#ff2f51;">You may not use normal Magic Stone</span>
        <br />
        @php $str = 0 @endphp
        @php $int = 0 @endphp
        @if($item['blues'])
            @foreach($item['blues'] as $aBlues)
                @if(str_contains($aBlues['name'], 'Str'))
                    @php
                        $str += intval(preg_replace('/[^0-9]+/', '', $aBlues['name']));
                    @endphp
                    @continue
                @endif
                @if(str_contains($aBlues['name'], 'Int'))
                    @php
                        $int += intval(preg_replace('/[^0-9]+/', '', $aBlues['name']));
                    @endphp
                    @continue
                @endif
            @endforeach

            <span style="color:#efdaa4;">Wheels Count: [{{ count($item['blues']) }}]</span><br />
            <span style="color:#efdaa4;">STR Count: [{{ $str }}]</span><br />
            <span style="color:#efdaa4;">INT Count: [{{ $int }}]</span><br />
        @endif
    @endif

    {{--
    @if($item['MagParamNum'])
        <br /><span style="color:#53EE92;">Magic Param Numbers: {{ $item['MagParamNum'] }}</span><br />
        <b style="color:#50cecd">MagParam1: {{ $item['MagParam1'] }}</b><br />
        <b style="color:#50cecd">MagParam2: {{ $item['MagParam2'] }}</b><br />
        <b style="color:#50cecd">MagParam3: {{ $item['MagParam3'] }}</b><br />
        <b style="color:#50cecd">MagParam4: {{ $item['MagParam4'] }}</b><br />
        <b style="color:#50cecd">MagParam5: {{ $item['MagParam5'] }}</b><br />
        <b style="color:#50cecd">MagParam6: {{ $item['MagParam6'] }}</b><br />
        <b style="color:#50cecd">MagParam7: {{ $item['MagParam7'] }}</b><br />
        <b style="color:#50cecd">MagParam8: {{ $item['MagParam8'] }}</b><br />
        <b style="color:#50cecd">MagParam9: {{ $item['MagParam9'] }}</b><br />
        <b style="color:#50cecd">MagParam10: {{ $item['MagParam10'] }}</b><br />
        <b style="color:#50cecd">MagParam11: {{ $item['MagParam11'] }}</b><br />
        <b style="color:#50cecd">MagParam12: {{ $item['MagParam12'] }}</b><br />
    @endif
    --}}

    @if($item['blues'])
        <br />
        @foreach($item['blues'] as $aBlues)
            <b style="color:#{{ $aBlues['color'] }}">{{ $aBlues['name'] }}</b><br />
        @endforeach
    @endif

    @if(!count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
        @if(!$item['nOptValue'])
            Able to use Advanced elixir.
        @else
            <b>Advanced elixir is in effect [+{{ $item['nOptValue'] }}]</b>
        @endif
    @endif

    @isset($item['info']['timeEnd'])
        <span style="color:#efdaa4;font-weight:bold;">Awaken period</span><br/>
        {{ $item['info']['timeEnd'] }}<br/>
    @endisset
@endif
