@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Laporan Neraca</h3>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Akun</th>
                        <th class="text-end">Saldo</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- ASET --}}
                    <tr class="table-primary">
                        <td colspan="3"><strong>ASET</strong></td>
                    </tr>

                    @php $totalAset = 0; @endphp

                    @foreach($aset as $a)
                    @php $totalAset += $a['saldo']; @endphp
                    <tr>
                        <td>{{ $a['kode'] }}</td>
                        <td>{{ $a['nama'] }}</td>
                        <td class="text-end">{{ number_format($a['saldo'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <tr class="table-light">
                        <td colspan="2"><strong>Total Aset</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalAset, 0, ',', '.') }}</strong></td>
                    </tr>

                    {{-- LIABILITAS --}}
                    <tr class="table-warning">
                        <td colspan="3"><strong>LIABILITAS</strong></td>
                    </tr>

                    @php $totalLiabilitas = 0; @endphp

                    @foreach($liabilitas as $l)
                    @php $totalLiabilitas += $l['saldo']; @endphp
                    <tr>
                        <td>{{ $l['kode'] }}</td>
                        <td>{{ $l['nama'] }}</td>
                        <td class="text-end">{{ number_format($l['saldo'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <tr class="table-light">
                        <td colspan="2"><strong>Total Liabilitas</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalLiabilitas, 0, ',', '.') }}</strong></td>
                    </tr>

                    {{-- EKUITAS --}}
                    <tr class="table-success">
                        <td colspan="3"><strong>EKUITAS</strong></td>
                    </tr>

                    @php $totalEkuitas = 0; @endphp

                    @foreach($ekuitas as $e)
                    @php $totalEkuitas += $e['saldo']; @endphp
                    <tr>
                        <td>{{ $e['kode'] }}</td>
                        <td>{{ $e['nama'] }}</td>
                        <td class="text-end">{{ number_format($e['saldo'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach

                    <tr class="table-light">
                        <td colspan="2"><strong>Total Ekuitas</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalEkuitas, 0, ',', '.') }}</strong></td>
                    </tr>

                </tbody>

                <tfoot>
                    <tr class="table-dark text-white">
                        <td colspan="2"><strong>TOTAL KESEIMBANGAN</strong></td>
                        <td class="text-end">
                            <strong>{{ number_format($totalAset, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </tfoot>

            </table>

        </div>
    </div>
</div>
@endsection