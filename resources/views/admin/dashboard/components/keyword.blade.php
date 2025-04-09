<div class="xl:col-span-3">
    <div class="relative">
        <input 
            type="text" 
            name="keyword" 
            value="{{ request('keyword') ?: old('keyword') }}"
            placeholder="Nhập Từ khóa bạn muốn tìm kiếm ..." 
            {{-- type="text" --}}
            class="ltr:pl-8 rtl:pr-8 search form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
            {{-- placeholder="Tìm kiếm..."  --}}
            autocomplete="off"
            >
            <button type="submit" name="search" value="search"
            class="btn btn-primary mb10 btn-sm"><i data-lucide="search"
            class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i></button>
        
    </div>
</div><!--end col-->
