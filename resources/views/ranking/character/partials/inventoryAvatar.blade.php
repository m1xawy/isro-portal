<div id="idInventoryAvatar" class="bg-equipment-avatar flex align-items-center flex-wrap gap-0" style="margin-left: 1.6rem; margin-bottom: 0.6rem">
    <div class="slots 1 left hat">
        <div class="itemslot">
            <div class="image"
                 @isset($playerAvatar[1]['imgpath'])
                 style="background:url('{{ $playerAvatar[1]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerAvatar[1])
                @if(data_get($playerAvatar[1], 'data'))
                    {!! $playerAvatar[1]['data'] !!}
                @endif
            @endisset
        </div>
    </div>
    <div class="slots 4 right flag">
        <div class="itemslot">
            <div class="image"
                 @isset($playerAvatar[4]['imgpath'])
                 style="background:url('{{ $playerAvatar[4]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerAvatar[4])
                @if(data_get($playerAvatar[4], 'data'))
                    {!! $playerAvatar[4]['data'] !!}
                @endif
            @endisset
        </div>
    </div>
    <div class="slots 3 right attach">
        <div class="itemslot">
            <div class="image"
                 @isset($playerAvatar[3]['imgpath'])
                 style="background:url('{{ $playerAvatar[3]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerAvatar[3])
                @if(data_get($playerAvatar[3], 'data'))
                    {!! $playerAvatar[3]['data'] !!}
                @endif
            @endisset
        </div>
    </div>
    <div class="slots 2 left dress">
        <div class="itemslot">
            <div class="image"
                 @isset($playerAvatar[2]['imgpath'])
                 style="background:url('{{ $playerAvatar[2]['imgpath'] }}') no-repeat; background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerAvatar[2])
                @if(data_get($playerAvatar[2], 'data'))
                    {!! $playerAvatar[2]['data'] !!}
                @endif
            @endisset
        </div>
    </div>
    <div class="slots 0 left spec">
        <div class="itemslot">
            <div class="image"
                 @isset($playerAvatar[0]['imgpath'])
                 style="background:url('{{ $playerAvatar[0]['imgpath'] }}') no-repeat;background-size: 34px 34px;"
                 data-iteminfo="1" @endisset>
            </div>
        </div>
        <div class="itemInfo">
            @isset($playerAvatar[0])
                {!! $playerAvatar[0]['data'] !!}
            @endisset
        </div>
    </div>
</div>

@section('scripts')
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
