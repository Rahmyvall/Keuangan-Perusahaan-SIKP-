<a href="{{ route('akun.show',$row->id_akun) }}" class="btn btn-light btn-sm border">
    <i data-feather="eye"></i>
</a>

<a href="{{ route('akun.edit',$row->id_akun) }}" class="btn btn-light btn-sm border">
    <i data-feather="edit"></i>
</a>

<form action="{{ route('akun.destroy',$row->id_akun) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button class="btn btn-light btn-sm border" onclick="return confirm('Hapus akun ini?')">
        <i data-feather="trash-2"></i>
    </button>
</form>