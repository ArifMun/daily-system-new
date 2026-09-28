@extends('layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
    <div class="page-heading">
        <h3>Pengeluaran</h3>
    </div>
    <div class="page-content">
        <div class="row">

            <div class="col-8 col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <div class="row bg-success rounded-4 text-white p-1">
                            <div class="col-lg-3">
                                <span style="font-size: 10px">Hari ini</span><br>
                                <span id="this-day"></span>
                            </div>
                            <div class="col-lg-3">
                                <span style="font-size: 10px">Bulan ini</span><br>
                                <span id="this-month"></span>
                            </div>
                            <div class="col-lg-3">
                                <span style="font-size: 10px">Tahun ini</span><br>
                                <span id="this-year"></span>
                            </div>
                            <div class="col-lg-3">
                                <span style="font-size: 10px">Sisa: </span>
                                <span style="font-size: 10px;" class="badge bg-danger" id="salary-name"></span><br>
                                <span id="remaining-salary"></span>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table" style="font-size: 14px !important">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody id="list-daily-expenses">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="" id="daily-cost">
                            <div class="row border-1 bg-danger rounded-3 text-center p-2">
                                <label for="" class="font-bold text-white">Form Pengeluaran</label>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="date" class="form-control" name="date" id="date"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    <div class="form-group">
                                        <label for="">Harga</label>
                                        <input type="text" name="price" id="price" class="form-control right"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <div class="form-group">
                                        <label for="">Jumlah</label>
                                        <input type="number" name="qty" id="qty" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Sumber Dana</label>
                                    <select name="salary_id" id="salary-id" class="form-select select2" required>
                                        <option value="">-- Pilih Sumber Dana --</option>
                                        @foreach ($salaries as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="category_id" id="category-id" class="choices form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input type="text" name="total_price" id="total-price" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <button type="button" class="btn btn-primary btn-save" id="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/daily-expenses.js') }}"></script>
    <script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
@endpush
