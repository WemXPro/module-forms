@extends(Theme::wrapper(), ['title' => $form->title, 'keywords' => 'WemX Dashboard, WemX Panel'])
@section('title', $form->title)
@section('keywords', 'WemX Dashboard, WemX Panel')

@section('container')
    <section class="bg-white dark:bg-gray-900">
        <div>
            <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $form->title }}</h2>
            <p class="font-light text-gray-500 dark:text-gray-400 sm:text-xl">{{ $form->description }}</p>
        </div>
    </section>
@endsection