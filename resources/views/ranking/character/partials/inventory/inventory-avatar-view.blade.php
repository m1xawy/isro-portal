@php
    $inventoryList = [
        1 => null,
        3 => null,
        0 => null,
        2 => null,
        4 => null,
    ];

    foreach ($inventoryAvatarList as $key => $inventorySlot) {
        $inventoryList[$inventoryAvatarList[$key]['Slot']] = $inventorySlot;
    }
@endphp

<!--<h2>InventoryAvatar</h2>-->
<div class="table-responsive">
    <table class="table table-borderless table-inventory table-inventory-avatar mx-auto">
        <?php
        $i = 0;
        foreach ($inventoryList as $inventorySlot) :
            ?>
            <?= $i == 0 ? '<tr>' : '' ?>
            <?php if ($inventorySlot) { ?>
        <td>@include('ranking.character.partials.inventory.item-details', ['item' => $inventorySlot])</td>
        <?php } else { ?>
        <td>
            <div class="sro-item-detail">
                <div class="item"></div>
                <div class="clearfix"></div>
            </div>
        </td>
        <?php } ?>
            <?= $i == 1 ? '</tr>' : '' ?>
            <?php
            $i++;

            if ($i >= 2) {
                $i = 0;
            }

        endforeach;
        ?>
    </table>
</div>
