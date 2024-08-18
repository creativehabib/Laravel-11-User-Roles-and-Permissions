<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Articles List') }}
            </h2>
            @can('create article')
            <a href="{{route('articles.create')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message/>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" width="60" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3">Body</th>
                            <th scope="col" class="px-6 py-3">Author</th>
                            <th scope="col" class="px-6 py-3" width="220">
                                Created
                            </th>
                            <th scope="col" class="px-6 py-3 text-center" width="180">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($articles->isNotEmpty())
                            @foreach($articles as $article)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$article->title}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$article->body}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$article->user->name}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $article->created_at->toDayDateTimeString() }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @can('edit article')
                                            <a href="{{route('articles.edit',$article->id)}}" class="bg-slate-700 text-sm rounded-md text-gray-600 px-3 py-2 hover:bg-slate-600 dark:text-slate-200">Edit</a>
                                        @endcan

                                        @can('delete article')
                                            <a href="javascript:void(0);" onclick="deleteArticle({{$article->id}})" class="bg-red-700 text-sm rounded-md text-gray-600 px-3 py-2 hover:bg-red-600 dark:text-slate-200">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @elseif($articles->isEmpty())
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="5" class="text-red-700 font-medium text-center px-6 py-4">No Data Found</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>

                </div>

            </div>
            <div class="my-3">
                {{$articles->links()}}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteArticle(id){
                if(confirm('Are you sure you want to delete?')){
                    $.ajax({
                        url: '{{route('articles.destroy')}}',
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers:{
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function (response){
                            window.location.href = '{{route('articles.index')}}'
                        }

                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>
