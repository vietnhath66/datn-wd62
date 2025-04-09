<form action="{{ route('admin.product_catalogue.index') }}">
    <div class="filter-wrapper">
        <div class="row">
            @include('admin.dashboard.components.perpage')
            <div class="action col-sm-8">
                <div class="row d-flex">
                    @include('admin.dashboard.components.filterPublish')
                    @include('admin.dashboard.components.keyword')
                    <div class="col-sm-2">
                        <a href="{{ route('admin.product_catalogue.create') }}" class="btn btn-danger"><i
                                class="fa fa-plus mr5"></i>{{ __('messages.productCatalogue.create.title') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
