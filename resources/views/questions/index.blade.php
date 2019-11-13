@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask
                                    Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include ('layouts._message')
                        @foreach($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{ $question->votes_count  }}</strong> {{ str_plural('vote', $question->votes_count)  }}
                                    </div>
                                    <div class="status {{ $question->status }}">
                                        <strong>{{ $question->answers  }}</strong> {{ str_plural('answer', $question->anwsers)  }}
                                    </div>
                                    <div class="view">
                                        {{ $question->views  ." ". str_plural('view', $question->views)  }}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title  }}</a></h3>
                                        <div class="ml-auto">
{{--                                            @if (Auth::user()->can('update-question', $question))--}}
{{--                                            vì sao phải khóa cái if lại => tại vì Auth::user() nếu chưa login thì nó sẽ là null và không thể gọi method can() được--}}
{{--                                            tại sao Auth::user() lại null => tại vì bên QuestionsController tại hàm constructor ta đã set middleware cho question này rồi--}}
                                            @can ('update-question', $question)
{{--                                                cái update-question này ở đâu ra => trong AuthServiceProvider ta đã định nghĩa 1 cái Gate là update-question để check điều kiện mong muốn và trong QuestionController ta đã check trả về view nào tương ứng với điều kiện đó rồi--}}
{{--                                            nếu không muốn sử dụng Gate để check thì ta có thể sử dụng policies => xem ở lesson11-b để biết cách sử dụng--}}
                                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
{{--                                            @endif--}}
{{--                                            @if (Auth::user()->can('update-question', $question))--}}
                                            @can ('delete-question', $question)
                                                <form class="form-delete" action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button onclick="return confirm('Are you sure ?');" type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            @endcan
{{--                                            @endif--}}
                                        </div>
                                    </div>
                                    <p class="lead">
                                        Asked by <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date  }}</small>
                                    </p>
                                    {{ str_limit($question->body, 250)  }}
                                </div>
                            </div>
                            <hr>
                        @endforeach
                        {{--    php artisan vendor:publish --tag=laravel-pagination--}}
                        <div class="text-center">
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
