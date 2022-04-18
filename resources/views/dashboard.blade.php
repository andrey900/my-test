<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl mb-4">You api tokens</h3>
                    <ul class="mb-4">
                        @foreach($tokens as $token)
                        <li>
                            <span>{{ $token->name }}: <b>{{ $token->token }}</b></span>
                            <form method="POST" action="{{ route('token.delete', ['id' => $token->id]) }}">
                                @method('delete')
                                <x-button class="text-xs">delete</x-button>
                            </form>
                        </li>
                        @endforeach
                    </ul>

                    <form method="POST" action="{{ route('token.create') }}">
                        @csrf
                        <input type="hidden" name="token_name" value="api">
                        <x-button class="ml-3">Generate api token</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
