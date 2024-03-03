@section('styles')
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
@endsection

<div id="idInventorySet" class="bg-equipment">
    <div class="slots 6 left weapon">
        <div class="itemslot">
            <div class="image"
                 @isset($items[6]['imgpath'])
                 style="background:url('{{ $items[6]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[6])
                        {{ $items[6]['amount'] }}
                    @endisset
                </span>
                @isset($items[6]['special'])
                    @if($items[6]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[6])
                {!! $items[6]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 7 right shield">
        <div class="itemslot">
            <div class="image"
                 @isset($items[7]['imgpath'])
                 style="background:url('{{ $items[7]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                   @isset($items[7])
                        {{ $items[7]['amount'] }}
                    @endisset
                </span>
                @isset($items[7]['special'])
                    @if($items[7]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[7])
                {!! $items[7]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 0 left head">
        <div class="itemslot">
            <div class="image"
                 @isset($items[0]['imgpath'])
                 style="background:url('{{ $items[0]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[0])
                        {{ $items[0]['amount'] }}
                    @endisset
                </span>
                @isset($items[0]['special'])
                    @if($items[0]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[0])
                {!! $items[0]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 2 right shoulder">
        <div class="itemslot">
            <div class="image"
                 @isset($items[2]['imgpath'])
                 style="background:url('{{ $items[2]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[2])
                        {{ $items[2]['amount'] }}
                    @endisset
                </span>
                @isset($items[2]['special'])
                    @if($items[2]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[2])
                {!! $items[2]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 1 left chest">
        <div class="itemslot">
            <div class="image"
                 @isset($items[1]['imgpath'])
                 style="background:url('{{ $items[1]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[1])
                        {{ $items[1]['amount'] }}
                    @endisset
                </span>
                @isset($items[1]['special'])
                    @if($items[1]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[1])
                {!! $items[1]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 3 right hands">
        <div class="itemslot">
            <div class="image"
                 @isset($items[3]['imgpath'])
                 style="background:url('{{ $items[3]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[3])
                        {{ $items[3]['amount'] }}
                    @endisset
                </span>
                @isset($items[3]['special'])
                    @if($items[3]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[3])
                {!! $items[3]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 4 left legs">
        <div class="itemslot">
            <div class="image"
                 @isset($items[4]['imgpath'])
                 style="background:url('{{ $items[4]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[4])
                        {{ $items[4]['amount'] }}
                    @endisset
                </span>
                @isset($items[4]['special'])
                    @if($items[4]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[4])
                {!! $items[4]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 5 right foot">
        <div class="itemslot">
            <div class="image"
                 @isset($items[5]['imgpath'])
                 style="background:url('{{ $items[5]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[5])
                        {{ $items[5]['amount'] }}
                    @endisset
                </span>
                @isset($items[5]['special'])
                    @if($items[5]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[5])
                {!! $items[5]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 9 left earring">
        <div class="itemslot">
            <div class="image"
                 @isset($items[9]['imgpath'])
                 style="background:url('{{ $items[9]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[9])
                        {{ $items[9]['amount'] }}
                    @endisset
                </span>
                @isset($items[9]['special'])
                    @if($items[9]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[9])
                {!! $items[9]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 10 right necklace">
        <div class="itemslot">
            <div class="image"
                 @isset($items[10]['imgpath'])
                 style="background:url('{{ $items[10]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[10])
                        {{ $items[10]['amount'] }}
                    @endisset
                </span>
                @isset($items[10]['special'])
                    @if($items[10]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[10])
                {!! $items[10]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 11 left lring">
        <div class="itemslot">
            <div class="image"
                 @isset($items[11]['imgpath'])
                 style="background:url('{{ $items[11]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[11])
                        {{ $items[11]['amount'] }}
                    @endisset
                </span>
                @isset($items[11]['special'])
                    @if($items[11]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[11])
                {!! $items[11]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 12 right rring">
        <div class="itemslot">
            <div class="image"
                 @isset($items[12]['imgpath'])
                 style="background:url('{{ $items[12]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($items[12])
                        {{ $items[12]['amount'] }}
                    @endisset
                </span>
                @isset($items[12]['special'])
                    @if($items[12]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[12])
                {!! $items[12]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="equip-suit-slot">
        <div class="itemslot">
            <div class="image"
                 @isset($items[8]['imgpath'])
                 style="background:url('{{ $items[8]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($items[8])
                {!! $items[8]['data'] !!}
            @endisset
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript">
        function itemInfo() {
            $(document).tooltip({
                items: "[data-itemInfo], [title]",
                position: {my: "left+5 center", at: "right center"},
                content: function () {
                    let element = jQuery(this);
                    if (jQuery(this).prop("tagName").toUpperCase() === 'IFRAME') {
                        return;
                    }
                    if (element.is("[data-itemInfo]")) {
                        if (element.parent().parent().find('.itemInfo').html() === '') {
                            return;
                        }
                        return element.parent().parent().find('.itemInfo').html();
                    }
                    if (element.is("[title]")) {
                        return element.attr("title");
                    }
                },
                close: function (event, ui) {
                    $(".ui-helper-hidden-accessible").remove();
                }
            });
        }
        $(document).ready(function () {
            itemInfo();
        });
    </script>
@endsection
