@include('admin.dashboard.components.breadcrumb',['title' => $config['seo']['index']['title']])

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row mt20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $config['seo']['index']['table'] }}</h5>
                   {{-- @include('admin.dashboard.components.toolbox', ['model' => 'Post'])  --}}
                </div>
                <div class="ibox-content">
                    
                    @include('admin.orders.components.tableshow', ['tableshow' => $config['seo']['index']['show']])
                </div>
            </div>
        </div>
    </div>
</div>

