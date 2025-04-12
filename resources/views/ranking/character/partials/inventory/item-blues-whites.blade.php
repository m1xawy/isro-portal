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

{{--{{ var_dump($item['CodeName128']) }}<br />--}}

@if($item['info']['Degree'] >= '1')
    @if($item['info']['sox'])
        <b style="color:#f2e43d;">{{ $item['info']['sox'] }}</b><br />
    @endif
    <span style="color:#53EE92;font-weight: bold;">
        @switch($item['CodeName128'])
            @case(str_contains($item['CodeName128'], 'SET_A_RARE') && $item['Slot'] = 6)
                Power<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_B_RARE') && $item['Slot'] = 6)
                Fight<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_A_RARE') && $item['Slot'] = 7)
                Protection<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_B_RARE') && $item['Slot'] = 7)
                Guard<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_A_RARE') && in_array($item['Slot'], [0, 1, 2, 3, 4, 5]))
                Destruction<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_B_RARE') && in_array($item['Slot'], [0, 1, 2, 3, 4, 5]))
                Immortality<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_A_RARE') && in_array($item['Slot'], [9, 10, 11, 12]))
                Myth<br />
                @break

            @case(str_contains($item['CodeName128'], 'SET_B_RARE') && in_array($item['Slot'], [9, 10, 11, 12]))
                Legend<br />
                @break

            @default
        @endswitch
    </span>

    @if(!count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
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
    @else
    <span style="color:#efdaa4;">
        @if($item['info']['TypeID3'] == 2 && $item['info']['TypeID4'] == 1)
            Sort of item: Hunter Equipment (weapon)<br />
        @elseif($item['info']['TypeID3'] == 1 && $item['info']['TypeID4'] == 1)
            Sort of item: Hunter Equipment (head)<br />
        @elseif($item['info']['TypeID3'] == 1 && $item['info']['TypeID4'] == 2)
            Sort of item: Hunter Equipment (shoulder)<br />
        @elseif($item['info']['TypeID3'] == 1 && $item['info']['TypeID4'] == 3)
            Sort of item: Hunter Equipment (tunic)<br />
        @elseif($item['info']['TypeID3'] == 1 && $item['info']['TypeID4'] == 4)
            Sort of item: Hunter Equipment (pants)<br />
        @elseif($item['info']['TypeID3'] == 1 && $item['info']['TypeID4'] == 5)
            Sort of item: Hunter Equipment (gloves)<br />
        @elseif($item['info']['TypeID3'] == 1 && $item['info']['TypeID4'] == 6)
            Sort of item: Hunter Equipment (shoes)<br />
        @elseif($item['info']['TypeID3'] == 3 && $item['info']['TypeID4'] == 1)
            Sort of item: Hunter Equipment (earrging)<br />
        @elseif($item['info']['TypeID3'] == 3 && $item['info']['TypeID4'] == 2)
            Sort of item: Hunter Equipment (necklace)<br />
        @elseif($item['info']['TypeID3'] == 3 && $item['info']['TypeID4'] == 3)
            Sort of item: Hunter Equipment (ring)<br />

        @elseif($item['info']['TypeID3'] == 5 && $item['info']['TypeID4'] == 1)
            Sort of item: Thief Equipment (weapon)<br />
        @elseif($item['info']['TypeID3'] == 4 && $item['info']['TypeID4'] == 1)
            Sort of item: Thief Equipment (head)<br />
        @elseif($item['info']['TypeID3'] == 4 && $item['info']['TypeID4'] == 2)
            Sort of item: Thief Equipment (shoulder)<br />
        @elseif($item['info']['TypeID3'] == 4 && $item['info']['TypeID4'] == 3)
            Sort of item: Thief Equipment (tunic)<br />
        @elseif($item['info']['TypeID3'] == 4 && $item['info']['TypeID4'] == 4)
            Sort of item: Thief Equipment (pants)<br />
        @elseif($item['info']['TypeID3'] == 4 && $item['info']['TypeID4'] == 5)
            Sort of item: Thief Equipment (gloves)<br />
        @elseif($item['info']['TypeID3'] == 4 && $item['info']['TypeID4'] == 6)
            Sort of item: Thief Equipment (shoes)<br />
        @elseif($item['info']['TypeID3'] == 3 && $item['info']['TypeID4'] == 1)
            Sort of item: Thief Equipment (earrging)<br />
        @elseif($item['info']['TypeID3'] == 3 && $item['info']['TypeID4'] == 2)
            Sort of item: Thief Equipment (necklace)<br />
        @elseif($item['info']['TypeID3'] == 3 && $item['info']['TypeID4'] == 3)
            Sort of item: Thief Equipment (ring)<br />
        @endif
        @switch($item['Slot'])
            @case(0)
                Mounting part: Head<br />
                @break

            @case(1)
                Mounting part: Chest<br />
                @break

            @case(2)
                Mounting part: Shoulder<br />
                @break

            @case(3)
                Mounting part: Hands<br />
                @break

            @case(4)
                Mounting part: Legs<br />
                @break

            @case(5)
                Mounting part: Foot<br />
                @break

            @default
        @endswitch
        @if($item['info']['ReqLevel1'])
            @switch($item['info']['Degree'])
                @case(1)
                    Level: Lowest Quality<br />
                    @break

                @case(2)
                    Level: Low Quality<br />
                    @break

                @case(3)
                    Level: Medium Quality<br />
                    @break

                @default
                    Level: Lowest Quality<br />
            @endswitch
        @endif
    </span>
    <br />
    @endif

    @if($item['whitestats'])
        @foreach($item['whitestats'] as $iKey => $sWhites)
            {{ $sWhites }} <br />
        @endforeach
        <br />
    @endif

    @if($item['info']['ReqLevel1'])
        @if(count(array_intersect([4], explode(',', $item['info']['TypeID2']))))
            Job level: {{ $item['info']['ReqLevel1'] }}<br />
            <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span><br />
        @else
            Reqiure level: {{ $item['info']['ReqLevel1'] }}<br />
         @endif
    @endif

    @isset($item['info']['Sex'])
        {{ $item['info']['Sex'] }}<br />
    @endisset

    @isset($item['info']['Race'])
        {{ $item['info']['Race'] }}<br />
    @endisset

    @if(count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
        <span style="color:#efdaa4;">
            @isset($item['info']['Type'])
                Sort of item: {{ data_get($item['info'], 'Type', '') }}<br />
            @else
                @switch($item['MaxMagicOptCount'])
                    @case(1)
                        Sort of item: Avatar Attach<br />
                        @break

                    @case(2)
                        Sort of item: Avatar Hat<br />
                        @break

                    @case(4)
                        Sort of item: Avatar Dress<br />
                        @break

                    @case(9)
                        Sort of item: Devil spirit's<br />
                        @break

                    @default
                        Sort of item: Avatar Dress<br />
                @endswitch
            @endisset
        </span>
        <br />
    @endif

    @if(count(array_intersect([13, 14], explode(',', $item['info']['TypeID3']))))
        @if($item['info']['TypeID3'] == 14)
            Basic stats (HP/MP) increase when equipped.  Also, upon awakening the bracelet and activating it, the outer appearance becomes extravagant and divine power becomes available to the wearer for a time.
            <br />
            <br />
            When awakened, the Awakening Time is counted down.
        @else
            Dress worn by {{ $item['info']['WebName'] }}<br />
        @endif
        <br />
    @endif

    @if(count(array_intersect([13], explode(',', $item['info']['TypeID3']))))
        <span style="color:#efdaa4;">Max. no. of magic options: {{ $item['MaxMagicOptCount'] }} Unit</span>
        <br />
    @endif

    @if(count(array_intersect([14], explode(',', $item['info']['TypeID3']))))
        <br />
        <span style="color:#efdaa4;">Basic Option</span><br />
        MaximumHP 15% Increase<br />
        MaximumHP 15% Increase<br />
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
            <b style="color:#{{ $aBlues['color'] }}">{{ $aBlues['name'] }} @if($item['mLevel'] > 0) (+{{ round($aBlues['mValue'] / $aBlues['mLevel']) * 100 }}%) @endif</b><br />
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
        @isset($item['timeEnd'])
            {{ $item['timeEnd'] }}<br/>
        @else
            28Day
        @endisset
    @endif
@endif
