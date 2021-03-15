@extends('errors::minimal')

@section('title', __('Service unavailable'))
@section('code', '412')
@section('message', __('Please, make sure all the input files are not open in Excel.'))
