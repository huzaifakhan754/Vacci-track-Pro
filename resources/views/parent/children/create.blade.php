@extends('layouts.apex')

@section('title', 'Add Child - VacciTrack')

@section('content')    

  
       
            <form action="{{ route('parent.children.store') }}" method="POST">
                @csrf
                @include('parent.children._form')               
            </form>
        
    
@endsection
