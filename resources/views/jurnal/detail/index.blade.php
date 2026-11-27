@extends('layouts.app')

@section('title', 'Detail Jurnal - ' . ($jurnal->nomor_jurnal ?? 'Tidak Ditemukan'))

@section('content')

     @php
          $detailRows = collect($details ?? []);
          $totalDebit = $detailRows->sum('debit');
          $totalKredit = $detailRows->sum('kredit');
     @endphp

     <div class="container-fluid">
          <div class="row">
               <div class="col-12">

                    {{-- HEADER DETAIL JURNAL --}}
                    <div class="card border-0 shadow-sm mb-4">

                         <div class="card-header bg-white py-3">
                              <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                                   <div>
                                        <h4 class="mb-1 fw-bold text-dark">
                                             Detail Jurnal
                                             <span class="text-primary">
                                                  #{{ $jurnal->nomor_jurnal ?? '-' }}
                                             </span>
                                        </h4>

                                        @if ($jurnal->tanggal)
                                             <small class="text-muted">
                                                  Tanggal:
                                                  {{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') }}
                                             </small>
                                        @endif

                                        <div class="mt-2">
                                             @if ($jurnal->posted)
                                                  <span class="badge bg-success">
                                                       <i data-feather="check-circle" width="13"></i>
                                                       Posted
                                                  </span>
                                             @else
                                                  <span class="badge bg-warning text-dark">
                                                       <i data-feather="clock" width="13"></i>
                                                       Draft
                                                  </span>
                                             @endif
                                        </div>
                                   </div>

                                   <div class="d-flex flex-wrap gap-2">

                                        {{-- TAMBAH DETAIL --}}
                                        @unless ($jurnal->posted)
                                             <a href="{{ route('jurnal.detail.create', $jurnal) }}" class="btn btn-primary">

                                                  <i data-feather="plus-circle" class="me-1"></i>
                                                  Tambah Detail
                                             </a>
                                        @endunless

                                        {{-- KEMBALI --}}
                                        <a href="{{ route('jurnal.show', $jurnal) }}" class="btn btn-outline-secondary">

                                             <i data-feather="arrow-left" class="me-1"></i>
                                             Kembali
                                        </a>

                                   </div>
                              </div>
                         </div>

                         <div class="card-body p-4">

                              {{-- INFORMASI TRANSAKSI --}}
                              <div class="table-responsive">

                                   <table class="table table-hover align-middle">

                                        <thead class="table-light">
                                             <tr>
                                                  <th width="5%">No</th>
                                                  <th width="12%">Kode Akun</th>
                                                  <th>Nama Akun</th>
                                                  <th>Keterangan</th>
                                                  <th class="text-end">Debit</th>
                                                  <th class="text-end">Kredit</th>
                                                  <th width="12%" class="text-center">Aksi</th>
                                             </tr>
                                        </thead>

                                        <tbody>

                                             @forelse($detailRows as $index => $detail)
                                                  <tr>

                                                       <td class="fw-medium">
                                                            {{ $index + 1 }}
                                                       </td>

                                                       <td>
                                                            <strong class="text-primary">
                                                                 {{ $detail->akun->kode_akun ?? '-' }}
                                                            </strong>
                                                       </td>

                                                       <td>
                                                            {{ $detail->akun->nama_akun ?? '-' }}
                                                       </td>

                                                       <td class="text-muted small">
                                                            {{ $detail->keterangan ?? '-' }}
                                                       </td>

                                                       {{-- DEBIT --}}
                                                       <td class="text-end fw-medium text-success">
                                                            @if ((float) $detail->debit > 0)
                                                                 Rp {{ number_format((float) $detail->debit, 2, ',', '.') }}
                                                            @else
                                                                 -
                                                            @endif
                                                       </td>

                                                       {{-- KREDIT --}}
                                                       <td class="text-end fw-medium text-danger">
                                                            @if ((float) $detail->kredit > 0)
                                                                 Rp {{ number_format((float) $detail->kredit, 2, ',', '.') }}
                                                            @else
                                                                 -
                                                            @endif
                                                       </td>

                                                       {{-- AKSI --}}
                                                       <td class="text-center">

                                                            @unless ($jurnal->posted)
                                                                 <div class="btn-group" role="group">

                                                                      {{-- EDIT --}}
                                                                      <a href="{{ route('jurnal.detail.edit', [$jurnal, $detail]) }}"
                                                                           class="btn btn-sm btn-warning" title="Edit Detail">

                                                                           <i data-feather="edit-2"></i>
                                                                      </a>

                                                                      {{-- HAPUS --}}
                                                                      <form action="{{ route('jurnal.detail.destroy', [$jurnal, $detail]) }}"
                                                                           method="POST" class="d-inline"
                                                                           onsubmit="return confirm('Yakin ingin menghapus detail jurnal ini?')">

                                                                           @csrf
                                                                           @method('DELETE')

                                                                           <button type="submit" class="btn btn-sm btn-danger"
                                                                                title="Hapus Detail">

                                                                                <i data-feather="trash-2"></i>
                                                                           </button>

                                                                      </form>

                                                                 </div>
                                                            @else
                                                                 <span class="badge bg-success">
                                                                      Terkunci
                                                                 </span>
                                                            @endunless

                                                       </td>

                                                  </tr>

                                             @empty

                                                  <tr>
                                                       <td colspan="7" class="text-center py-5">

                                                            <div class="d-flex flex-column align-items-center">

                                                                 <i data-feather="file-text" style="width:48px;height:48px;"
                                                                      class="text-muted mb-3">
                                                                 </i>

                                                                 <p class="text-muted mb-2">
                                                                      Belum ada detail transaksi.
                                                                 </p>

                                                                 @unless ($jurnal->posted)
                                                                      <a href="{{ route('jurnal.detail.create', $jurnal) }}"
                                                                           class="btn btn-outline-primary">

                                                                           <i data-feather="plus"></i>
                                                                           Buat Detail Pertama
                                                                      </a>
                                                                 @endunless

                                                            </div>

                                                       </td>
                                                  </tr>
                                             @endforelse

                                        </tbody>

                                        {{-- TOTAL --}}
                                        <tfoot class="table-light border-top border-2">

                                             <tr class="fw-bold">

                                                  <td colspan="4" class="text-end fs-5">
                                                       Total:
                                                  </td>

                                                  <td class="text-end fs-5 text-success">
                                                       Rp {{ number_format((float) $totalDebit, 2, ',', '.') }}
                                                  </td>

                                                  <td class="text-end fs-5 text-danger">
                                                       Rp {{ number_format((float) $totalKredit, 2, ',', '.') }}
                                                  </td>

                                                  <td></td>

                                             </tr>

                                        </tfoot>

                                   </table>

                              </div>

                              {{-- STATUS KESEIMBANGAN JURNAL --}}
                              <div class="mt-3">

                                   @if (round((float) $totalDebit, 2) === round((float) $totalKredit, 2))
                                        <div class="alert alert-success mb-0">
                                             <i data-feather="check-circle" class="me-2"></i>
                                             Jurnal seimbang. Total debit dan kredit sudah sesuai.
                                        </div>
                                   @else
                                        <div class="alert alert-warning mb-0">
                                             <i data-feather="alert-triangle" class="me-2"></i>
                                             Jurnal belum seimbang.
                                             Selisih:
                                             <strong>
                                                  Rp {{ number_format(abs($totalDebit - $totalKredit), 2, ',', '.') }}
                                             </strong>
                                        </div>
                                   @endif

                              </div>

                         </div>
                    </div>

               </div>
          </div>
     </div>

@endsection
