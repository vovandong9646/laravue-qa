<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $question->answers_count ." ".str_plural('Answer', $question->answers_count) }}</h2>
                </div>
                <hr/>
                @include('layouts._message')
                @foreach($question->answersMethodRelationship as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This answer is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">123</span>
                            <a title="This answer is not useful" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            @can('accept-question', $question)
                                <a onclick="event.preventDefault();document.getElementById('check_best_answer_{{ $answer->id }}').submit();" title="Mark this answer as best answer" class="{{ $answer->status }} mt-2">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form style="display:none;" action="{{ route('answers.accept', $answer->id) }}" id="check_best_answer_{{ $answer->id }}" method="POST">
                                    @csrf
                                </form>
                            @endcan
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="float-right">
                                <span class="text-muted">Answered {{$answer->created_date}}</span>
                                <div class="media mt-2">
                                    <a href="{{ $answer->user->url }}" class="pr-2">
                                        <img src="{{ $answer->user->avatar }}" alt=""/>
                                    </a>
                                    <div class="media-body mt-1">
                                        <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            @can('update', $answer)
                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}"
                                   class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can('delete', $answer)
                                <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}"
                                      method="POST">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button onclick="return confirm('Are you sure ?');" type="submit"
                                            class="btn btn-sm btn-outline-danger">Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>