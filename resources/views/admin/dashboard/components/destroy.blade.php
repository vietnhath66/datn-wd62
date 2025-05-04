@csrf
@method('DELETE')
<div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-12">
    <div class="xl:col-span-6">
        <label for="productNameInput"
            class="inline-block mb-2 text-base font-medium">Tên {{ $title }}</label>
        <input type="text" id="productNameInput"
            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
            placeholder="Product title" required="" name="name"
            value="{{ old('name', $model->name ?? '') }}"  disabled/>
    </div>
</div>
<!--end grid-->
<div class="flex justify-end gap-2 mt-4">
    <button type="submit"
        class="text-red-500 bg-white btn hover:text-red-500 hover:bg-red-100 focus:text-red-500 focus:bg-red-100 active:text-red-500 active:bg-red-100 dark:bg-zink-700 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 dark:active:bg-red-500/10">
        Xóa
    </button>
</div>