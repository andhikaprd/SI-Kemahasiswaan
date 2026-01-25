@extends('Admin.layouts.app')
@section('title','Tambah Alternatif')
@section('content')
<div class="card"><div class="card-body">
  <h5 class="mb-2">Input Mahasiswa (Alternatif)</h5>
  <small class="text-muted d-block mb-3">Isi nama mahasiswa dan nilai IPK, Tingkatan, Juara, Bahasa Inggris.</small>
  @if ($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  <form method="POST" action="{{ route('admin.tpk.alternatives.store') }}">
    @csrf
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th style="width:70px;">No</th>
            <th>Nama Mahasiswa</th>
            @foreach ($criteria as $c)
              <th class="text-center" style="width:140px;">{{ $c->name }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < 10; $i++)
            <tr>
              <td>
                <span class="row-no">{{ $i + 1 }}</span>
              </td>
              <td>
                <input name="alts[{{ $i }}][name]" class="form-control form-control-sm" placeholder="Nama Mahasiswa" value="{{ old('alts.'.$i.'.name') }}">
              </td>
              @foreach ($criteria as $c)
                <td>
                  <input name="scores[{{ $i }}][{{ $c->id }}]" type="number" step="0.01" class="form-control form-control-sm text-center" value="{{ old('scores.'.$i.'.'.$c->id) }}">
                </td>
              @endforeach
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">Simpan Data</button>
      <button type="button" class="btn btn-outline-secondary" id="add-row">Tambah Alternatif</button>
      <a href="{{ route('admin.tpk.alternatives.index') }}" class="btn btn-light">Kembali</a>
    </div>
  </form>
</div></div>

<template id="alt-row-template">
  <tr>
    <td><span class="row-no"></span></td>
    <td><input class="form-control form-control-sm" placeholder="Nama Mahasiswa"></td>
  </tr>
</template>

<script>
  (function () {
    const addBtn = document.getElementById('add-row');
    const tableBody = document.querySelector('table tbody');
    const criteriaIds = @json($criteria->pluck('id')->all());

    function nextIndex() {
      return tableBody.querySelectorAll('tr').length;
    }

    function buildRow(index) {
      const tr = document.createElement('tr');

      const tdNo = document.createElement('td');
      const no = document.createElement('span');
      no.className = 'row-no';
      no.textContent = index + 1;
      tdNo.appendChild(no);
      tr.appendChild(tdNo);

      const tdName = document.createElement('td');
      const nameInput = document.createElement('input');
      nameInput.name = `alts[${index}][name]`;
      nameInput.className = 'form-control form-control-sm';
      nameInput.placeholder = 'Nama Mahasiswa';
      tdName.appendChild(nameInput);
      tr.appendChild(tdName);

      criteriaIds.forEach((cid) => {
        const td = document.createElement('td');
        const input = document.createElement('input');
        input.name = `scores[${index}][${cid}]`;
        input.type = 'number';
        input.step = '0.01';
        input.className = 'form-control form-control-sm text-center';
        td.appendChild(input);
        tr.appendChild(td);
      });

      return tr;
    }

    addBtn?.addEventListener('click', function () {
      const idx = nextIndex();
      tableBody.appendChild(buildRow(idx));
    });
  })();
</script>
@endsection
