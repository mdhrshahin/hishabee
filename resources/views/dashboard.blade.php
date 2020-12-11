<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quotes') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gray-100" style="min-height:70vh">
        <div class="w-full sm:max-w-4xl  px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @if(session()->has('status'))
                {!! session()->get('status') !!}
            @endif
            <form action="{{ route('quote.add') }}" method="post">
                @csrf
                <div class="m-3">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="text" value="{{ __('Text') }}"/>
                        <textarea name="text" class="form-textarea mt-1 block w-full"
                                  placeholder="Write text"></textarea>
                        <x-jet-input-error for="text" class="mt-2"/>
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-jet-button>
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
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Text</th>
                            <th class="border border-emerald-500 px-4 py-2 text-emerald-600">Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($quotes as $quote)
                            <tr>
                                <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ $loop->iteration }}</td>
                                <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">{{ (strlen($quote->text) >60) ? substr($quote->text,0, 60).'...' : $quote->text }}</td>
                                <td class="border border-emerald-500 px-4 py-2 text-emerald-600 font-medium">
                                    <x-jet-button class="bg-green-600 edit-quote" data-id="{{ $quote->id }}"
                                                  data-text="{{ $quote->text }}">
                                        {{ __('Edit') }}
                                    </x-jet-button>
                                    <x-jet-button class="bg-red-500 delete-quote" data-id="{{ $quote->id }}">
                                        {{ __('Remove') }}
                                    </x-jet-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form action="{{ route('quote.edit') }}" method="post">
                    @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Quote edit
                            </h3>
                            <div class="mt-2">
                                <input type="hidden" id="editQuoteId" name="id">
                                <textarea name="text" id="editQuoteText" class="form-textarea mt-1 block" style="min-width: 27rem; height: 300px;"
                                          placeholder="Write text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4
                            py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2
                            focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" id="editQuoteClose"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function () {
        $(document).ready(function () {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        })
        $('#editQuoteClose').click(function () {
          $('#editModal').addClass('hidden');
        })

        $(document).on('click', '.edit-quote', function () {
          const id = $(this).data('id');
          const text = $(this).data('text');
          $('#editQuoteId').val(id);
          $('#editQuoteText').val(text);
          $('#editModal').removeClass('hidden');
        })

        $(document).on('click', '.delete-quote', function () {
          const pid = $(this).data('id');
          const $this = $(this);

          $.ajax({
            url: "{{ route('quote.delete') }}",
            method: "delete",
            dataType: "html",
            data: {id: pid},
            success: function (data) {
              if (data === "success") {
                $this.closest('tr').css('background-color', 'red').fadeOut();
              }
            }
          });
        })
      })
    </script>
</x-app-layout>
