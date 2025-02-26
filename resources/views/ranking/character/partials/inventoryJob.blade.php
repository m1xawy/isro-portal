@section('styles')
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
@endsection

<div id="idInventorySet" class="bg-equipment">
    <div class="slots 6 left weapon">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[6]['imgpath'])
                     style="background:url('{{ $playerJob[6]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[6])
                        {{ $playerJob[6]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[6]['special'])
                    @if($playerJob[6]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[6])
                {!! $playerJob[6]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 7 right shield">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[11]['imgpath'])
                     style="background:url('{{ $playerJob[11]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                   @isset($playerJob[11])
                        {{ $playerJob[11]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[11]['special'])
                    @if($playerJob[11]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[11])
                {!! $playerJob[11]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 0 left head">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[0]['imgpath'])
                     style="background:url('{{ $playerJob[0]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[0])
                        {{ $playerJob[0]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[0]['special'])
                    @if($playerJob[0]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[0])
                {!! $playerJob[0]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 2 right shoulder">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[2]['imgpath'])
                     style="background:url('{{ $playerJob[2]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[2])
                        {{ $playerJob[2]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[2]['special'])
                    @if($playerJob[2]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[2])
                {!! $playerJob[2]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 1 left chest">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[1]['imgpath'])
                     style="background:url('{{ $playerJob[1]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[1])
                        {{ $playerJob[1]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[1]['special'])
                    @if($playerJob[1]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[1])
                {!! $playerJob[1]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 3 right hands">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[3]['imgpath'])
                     style="background:url('{{ $playerJob[3]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[3])
                        {{ $playerJob[3]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[3]['special'])
                    @if($playerJob[3]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[3])
                {!! $playerJob[3]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 4 left legs">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[4]['imgpath'])
                     style="background:url('{{ $playerJob[4]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[4])
                        {{ $playerJob[4]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[4]['special'])
                    @if($playerJob[4]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[4])
                {!! $playerJob[4]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 5 right foot">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[5]['imgpath'])
                     style="background:url('{{ $playerJob[5]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[5])
                        {{ $playerJob[5]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[5]['special'])
                    @if($playerJob[5]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[5])
                {!! $playerJob[5]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 9 left earring">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[9]['imgpath'])
                     style="background:url('{{ $playerJob[9]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[9])
                        {{ $playerJob[9]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[9]['special'])
                    @if($playerJob[9]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[9])
                {!! $playerJob[9]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 10 right necklace">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[8]['imgpath'])
                     style="background:url('{{ $playerJob[8]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[8])
                        {{ $playerJob[8]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[8]['special'])
                    @if($playerJob[8]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[8])
                {!! $playerJob[8]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 11 left lring">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[7]['imgpath'])
                     style="background:url('{{ $playerJob[7]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[7])
                        {{ $playerJob[7]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[7]['special'])
                    @if($playerJob[7]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[7])
                {!! $playerJob[7]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="slots 12 right rring">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[12]['imgpath'])
                     style="background:url('{{ $playerJob[12]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
                <span class="qinfo">
                    @isset($playerJob[12])
                        {{ $playerJob[12]['amount'] }}
                    @endisset
                </span>
                @isset($playerJob[12]['special'])
                    @if($playerJob[12]['special'])
                        <span class="plus"></span>
                    @endif
                @endisset
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[12])
                {!! $playerJob[12]['data'] !!}
            @endisset
        </div>
    </div>
    <div class="equip-suit-slot">
        <div class="itemslot">
            <div class="image"
                 @isset($playerJob[10]['imgpath'])
                     style="background:url('{{ $playerJob[10]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerJob[10])
                {!! $playerJob[10]['data'] !!}
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
