<div class="container">
    <div class="col-md-12">
        <div class="d-flex mb-4">
            <button class="btn btn-primary ranking-main-button-job mx-2" data-link="{{ route('ranking.job.all') }}">{{ __('All') }}</button>
            <button class="btn btn-primary ranking-main-button-job mx-2" data-link="{{ route('ranking.job.hunter') }}">{{ __('Hunters') }}</button>
            <button class="btn btn-primary ranking-main-button-job mx-2" data-link="{{ route('ranking.job.thieve') }}">{{ __('Thieves') }}</button>
            <button class="btn btn-primary ranking-main-button-job mx-2" data-link="{{ route('ranking.job.trader') }}">{{ __('Traders') }}</button>
        </div>
    </div>

    <div class="col-md-12">
        <div id="content-replace-job">
            @include('ranking.ranking.job-all')
        </div>
    </div>
</div>

<script>
    jQuery('.ranking-main-button-job').click(function() {
        jQuery('.ranking-main-button-job').removeClass('active');
        paginatorAjax('#content-replace-job', jQuery(this).data('link'));
        jQuery(this).addClass('active');
    });
</script>
