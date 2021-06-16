@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                @include('layouts.message_block')
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col text-left">
                                <h1>Сообщение от администратора</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Внимание!</h4>
                        <p class="text-body">
                            Ваш аккаунт был заблокирован администратором
                        </p>

                        <a class="btn btn-outline-danger mb-1" href="{{ route('login') }}">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
