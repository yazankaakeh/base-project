@extends('theme::user.layouts.horizontalLayout')

@section('title', 'Add New Knowledge')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-3xl font-bold mb-6">Add New Knowledge</h1>

        <form action="{{ route('mcp.knowledge.store') }}" method="POST"
              class="bg-body rounded-lg shadow p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-core::input
                        label="Category"
                        type="text"
                        name="category"
                        id="category"
                        required="required"
                        value="{{ old('category') }}">
                    </x-core::input>
                </div>

                <div>
                    <x-core::input
                        label="Subcategory"
                        type="text"
                        name="subcategory"
                        id="subcategory"
                        value="{{ old('subcategory') }}">
                    </x-core::input>
                </div>
            </div>

            <div>
                <x-core::input
                    label="Question (English)"
                    type="text"
                    name="question[en]"
                    id="question_en"
                    required="required"
                    value="{{ old('question.en') }}">
                </x-core::input>
            </div>

            <div>
                <x-core::input
                    label="Question (Arabic)"
                    type="text"
                    name="question[ar]"
                    id="question_ar"
                    class="rtl"
                    value="{{ old('question.ar') }}">
                </x-core::input>
            </div>

            <div>
                <x-core::textarea
                    label="Answer (English)"
                    name="answer[en]"
                    id="answer_en"
                    rows="5"
                    required="required"
                    value="{{ old('answer.en') }}">
                </x-core::textarea>
            </div>

            <div>
                <x-core::textarea
                    label="Answer (Arabic)"
                    name="answer[ar]"
                    id="answer_ar"
                    rows="5"
                    class="rtl"
                    value="{{ old('answer.ar') }}">
                </x-core::textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-core::input
                        label="Priority (0-100)"
                        type="number"
                        name="priority"
                        id="priority"
                        min="0"
                        max="100"
                        value="{{ old('priority', 50) }}">
                    </x-core::input>
                </div>

                <div>
                    <x-core::select
                        :label="'Status'"
                        name="is_active"
                        id="is_active"
                        :options="[1 => 'Active', 0 => 'Inactive']"
                        value="{{ old('is_active', 1) }}">
                    </x-core::select>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-body px-6 py-2 rounded">Save</button>
                <a href="{{ route('mcp.knowledge.index') }}" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
@endsection
