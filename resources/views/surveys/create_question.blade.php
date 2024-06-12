@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($question) ? 'Edit' : 'Create' }} Question</div>

                <div class="card-body">
                    <form method="POST" action="{{ isset($question) ? route('surveys.questions.update', [$survey->slug, $question->id]) : route('surveys.questions.store', $survey->slug) }}">
                        @csrf
                        @if(isset($question))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="text">Question Text</label>
                            <input type="text" name="text" class="form-control" value="{{ old('text', isset($question) ? $question->text : '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="option_type">Option Type (Optional)</label>
                            <select name="option_type_id" class="form-control">
                                <option value="">Select Option Type</option>
                                @foreach($optionTypes as $optionType)
                                    <option value="{{ $optionType->id }}" {{ old('option_type_id', isset($question) ? $question->option_type_id : '') == $optionType->id ? 'selected' : '' }}>
                                        {{ $optionType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="group_id">Group</label>
                            @foreach($groups as $group)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_id" value="{{ $group->id }}" id="group{{ $group->id }}" {{ old('group_id', isset($question) ? $question->group_id : '') == $group->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="group{{ $group->id }}">
                                        {{ $group->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="options">Options (Optional)</label>
                            <div id="options-container">
                                @if(isset($question) && $question->options->isNotEmpty())
                                    @foreach($question->options as $index => $option)
                                        <div class="option-item">
                                            <input type="text" name="options[{{ $index }}][label]" value="{{ old('options.'.$index.'.label', $option->label) }}" placeholder="Label" class="form-control mb-2">
                                            <input type="number" name="options[{{ $index }}][value]" value="{{ old('options.'.$index.'.value', $option->value) }}" placeholder="Value" class="form-control mb-2">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="option-item">
                                        <input type="text" name="options[0][label]" placeholder="Label" class="form-control mb-2">
                                        <input type="number" name="options[0][value]" placeholder="Value" class="form-control mb-2">
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-option" class="btn btn-secondary mt-2">Add Option</button>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">{{ isset($question) ? 'Update' : 'Create' }} Question</button>
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
