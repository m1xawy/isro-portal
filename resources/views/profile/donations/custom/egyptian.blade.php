@extends('layouts.app')
@section('title', __('Egyption'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Egyption</h2>
            <div class="relative overflow-x-auto">

                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 mt-5">
                    <div class="container">
                        <h1>{{ __('Egyptian') }}</h1>
                                <div class="row">
                                    <div class="card content border border-dark mb-4">
                                        <div class="text-center">
                                            <p>لإكمال اتصال الدفع الخاص بك مع موزعنا عبر الديسكورد أو أحد تفاصيل الاتصال الخاصة به أدناه</p>
                                            <a href="https://discord.com/users/1071790902923771914" target="_blank" class="text-primary"><b>Addicted#3681</b></a></p><br>
                                            <a href="https://wa.me/message/SFVEWBYE26EBJ1" target="_blank" class="btn btn-primary">WhatsApp</a>
                                            <a href="https://t.me/SellerAddicted" target="_blank" class="btn btn-primary">Telegram</a>
                                        </div>
                                        <img src="{{asset('image/donations/SilkENG.png')}}" class="img-fluid" width="100%"/>
                                    </div>
                        <div class="card content">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
