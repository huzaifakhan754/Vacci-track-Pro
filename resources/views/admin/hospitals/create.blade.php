@extends('layouts.apex')

@section('title', 'Add Hospital - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4"><h1>Add Hospital</h1>
    </div>

    <div class="apex-panel">
        <div class="card-body">
            <form action="{{ route('admin.hospitals.store') }}" method="POST">
                @csrf
                @include('admin.hospitals._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.hospitals.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
