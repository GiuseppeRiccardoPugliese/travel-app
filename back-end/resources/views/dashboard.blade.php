@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="travel-app">
            <span class="part1">TRA</span><span class="part2">VEL</span><span class="dash">-</span><span
                class="part3">APP</span>
        </h1>


        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

