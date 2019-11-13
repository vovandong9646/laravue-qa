@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2>{{ $question->title }}</h2>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all
                                        question</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="This question is useful"
                                   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                    onclick="event.preventDefault();document.getElementById('up-vote-question-{{ $question->id }}').submit()"
                                >
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form action="/questions/{{ $question->id }}/vote" id="up-vote-question-{{ $question->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>
                                <span class="votes-count">{{ $question->votes_count }}</span>
                                <a title="This question is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault();document.getElementById('down-vote-question-{{ $question->id }}').submit()">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form action="/questions/{{ $question->id }}/vote" id="down-vote-question-{{ $question->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>
                                <a title="Click to mark as favorite question(Click again to undo)" class="favorite mt-2 favorited">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">123</span>
                                </a>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">Answered {{$question->created_date}}</span>
                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url }}" class="pr-2">
                                            <img src="{{ $question->user->avatar }}" alt="" />
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('answers._index')
        @if(\Auth::user())
            @include('answers._create')
        @else
            <a href="{{ route('login') }}">Vui lòng đăng nhập để trả lời cho câu hỏi này</a>
        @endif
    </div>
@endsection
