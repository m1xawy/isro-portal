<div class="sro-item-detail {{ $item['special'] ? 'sro-item-special' : '' }}">
    <div class="item" data-itemInfo="1">
        @if($item['special'])
        <img alt="" class="sro-item-special-seal" src="{{ asset('/images/seal.gif') }}" />
        @endif
        @if(file_exists(public_path($item['imgpath'])))
        <img alt="" src="{{ asset(strtolower($item['imgpath'])) }}">
        @else
        <img alt="" src="{{ asset('/images/sro/icon_default.jpg') }}">
        @endif
        @if($item['amount'])
        <span class="amount">{{ $item['amount'] }}</span>
        @endif
    </div>
    <?php if ($item) : ?>
    <div class="info">
        @include('ranking.character.partials.inventory.item-blues-whites', ['item' => $item['data']])</div>
    <?php endif; ?>
    <div class="clearfix"></div>
</div>
