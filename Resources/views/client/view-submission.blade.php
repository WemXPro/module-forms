@extends(Theme::wrapper())
@section('title', 'Tickets')

{{-- Keywords for search engines --}}
@section('keywords', 'WemX Dashboard, WemX Panel')

@section('header')
    <link rel="stylesheet" href="{{ Theme::get('Default')->assets }}assets/css/typography.min.css">
@endsection

@section('container')
<header class="mb-4 lg:mb-6 not-format">
   <h1 class="mb-4 text-2xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{ $submission->form->title }}</h1>
   <div class="flex items-center mb-4">
        <svg class="mr-2 w-3 h-3 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"></path></svg>
        <time class="font-normal text-gray-500 dark:text-gray-400" pubdate="" datetime="2022-03-08" title="August 3rd, 2022">{{ $submission->created_at->format(settings('date_format', 'd M Y')) }}</time>
    </div>
   <div class="flex justify-between items-center py-6 mb-6 border-t border-b border-gray-200 dark:border-gray-700 not-format">
    <span class="text-sm font-bold text-gray-900 lg:mb-0 dark:text-white">5 Posts</span>
    <div class="flex items-center">
        <span class="mr-2 text-xs font-semibold text-gray-900 uppercase dark:text-white">Sort by</span>
        <button id="dropdownSortingButton" data-dropdown-toggle="dropdownSorting" class="flex items-center py-1 px-2 text-sm font-medium text-gray-500 rounded-full hover:text-primary-600 dark:hover:text-primary-500 md:mr-0 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400" type="button">
            <span class="sr-only">Open user menu</span>
            <svg class="ml-1.5 w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"></path></svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownSorting" class="z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 hidden" data-popper-placement="bottom" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(862px, 363px);">
            <ul class="py-1 text-sm list-none text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                <li>
                    <a href="$" class="block py-2 px-4 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Latest</a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Oldest</a>
                </li>
            </ul>
        </div> 
    </div>
</div>
</header>

<div class="flex flex-wrap mt-6">
    <div class="w-3/4 md:w-3/4 pr-4 pl-4 sm:w-full pr-4 pl-4 mb-8">

        <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                @foreach($submission->data as $key => $value)
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">{{ $key }}</dt>
                    <dd class="text-lg font-semibold">{{ $value }}</dd>
                </div>
                @endforeach
            </dl>
        </div>        

        <form id="comment-form" action="#" method="POST">
            @csrf
            @includeIf(Theme::moduleView('tickets', 'components.editor'))
            <div class="sm:col-span-2 mb-6">
                <textarea name="message" id="message" rows="3"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{old('description')}}</textarea>
            </div>
            <div class="text-right mb-4">
                <button type="submit" id="post_comment" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Comment</button>
            </div>
        </form>

    </div>
    <div class="w-1/3 md:w-1/4 pr-4 pl-4 sm:w-full pr-4 pl-4">

        <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700 mb-4">
            <div class="flex flex-col pb-3">
                <dt class="mb-1 text-gray-500 md:text-md dark:text-gray-400 mb-2">Members</dt>
                <dd class="text-lg font-semibold flex gap-1">
                    @if($submission->user)
                        <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800" src="{{ $submission->user->avatar() }}" alt="">
                    @else
                        <div class="relative inline-flex border border-gray-500 items-center justify-center mt-0.5 w-9 h-9 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                            <span class="font-medium text-gray-600 dark:text-gray-300">{{ substr($submission->email(), 0, 2) }}</span>
                        </div>
                    @endif
                </dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-md dark:text-gray-400">Status</dt>
                <dd class="text-lg font-semibold">
                    {{ $submission->status }}
                </dd>
            </div>
            <div class="flex flex-col pt-3">
                <dt class="mb-1 text-gray-500 md:text-md dark:text-gray-400">Created</dt>
                <dd class="text-lg font-semibold">{{ $submission->created_at->format(settings('date_format', 'd M Y')) }}</dd>
            </div>
        </dl>

        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">

        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Actions</h2>
        <ul class="max-w-md space-y-2 text-gray-500 list-inside dark:text-gray-400">
            <li class="flex items-center mb-2 hover:underline hover:cursor-pointer" data-drawer-target="drawer-right-update-ticket" data-drawer-show="drawer-right-update-ticket" data-drawer-placement="right" aria-controls="drawer-right-update-ticket">
                <span class="text-gray-500 dark:text-gray-400 flex-shrink-0 mr-1">
                    <i class='bx bxs-comment-edit'></i>
                </span>
               Update Ticket
           </li>
            <li class="flex items-center mb-2">
                <a href="#" class="hover:underline hover:cursor-pointer">
                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">
                        <i class='bx bx-block' ></i>
                    </span>
                    Open
                </a>
           </li>
            @if(auth()->user()->is_admin())
            <li class="flex items-center mb-2">
                <a href="#" target="_blank" class="hover:underline hover:cursor-pointer">
                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">
                        <i class='bx bxs-user' ></i>
                    </span>
                    View Profile
                </a>
            </li>
            <li class="flex items-center mb-2">
                <a href="#" class="hover:underline hover:cursor-pointer">
                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">
                        <i class='bx bxs-trash' ></i>
                    </span>
                    Delete Submission
                </a>
            </li>
            @endif
        </ul>

    </div>
</div>

@endsection