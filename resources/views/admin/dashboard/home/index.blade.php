<style>
    .revenue-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-end;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .revenue-form .form-group {
        display: flex;
        flex-direction: column;
    }

    .revenue-form label {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .revenue-form input[type="month"] {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .revenue-form button {
        padding: 8px 16px;
        border: none;
        background-color: #007bff;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .revenue-form button:hover {
        background-color: #0056b3;
    }

    .revenue-summary {
        padding-bottom: 10px;
        font-size: 18px;
        padding: 10px;
        background-color: #e9f7ef;
        border-left: 4px solid #28a745;
        border-radius: 5px;
        color: #155724;
    }

    .revenue-canceled {
        font-size: 18px;
        padding: 10px;
        background-color: #e2d7d8;
        border-left: 4px solid #e0224b;
        border-radius: 5px;
        color: #d31b1b;
    }

    .revenue-order {
        font-size: 18px;
        padding: 10px;
        background-color: #e9e9f7;
        border-left: 4px solid #2e85e9;
        border-radius: 5px;
        color: #1d4fac;
    }
</style>
<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Ecommerce</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">Ecommerce</li>
                </ul>
            </div>
            <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
                <div class="relative col-span-12 overflow-hidden card 2xl:col-span-8 bg-slate-900">
                    <div class="absolute inset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-100" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs"
                            width="1440" height="560" preserveaspectratio="none" viewbox="0 0 1440 560">
                            <g mask='url("#SvgjsMask1000")' fill="none">
                                <use xlink:href="#SvgjsSymbol1007" x="0" y="0"></use>
                                <use xlink:href="#SvgjsSymbol1007" x="720" y="0"></use>
                            </g>
                            <defs>
                                <mask id="SvgjsMask1000">
                                    <rect width="1440" height="560" fill="#ffffff"></rect>
                                </mask>
                                <path d="M-1 0 a1 1 0 1 0 2 0 a1 1 0 1 0 -2 0z" id="SvgjsPath1003"></path>
                                <path d="M-3 0 a3 3 0 1 0 6 0 a3 3 0 1 0 -6 0z" id="SvgjsPath1004"></path>
                                <path d="M-5 0 a5 5 0 1 0 10 0 a5 5 0 1 0 -10 0z" id="SvgjsPath1001"></path>
                                <path d="M2 -2 L-2 2z" id="SvgjsPath1005"></path>
                                <path d="M6 -6 L-6 6z" id="SvgjsPath1002"></path>
                                <path d="M30 -30 L-30 30z" id="SvgjsPath1006"></path>
                            </defs>
                            <symbol id="SvgjsSymbol1007">
                                <use xlink:href="#SvgjsPath1001" x="30" y="30" stroke="rgba(32, 43, 61, 1)"></use>
                                <use xlink:href="#SvgjsPath1002" x="30" y="90" stroke="rgba(32, 43, 61, 1)"></use>
                                <use xlink:href="#SvgjsPath1001" x="30" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="30" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="30" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="30" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="30" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="30" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="30" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="30" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="90" y="30" stroke="rgba(32, 43, 61, 1)"></use>
                                <use xlink:href="#SvgjsPath1003" x="90" y="90" stroke="rgba(32, 43, 61, 1)"></use>
                                <use xlink:href="#SvgjsPath1001" x="90" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="90" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1004" x="90" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="90" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="90" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="90" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="90" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="90" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="150" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="150" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="150" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="150" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="150" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="150" y="330" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1004" x="150" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="150" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="150" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="150" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="210" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="210" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="210" y="150" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="210" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="210" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="210" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="210" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="210" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="210" y="510" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="210" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="270" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="270" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="270" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="270" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="270" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="270" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="270" y="390" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="270" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="270" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="270" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="330" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="330" y="90" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3"></use>
                                <use xlink:href="#SvgjsPath1002" x="330" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="330" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="330" y="270" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="330" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="330" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="330" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="330" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="330" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1004" x="390" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="390" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="390" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="390" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="390" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="390" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="390" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="390" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="390" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="390" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="450" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1004" x="450" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="450" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="450" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="450" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="450" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="450" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="450" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="450" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="450" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="510" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="510" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="510" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="510" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="510" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1004" x="510" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="510" y="390" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="510" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="510" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="510" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="570" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="570" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="570" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="570" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="570" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="570" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="570" y="390" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="570" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="570" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="570" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="630" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="630" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="630" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="630" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="630" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="630" y="330" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="630" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="630" y="450" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="630" y="510" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="630" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="690" y="30" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="690" y="90" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="690" y="150" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1002" x="690" y="210" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1005" x="690" y="270" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1001" x="690" y="330" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="690" y="390" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="690" y="450" stroke="rgba(32, 43, 61, 1)">
                                </use>
                                <use xlink:href="#SvgjsPath1006" x="690" y="510" stroke="rgba(32, 43, 61, 1)"
                                    stroke-width="3">
                                </use>
                                <use xlink:href="#SvgjsPath1003" x="690" y="570" stroke="rgba(32, 43, 61, 1)">
                                </use>
                            </symbol>
                        </svg>
                    </div>
                    <div class="relative card-body">
                        <div class="grid items-center grid-cols-12">
                            <div class="col-span-12 lg:col-span-8 2xl:col-span-7">
                                <h5 class="mb-3 font-normal tracking-wide text-slate-200">
                                    Welcome StarCode Kh 🎉
                                </h5>
                                <p class="mb-5 text-slate-400">
                                    An e-commerce dashboard has just that purpose. It
                                    provides your e-commerce team with a clear overview of
                                    key financial and website KPIs at any time.
                                </p>
                                <button type="button"
                                    class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-500/20 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-500/20 dark:ring-custom-400/20">
                                    Take a Product
                                </button>
                            </div>
                            <div
                                class="hidden col-span-12 2xl:col-span-3 lg:col-span-2 lg:col-start-11 2xl:col-start-10 lg:block">
                                <img src="images/dashboard.png" alt=""
                                    class="h-40 ltr:2xl:ml-auto rtl:2xl:mr-auto" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                {{-- <div class="col-span-12 card 2xl:col-span-4 2xl:row-span-2">
                    <div class="card-body">
                        <div class="flex items-center mb-3">
                            <h6 class="grow text-15">Order Statistics</h6>
                            <div class="relative">
                                <a href="#!"
                                    class="underline transition-all duration-200 ease-linear text-custom-500 hover:text-custom-600">View
                                    All
                                    <i data-lucide="move-right"
                                        class="inline-block align-middle size-4 ltr:ml-1 rtl:mr-1"></i></a>
                            </div>
                        </div>
                        <div id="orderStatisticsChart" class="apex-charts"
                            data-chart-colors='["bg-purple-500", "bg-sky-500"]' dir="ltr"></div>
                    </div>
                </div> --}}
                <!--end col-->
                {{-- <div class="col-span-12 card md:col-span-6 lg:col-span-3 2xl:col-span-2">
                    <div class="text-center card-body">
                        <div
                            class="flex items-center justify-center mx-auto rounded-full size-14 bg-custom-100 text-custom-500 dark:bg-custom-500/20">
                            <i data-lucide="wallet-2"></i>
                        </div>
                        <h5 class="mt-4 mb-2">
                            <span class="counter-value" data-target="{{ $orderStatistic['revenueOrders'] }}"></span>
                            vnđ
                        </h5>
                        <p class="text-slate-500 dark:text-zink-200">Tổng Doanh Thu</p>
                        
                    </div>
                </div> --}}
                <!--end col-->
                <div class="col-span-12 card md:col-span-6 lg:col-span-3 2xl:col-span-2">
                    <div class="text-center card-body">
                        <div
                            class="flex items-center justify-center mx-auto text-purple-500 bg-purple-100 rounded-full size-14 dark:bg-purple-500/20">
                            <i data-lucide="wallet-2"></i>
                        </div>
                        <h5 class="mt-4 mb-2">
                            <span class="counter-value"
                                data-target="{{ $orderStatistic['revenueCurrentMonthTotal'] }}"> </span> VNĐ
                        </h5>
                        <p class="text-slate-500 dark:text-zink-200">Doanh thu tháng này</p>
                        <p class="text-slate-500 dark:text-zink-200">({{ $orderStatistic['revenueCurrentMonthOrder'] }}
                            đơn)</p>
                    </div>
                </div>
                <!--end col-->
                <div class="col-span-12 card md:col-span-6 lg:col-span-3 2xl:col-span-2">
                    <div class="text-center card-body">
                        <div
                            class="flex items-center justify-center mx-auto text-green-500 bg-green-100 rounded-full size-14 dark:bg-green-500/20">
                            <i data-lucide="truck"></i>
                        </div>
                        <h5 class="mt-4 mb-2">
                            <span class="counter-value"
                                data-target="{{ $orderStatistic['getTotalAndOrderLastMonth']->total_revenue }}">0</span>
                        </h5>
                        <p></p>
                        <p class="text-slate-500 dark:text-zink-200">Doanh thu tháng trước</p>
                        <p class="text-slate-500 dark:text-zink-200">
                            ({{ $orderStatistic['getTotalAndOrderLastMonth']->total_orders }} đơn)</p>
                    </div>
                </div>
                <!--end col-->
                {{-- <div class="col-span-12 card md:col-span-6 lg:col-span-3 2xl:col-span-2">
                    <div class="text-center card-body">
                        <div
                            class="flex items-center justify-center mx-auto text-red-500 bg-red-100 rounded-full size-14 dark:bg-red-500/20">
                            <i data-lucide="package-x"></i>
                        </div>
                        <h5 class="mt-4 mb-2">
                            <span class="counter-value"
                                data-target="{{ $orderStatistic['totalCancelOrders'] }}">0</span>
                        </h5>
                        <p class="text-slate-500 dark:text-zink-200">Đơn hàng đã hủy</p>
                    </div>
                </div> --}}
                <!--end col-->
                <div class="col-span-12 card 2xl:col-span-10">
                    <div class="card-body">
                        <canvas id="barChart" height="100"></canvas>
                    </div>
                </div>
                <!--end col-->
                <div class="col-span-12 2xl:col-span-2">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 card lg:col-span-6 2xl:col-span-12">
                            <div class="card-body">
                                <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                                    <div class="xl:col-span-4">

                                        <button type="button" style="width:150px"
                                            class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear  rounded-md text-slate-500 dark:text-zink-200 border border-transparent [&.active]:bg-custom-500 dar:[&.active]:bg-custom-500 [&.active]:text-white dark:[&.active]:text-white hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px] chartButton"
                                            data-chart="1">Biểu đồ năm</button>
                                        <button type="button" style="width:150px"
                                            class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-md text-slate-500 dark:text-zink-200 border border-transparent [&.active]:bg-custom-500 dar:[&.active]:bg-custom-500 [&.active]:text-white dark:[&.active]:text-white hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px] chartButton"
                                            data-chart="30">Tháng hiện tại</button>
                                        <button type="button" style="width:150px"
                                            class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-md text-slate-500 dark:text-zink-200 border border-transparent [&.active]:bg-custom-500 dar:[&.active]:bg-custom-500 [&.active]:text-white dark:[&.active]:text-white hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px] chartButton"
                                            data-chart="7">7 ngày gần nhất</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @dd($orderStatistic['revenueChartMonth']) --}}

                        <!--end col-->

                        <!--end col-->
                    </div>
                    <!--end grid-->
                </div>

                <div class="col-span-12 card lg:col-span-12 2xl:col-span-12">
                    <div class="card-body">
                        <form method="GET" class="revenue-form">
                            <div class="form-group">
                                <label for="month">Chọn tháng:</label>
                                <input type="month" id="month" name="month"
                                    value="{{ $orderStatistic['revenueChartMonth']['selectedMonth'] }}">
                            </div>
                            <button type="submit">Xem</button>
                        </form>

                        <p class="revenue-summary">
                            Tổng doanh thu tháng này:
                            <strong>{{ number_format($orderStatistic['revenueChartMonth']['totalRevenue'], 0, ',', '.'), 'VNĐ' }}
                            </strong> VNĐ
                        </p>
                        <p class="revenue-order">
                            Số đơn hàng tháng này:
                            <strong> {{ $orderStatistic['revenueChartMonth']['totalOrdersMoth'] }}</strong>
                        </p>
                        <p class="revenue-canceled">
                            Tổng số đơn hàng hủy tháng này:
                            <strong> {{ $orderStatistic['revenueChartMonth']['cancelledOrdersMoth'] }}</strong>
                        </p>

                        @if (isset($orderStatistic['revenueChartMonth']['currentRevenue']))
                            {{-- <h3>Doanh số tháng {{ \Carbon\Carbon::parse($orderStatistic['revenueChartMonth'])->format('m/Y') }}: {{ number_format($orderStatistic['revenueChartMonth']['currentRevenue']) }} VNĐ</h3> --}}
                        @endif

                        <canvas id="revenueChart" height="100"></canvas>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            const ctx = document.getElementById('revenueChart').getContext('2d');
                            const revenueChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: @json($orderStatistic['revenueChartMonth']['chartLabels']),
                                    datasets: [{
                                        label: 'Doanh số theo tháng',
                                        data: @json($orderStatistic['revenueChartMonth']['chartData']),
                                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>


                    <!--end col-->
                </div>
                <!--end grid-->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    </div>
