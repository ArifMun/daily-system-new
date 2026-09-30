@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <h3>Pemasukan</h3>
    </div>
    <div class="page-content">
        <div class="row">

            <div class="col-8 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <table class="table" style="font-size: 14px !important">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                    <th>Sisa</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody id="list-salaries">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="" id="salary-earning">
                            <input type="hidden" id="salary-id" name="salary_id">
                            <div class="row border-1 bg-primary rounded-3 text-center p-2">
                                <label for="" class="font-bold text-white">Form Pemasukan</label>
                            </div>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="date" class="form-control" name="date_salary_payment"
                                        id="date-salary-payment" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Nama Pemasukan</label>
                                    <input type="text" class="form-control" name="name_month" id="name-month" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Nominal</label>
                                    <input type="text" name="salary_amount" id="salary-amount" class="form-control right"
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Jenis</label>
                                    <select name="fund_type" id="fund-type" class="form-control">
                                        <option value="">-- Pilih Jenis Pemasukan --</option>
                                        <option value="salary">Gaji</option>
                                        <option value="sales_income">Penjualan</option>
                                        <option value="bonus">Bonus</option>
                                        <option value="thr">THR</option>
                                    </select>
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
    <script src="{{ asset('assets/js/salaries.js') }}"></script>
@endpush
