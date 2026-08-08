@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <div class="row d-flex justify-content-end mb-2">
            <div class="col-md-2">
                <select name="month" id="month" class="form-select">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach (month() as $key => $item)
                        <option value="{{ $key }}" {{ $key == date('n') ? 'selected' : '' }}>{{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" min="2024" max="2099" value="{{ date('Y') }}" step="1"
                    id="year" class="form-control" placeholder="Tahun">
            </div>
        </div>

        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row" id="weekly-expenses">
                </div>
            </div>
        </section>

        <div class="row d-flex justify-content-end">
            <div class="col-md-2">
                <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row" id="daily-expenses">
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
