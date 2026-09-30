@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <h3>Tabungan</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table" style="font-size: 14px !important">
                            <thead>
                                <th>No</th>
                                <th>Nominal</th>
                                <th>Tanggal Menabung</th>
                            </thead>
                            <tbody>
                                @foreach ($salarySaving as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ 'Rp ' . number_format($item->nominal, 0, ',', '.') }}</td>
                                        <td>{{ date('d F Y', strtotime($item->purchase->date)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
