@extends('layouts.master')

@section('content')
<h2 class="text-bold">{{ __('OpenVPN') }}</h2>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link active" href="#installation" data-toggle="tab">
            <i class="fas fa-server"></i> {{ __('Kurulum') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" onclick="createCerfPage()" href="#createCertificate" data-toggle="tab">
            <i class="fas fa-info"></i> {{ __('Yeni Sertifika') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" onclick="checkVpnService()" href="#listClients" data-toggle="tab">
            <i class="fa-solid fa-users"></i> {{ __('Aktif Kullanıcılar') }}
        </a>
    </li>
</ul>

<div class="tab-content">
    <div id="installation" class="tab-pane active">
        @include('installation.main')
    </div>

    <div id="createCertificate" class="tab-pane">
        @include('certificate.main')
    </div>

    <div id="listClients" class="tab-pane">
        @include('clientlist.main')
    </div>

    <div id="checkAlert" class="alert alert-danger hidden mt-4">Öncelikle kurulum sayfasından eklentiyi kurmalısın!
    </div>

</div>
@include('scripts')
@endsection