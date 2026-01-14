@extends('theme::user.layouts.horizontalLayout')

@section('title', 'Knowledge Base Management')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Knowledge Base Management</h1>
            <a href="{{ route('mcp.knowledge.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-body px-4 py-2 rounded-lg">
                Add New Knowledge
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-body rounded-lg shadow p-4 mb-6">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <x-core::input
                        type="text"
                        name="search"
                        id="search"
                        placeholder="Search..."
                        value="{{ $filters['search'] ?? '' }}">
                    </x-core::input>
                </div>
                <div>
                    <x-core::select
                        name="category"
                        id="category"
                        :options="['' => 'All Categories', 'general' => 'General', 'medical' => 'Medical', 'appointments' => 'Appointments']"
                        value="{{ $filters['category'] ?? '' }}">
                    </x-core::select>
                </div>
                <div>
                    <x-core::select
                        name="is_active"
                        id="is_active"
                        :options="['' => 'All Status', '1' => 'Active', '0' => 'Inactive']"
                        value="{{ $filters['is_active'] ?? '' }}">
                    </x-core::select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-body px-6 py-2 rounded">Filter</button>
            </form>
        </div>

        <!-- Knowledge List -->
        <div class="bg-body rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Question</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($knowledge as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->category }}</td>
                        <td class="px-6 py-4 text-sm">{{ Str::limit($item->getTranslation('question', 'en'), 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->priority }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->usage_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 rounded text-xs {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('mcp.knowledge.edit', $item->id) }}"
                               class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('mcp.knowledge.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('Are you sure?')">Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No knowledge found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $knowledge->links() }}
        </div>
    </div>
@endsection
