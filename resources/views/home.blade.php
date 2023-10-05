@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>{{ __('List of Case base reasoning!') }}</p>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Problem</th>
                                <th scope="col">Solution</th>
{{--                                <th scope="col"></th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Data 1</td>
                                <td>Data 2</td>
                            </tr>
                            <tr>
                                <td>Data 4</td>
                                <td>Data 5</td>
                            </tr>
                            <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
