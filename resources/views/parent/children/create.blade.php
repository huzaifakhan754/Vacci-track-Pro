@extends('layouts.apex')

@section('title', 'Add Child - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4"><h1>Add Child</h1>
    </div>

    <div class="apex-panel">
        <div class="card-body">
            <form action="{{ route('parent.children.store') }}" method="POST">
                @csrf
                @include('parent.children._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('parent.children.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
