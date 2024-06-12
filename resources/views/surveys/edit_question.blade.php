@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Question</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('surveys.questions.update', [$survey->slug, $question->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="text">Question Text</label>
                            <input type="text" name="text" class="form-control" value="{{ $question->text }}" required>
                        </div>

                        <div class="form-group">
                            <label for="option_type">Option Type (Optional)</label>
                            <select name="option_type_id" class="form-control">
                                <option value="">Select Option Type</option>
                                {{-- @foreach($optionTypes as $optionType)
                                    <option value="{{ $optionType->id }}" {{ $question->option_type_id == $optionType->id ? 'selected' : '' }}>
                                        {{ $optionType->name }} --}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="group_id">Group</label>
                            @foreach($groups as $group)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_id" value="{{ $group->id }}" id="group{{ $group->id }}" {{ isset($question) && $question->group_id == $group->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="group{{ $group->id }}">
                                        {{ $group->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>


                        <div class="form-group">
                            <label for="options">Options (Optional)</label>
                            <div id="options-container">
                                @foreach($question->options as $index => $option)
                                    <div class="option-item">
                                        <input type="text" name="options[{{ $index }}][label]" value="{{ $option->label }}" placeholder="Label" class="form-control mb-2">
                                        <input type="number" name="options[{{ $index }}][value]" value="{{ $option->value }}" placeholder="Value" class="form-control mb-2">
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-option" class="btn btn-secondary mt-2">Add Option</button>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-option').addEventListener('click', function() {
        const container = document.getElementById('options-container');
        const index = container.getElementsByClassName('option-item').length;
        const optionItem = document.createElement('div');
        optionItem.className = 'option-item';
        optionItem.innerHTML = `
            <input type="text" name="options[${index}][label]" placeholder="Label" class="form-control mb-2">
            <input type="number" name="options[${index}][value]" placeholder="Value" class="form-control mb-2">
        `;
        container.appendChild(optionItem);
    });
</script>
@endsection
