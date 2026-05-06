@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Laporan Laba Rugi</h3>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Akun</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- PENDAPATAN --}}
                    <tr class="table-success">
                        <td colspan="3"><strong>PENDAPATAN</strong></td>
                    </tr>

                    @php $totalPendapatan = 0; @endphp

                    @foreach($pendapatan as $p)
                    @php $totalPendapatan += $p['saldo']; @endphp
                    <tr>
                        <td>{{ $p['kode'] }}</td>
                        <td>{{ $p['nama'] }}</td>
                        <td class="text-end">{{ number_format($p['saldo'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <tr class="table-light">
                        <td colspan="2"><strong>Total Pendapatan</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                    </tr>

                    {{-- BEBAN --}}
                    <tr class="table-danger">
                        <td colspan="3"><strong>BEBAN</strong></td>
                    </tr>

                    @php $totalBeban = 0; @endphp

                    @foreach($beban as $b)
                    @php $totalBeban += $b['saldo']; @endphp
                    <tr>
                        <td>{{ $b['kode'] }}</td>
                        <td>{{ $b['nama'] }}</td>
                        <td class="text-end">{{ number_format($b['saldo'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <tr class="table-light">
                        <td colspan="2"><strong>Total Beban</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalBeban, 0, ',', '.') }}</strong></td>
                    </tr>

                </tbody>

                <tfoot>
                    <tr class="table-dark text-white">
                        <td colspan="2"><strong>LABA / RUGI</strong></td>
                        <td class="text-end">
                            <strong>
                                {{ number_format($totalPendapatan - $totalBeban, 0, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                </tfoot>

            </table>

        </div>
    </div>
</div>
@endsection