@extends('layouts.apex')

@section('title', 'Edit Hospital - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4"><h1>Edit Hospital</h1>
    </div>

    <div class="apex-panel">
        <div class="card-body">
            <form action="{{ route('admin.hospitals.update', $hospital) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.hospitals._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.hospitals.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
