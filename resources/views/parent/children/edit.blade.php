@extends('layouts.apex')

@section('title', 'Edit Child - VacciTrack')

@section('content')      
        
            <form action="{{ route('parent.children.update', $child) }}" method="POST">
                @csrf
                @method('PUT')
                @include('parent.children._form')

                
            </form>
        
@endsection
