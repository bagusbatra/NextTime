@extends('layouts.site')

@section('title', 'NextTime')

@section('content')
  @include('partials.site.hero')
  @include('partials.site.layanan')
  @include('partials.site.kenapa')
  @include('partials.site.portofolio', ['featuredProjects' => $featuredProjects])
  @include('partials.site.klien')
  @include('partials.site.galeri')
  @include('partials.site.kontak')
@endsection
