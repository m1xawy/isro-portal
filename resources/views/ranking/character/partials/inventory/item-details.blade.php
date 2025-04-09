<div class="sro-item-detail {{ $item['special'] ? 'sro-item-special' : '' }}">
    <div class="item" data-itemInfo="1">
        @if($item['special'])
        <img alt="" class="sro-item-special-seal" src="{{ asset('/images/sro/equipment/seal.gif') }}" />
        @endif
        <img alt="" src="{{ asset(strtolower($item['imgpath'])) }}">
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
