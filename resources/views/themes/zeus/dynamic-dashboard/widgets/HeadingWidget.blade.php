<div class="space-y-3 bg-white dark:bg-black shadow my-10 py-3 px-4 hover:shadow-lg transition-all ease-in-out duration-500 ltr:rounded-tr-none rtl:rounded-tl-none rounded-3xl border border-primary-100 dark:border-primary-700/50">

<div class="p-4 prose lg:prose-xl prose-primary dark:prose-invert">
    {!! str($data['content'])->markdown() !!}
</div>
</div>
