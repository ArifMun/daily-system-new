@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <h3>Pengeluaran</h3>
    </div>
    <div class="page-content">
        <div class="row">

            <div class="col-8 col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-lg-3">
                                <span>Hari ini</span>
                            </div>
                            <div class="col-lg-3">
                                <span>Bulan ini</span>
                            </div>
                            <div class="col-lg-3">
                                <span>Tahun ini</span>
                            </div>
                            <div class="col-lg-3">
                                <span>Sisa</span>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table">
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
                        <form action="">
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
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    <div class="form-group">
                                        <label for="">Harga</label>
                                        <input type="text" name="price" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <div class="form-group">
                                        <label for="">Jumlah</label>
                                        <input type="number" name="qty" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Sumber Dana</label>
                                    <select name="alary_id" id="" class="form-select">

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="category_id" id="" class="form-select"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input type="text" name="total_price" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <button type="button" class="btn btn-primary">Simpan</button>
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
@endpush
