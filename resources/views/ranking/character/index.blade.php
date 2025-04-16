@extends('layouts.full')
@section('title', __('Character') . ' - ' .$characters->CharName16)

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex">
                            <img class="object-fit-cover rounded border me-4" src="{{ asset(config('global.ranking.character')[$characters->RefObjID]) }}" alt=""/>
                            <div class="mt-4">
                                <h2>{{ $characters->CharName16 }}</h2>
                                <p>Item Points: <span class="">{{ $characters->ItemPoints }}</span></p>

                                <ul class="list-unstyled d-flex">
                                    @foreach($charBuildInfo as $build)
                                        <li class="me-1">
                                            <img src="{{ asset(config('global.ranking.skill_mastery')[$build->MasteryID]['icon']) }}" title="{{ config('global.ranking.skill_mastery')[$build->MasteryID]['name'] }}" alt="">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mt-5 justify-content-end">
                            @if($characters->JobType > 0)
                                <div class="col-md-4">
                                    <div class="d-flex">
                                        <img src="{{ asset(config('global.ranking.job_type_icons')[$characters->JobType]['icon']) }}" alt=""/>
                                        <ul class="list-unstyled mt-3">
                                            <li class="mb-2">
                                                <span>{{ config('global.ranking.job_type_icons')[$characters->JobType]['name'] }}</span>
                                            </li>
                                            <li class="mb-2">Job Level: <span class="">{{ $characters->JobLevel }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-2"><i class="fa-solid fa-heart text-danger"></i> Health: <span>{{ $characters->HP }}</span></li>
                                    <li class="mb-2"><i class="fa-solid fa-star-of-life text-primary"></i> Mana: <span>{{ $characters->MP }}</span></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-2"><i class="fa-solid fa-hand-fist text-warning"></i> Strength: <span>{{ $characters->Strength }}</span></li>
                                    <li class="mb-2"><i class="fa-solid fa-brain text-warning"></i> Intellect: <span>{{ $characters->Intellect }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane" type="button" role="tab" aria-controls="info-tab-pane" aria-selected="true">Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="globals-tab" data-bs-toggle="tab" data-bs-target="#globals-tab-pane" type="button" role="tab" aria-controls="globals-tab-pane" aria-selected="false">Global Chat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="uniques-tab" data-bs-toggle="tab" data-bs-target="#uniques-tab-pane" type="button" role="tab" aria-controls="uniques-tab-pane" aria-selected="false">Unique Kills</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab" tabindex="0">
                                @include('ranking.character.partials.character-information')
                            </div>
                            <div class="tab-pane fade" id="globals-tab-pane" role="tabpanel" aria-labelledby="globals-tab" tabindex="0">
                                @include('ranking.character.partials.character-global-history')
                            </div>
                            <div class="tab-pane fade" id="uniques-tab-pane" role="tabpanel" aria-labelledby="uniques-tab" tabindex="0">
                                @include('ranking.character.partials.character-unique-history')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center">
                                <div class="bg-center bg-no-repeat" id="display-inventory-set" style="background-image: url({{ asset('images/ingame/inventory_bg.png') }}); width: 178px; height: 315px">
                                    @include('ranking.character.partials.inventory.inventory-view', ['inventorySetList' => $playerInventory])
                                </div>
                                <div class="bg-center bg-no-repeat d-none" id="display-inventory-avatar" style="background-image: url({{ asset('images/ingame/inventory_bg.png') }}); width: 178px; height: 315px;">
                                    @include('ranking.character.partials.inventory.inventory-job-view', ['inventoryJobList' => $playerJob])
                                </div>
                                <div class="bg-equipment-job-main bg-center bg-no-repeat flex flex-col justify-end" style="background-image: url({{ asset('images/ingame/accessory_bg.png') }}); width: 206px; background-position: bottom">
                                    <button id="display-inventory-switch" data-type="set" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 transition ease-in-out duration-150 ml-3" style="margin-bottom: 1rem">
                                        Job Equip
                                    </button>

                                    <p class="text-capitalize text-left" style="color: #ffc345; margin-left: 1.6rem; margin-bottom: 0.6rem">Accessories</p>
                                    @include('ranking.character.partials.inventory.inventory-avatar-view', ['inventoryAvatarList' => $playerAvatar])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/main.js') }}"></script>
    <style>
        /********CUSTOM INV********/
        .sro-item-detail .tooltip {
            text-align: left !important;
            font-size: 12px;
            width: 250px;
            min-height: 200px;
            background-color: rgba(28, 30, 52, .8);
            color: #fff;
            padding: 6px;
            border: 1px solid #808bba;
            border-radius: 5px;
            box-shadow: none;
            z-index: 999;
        }

        .table.table-inventory {
            margin: 0;
            width: 178px;
        }
        .table.table-inventory tr:first-child td {
            padding: 12px 12px 35px;
        }
        .table.table-inventory td, .table.table-inventory th {
            padding: 5.5px 5px;
        }
        .sro-item-detail.sro-item-special {
            background: 0;
        }
        .sro-item-detail {
            background: 0;
            width: auto;
            margin: 0;
        }
        .table.table-inventory td:last-child {
            float: right;
        }
        .sro-item-detail .item {
            margin: 0;
            background: 0;
        }

        /********CUSTOM INV AVATAR********/
        .table.table-inventory-avatar {
            margin: -5px auto 12px;
            width: 158px;
        }
        .table.table-inventory-avatar tbody {
            display: flex;
        }
        .table.table-inventory-avatar tr:first-child td {
            padding: 6px;
        }
        .table.table-inventory-avatar td, .table.table-inventory-avatar th {
            padding: 6px;
        }
        .table.table-inventory-avatar td:last-child {
            float: right;
        }
    </style>
@endpush
