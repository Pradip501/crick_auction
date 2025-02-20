@extends('backend.partials.master')
@section('title')
    @if(isset($old)) Edit Player @else Add New Player @endif
@endsection
@section('maincontent')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>@if(isset($old)) Edit Player @else Add New Player @endif</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item">Players</li>
                <li class="breadcrumb-item active">@if(isset($old)) Edit Player @else New Player @endif</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-10">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">@if(isset($old)) Edit Player Information @else Add Player Information @endif</h5>

                        <form action="{{ isset($old) ? route('players.update', $old->id) : route('players.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($old))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Player Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-control" value="{{ isset($old) ? $old->name : '' }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="formFile" class="col-sm-2 col-form-label">Image Upload</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" name="image" id="formFile">
                                @if(isset($old) && $old->image)
                                    <img src="{{ asset('backend/player-images/' . $old->image) }}" alt="Player Image" style="max-width: 100px; margin-top: 10px;">
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-sm-2 col-form-label">Playing Role</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="role" required>
                                    <option>Select Role</option>
                                    <option value="Batsman" {{ isset($old) && $old->role == 'Batsman' ? 'selected' : '' }}>Batsman</option>
                                    <option value="Baller" {{ isset($old) && $old->role == 'Baller' ? 'selected' : '' }}>Baller</option>
                                    <option value="All-Rounder" {{ isset($old) && $old->role == 'All-Rounder' ? 'selected' : '' }}>All-Rounder</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">@if(isset($old)) Update Player @else Submit @endif</button>
                                <a href="{{route('players')}}" class="btn btn-info">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
