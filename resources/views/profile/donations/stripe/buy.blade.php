@extends('layouts.app')
@section('title', __('Stripe'))

@section('content')
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 py-4">Stripe</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('donations.stripe.buy.title') }}</p>

            <div class="relative overflow-x-auto">
                @if ($message = Session::get('success'))
                    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($error = Session::get('error'))
                    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                        <p>{{ $error }}</p>
                    </div>
                @endif

                @if ($message = Session::get('message'))
                    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{ __('donations.stripe.buy.info') }}</div>
                        <p class="text-gray-700 text-base">
                            {{ __('donations.stripe.buy.info-body', [
                                'silk' => $stripe->silk,
                                'amount' => $stripe->price,
                                'currency' => $method->currency
                            ]) }}
                        </p>
                        <div id="paymentResponse"></div>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="payButton">
                            {{ __('donations.stripe.buy.submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function () {
            let buyBtn = document.getElementById('payButton');
            let responseContainer = document.getElementById('paymentResponse');

            let createCheckoutSession = function (stripe) {
                return fetch('{{ route('donate-stripe-post', ['id' => $stripe->id]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        checkoutSession: 1,
                    }),
                }).then(function (result) {
                    return result.json();
                });
            };

            let handleResult = function (result) {
                if (result.error) {
                    responseContainer.innerHTML = '<p>' + result.error.message + '</p>';
                }
                buyBtn.disabled = false;
                buyBtn.textContent = 'Buy Now';
            };

            const stripe = Stripe('{{ config('stripe.public-key') }}');

            buyBtn.addEventListener('click', function (evt) {
                buyBtn.disabled = true;
                buyBtn.textContent = 'Loading ...';

                createCheckoutSession().then(function (data) {
                    if (data.sessionId) {
                        stripe.redirectToCheckout({
                            sessionId: data.sessionId,
                        }).then(handleResult);
                    } else {
                        handleResult(data);
                    }
                });
            });
        });
    </script>
@endsection
