@extends('layouts.dashboard')
@section('pageTitle')
    Statistiques slider
@endsection
@section('sectionTitle')
    Statistiques slider
@endsection
@section('content')
    {{-- <div class="col-lg-9"> --}}
    {{-- {{ dd($statistique) }} --}}
    @if ($errors->has('propertyError'))
        <div class="alert alert-danger">
            {{ $errors->first('propertyError') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="user-profile-wrapper">
        <div class="user-profile-card profile-ad">
            <div class="user-profile-card-header">
                <h4 class="user-profile-card-title">Statistiques slider</h4>
                

            </div>
            <div class="col-lg-12">
                @if (count($statistique) > 0)
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Date</th>
                                    <th>adresse IP</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statistique as $item)
                                    {{-- {{ dd($item->main_picture->alt) }} --}}
                                    <tr>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->ip }}</td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>

                    {{-- {{ $props->links() }} --}}
                    {!! $statistique->appends(request()->query())->links('vendor.pagination.default') !!}
                @else
                    <p>Aucun résultat</p>
                @endif
            </div>
        </div>
    </div>
@endsection
