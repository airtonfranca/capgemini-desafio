@extends('layouts.app')

@section('content')
    <user-component id-user="{{\Illuminate\Support\Facades\Auth::id()}}"></user-component>
@endsection
