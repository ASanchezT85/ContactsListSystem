@extends('layouts.app')

@section('title') {{ auth()->user()->name }} @endsection

@section('content')
    <contacts-component />
@endsection