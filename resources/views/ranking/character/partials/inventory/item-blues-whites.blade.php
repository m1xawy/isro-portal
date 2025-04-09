<img src="{{ asset('/images/sro/equipment/com_itemsign.PNG') }}" class="img-clear" style="display: inline-block">

@if($item['info']['sox'] || count($item['blues']) >= 1)
    <span style="color:#{{ $item['info']['sox'] ? 'f2e43d' : '50cecd' }};font-weight: bold;margin-left: 20px">
        {{ $item['info']['WebName'] }} {{ (($item['OptLevel'] + $item['nOptValue']) > 0) ? '[+' . ($item['OptLevel'] + $item['nOptValue']) . ']' : ''}}
    </span>
@endif
<br />
<br />

@if($item['info']['Degree'] >= '1')
    @isset($item['info']['sox'])
        @if($item['info']['sox'])
            <b style="color:#f2e43d;">{{ $item['info']['sox'] }}</b><br />
        @endif
    @endisset

    <span style="color:#efdaa4;">
        Sort of item: {{ data_get($item['info'], 'Type', '') }}<br />
        @isset($item['info']['Detail'])
        Mounting part: {{ data_get($item['info'], 'Detail', '') }}<br />
        @endisset
        @isset($item['info']['ReqLevel1'])
        Degree: {{ data_get($item['info'], 'Degree', '') }} degrees<br />
        @endisset
    </span>
    <br />
    @if($item['whitestats'])
        @foreach($item['whitestats'] as $iKey => $sWhites)
            {{ $sWhites }} <br />
        @endforeach
        <br />
    @endif

    @isset($item['info']['ReqLevel1'])
        Reqiure level {{ $item['info']['ReqLevel1'] }}<br />
    @endisset

    @isset($item['info']['Sex'])
        {{ $item['info']['Sex'] }}<br />
    @endisset

    @isset($item['info']['Race'])
        {{ $item['info']['Race'] }}<br />
    @endisset

    {{--
    @if(!in_array($item['info']['TypeID4'], [14], true))
        <br />
        <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span>
        <br />
    @endif
    --}}

    @isset($item['info']['Race'])
        <br />
        <span style="color:#efdaa4;">Wheels Count [{{ count($item['blues']) }}]</span><br />
        <span style="color:#efdaa4;">STR Count [0]</span><br />
        <span style="color:#efdaa4;">INT Count [0]</span><br />
    @endif

    @if($item['blues'])
        <br />
        @foreach($item['blues'] as $aBlues)
            <b style="color:#{{ $aBlues['color'] }}">{{ $aBlues['name'] }}</b><br />
        @endforeach
    @endif

    @if(!in_array($item['info']['TypeID4'], [13, 14], true))
        @if($item['nOptValue'] === null)
            Able to use Advanced elixir.
        @else
            <b>Advanced elixir is in effect [+{{ $item['nOptValue'] }}]</b>
        @endif
    @endif
@endif
