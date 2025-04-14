@extends('layouts.full')
@section('title', __('Downloads'))

@section('content')
<div class="container">
    <div class="row">
        @forelse($downloads as $download)
        <div class="col-md-3 mb-4">
            <div class="card">
                @if ( $download->icon )
                    <img src="{{ Storage::url($download->icon) }}" class="card-img-top" alt="...">
                @endif
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $download->name }}</h5>
                    <p class="card-text">{{ $download->desc }}</p>

                    <div class="d-grid mx-auto">
                        <a href="{{ $download->url }}" class="btn btn-primary">{{ __('Download') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="alert alert-danger" role="alert">
                No Downloads available!
            </div>
        @endforelse
    </div>

    <div class="row">
        <div class="card mt-5 p-0">
            <div class="card-header">
                <h4>System Requirements</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Minimum Requirements</th>
                            <th scope="col">Recommended Requirements</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>CPU</td>
                            <td>Pentium 3 800MHz or higher</td>
                            <td>Intel i3 or higher</td>
                        </tr>
                        <tr>
                            <td>RAM</td>
                            <td>2GB</td>
                            <td>4GB</td>
                        </tr>
                        <tr>
                            <td>VGA</td>
                            <td>3D speed over GeForce2 or ATI 9000</td>
                            <td>3D speed over GeForce FX 5600 or ATI9500</td>
                        </tr>
                        <tr>
                            <td>SOUND</td>
                            <td>DirectX 9.0c Compatibility card</td>
                            <td>DirectX 9.0c Compatibility card</td>
                        </tr>
                        <tr>
                            <td>HDD</td>
                            <td>5GB or higher(including swap and temporary file)</td>
                            <td>8GB or higher(including swap and temporary file)</td>
                        </tr>
                        <tr>
                            <td>OS</td>
                            <td>Windows 7</td>
                            <td>Windows 10</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
