@extends('layouts/contentLayoutMaster')

@section('title', 'Cetak Dokumen')

@section('content')
<div class="embed-responsive embed-responsive-4by3">
    <iframe class="embed-responsive-item" src="/surat/{{$surat->klasifikasi}}/{{$surat->institusi}}/{{$surat->id}}/{{$surat->dokumen}}" align="top" height="600" width="100%" frameborder="0" scrolling="auto"></iframe>
</div>
@endsection