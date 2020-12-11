<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Quote') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gray-100" style="min-height:70vh">
        <div class="w-full sm:max-w-4xl  px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form action="{{ route('quote.add') }}" method="post">
                @csrf
                <div class="m-3">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="text" value="{{ __('Text') }}"/>
                        <textarea name="biography" class="form-textarea mt-1 block w-full"
                                  placeholder="Write text"></textarea>
                        <x-jet-input-error for="text" class="mt-2"/>
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-jet-button type="submit">
                        {{ __('Share') }}
                    </x-jet-button>
                </div>
            </form>
            <div class="relative overflow-hidden mb-8">
                <div class="rounded-t-xl overflow-hidden bg-gradient-to-r from-emerald-50 to-teal-100 p-10">
                    <table class="table-fixed">
                        <thead>
                        <tr>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Index</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Author</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Text</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">A Long and
                                Winding Tour
                            </td>
                            <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">Adam</td>
                            <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">112</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
