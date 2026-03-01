<?php

namespace App\Helpers;

use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DataTableHelper
{
    /**
     * Build the DataTable instance.
     *
     * @param DataTable $instance DataTable instance
     * @param string $tableId Table ID
     * @return HtmlBuilder DataTable HTML builder
     */
    public static function builder(DataTable $instance, string $tableId): HtmlBuilder
    {
        $csrf = csrf_token();
        $login_url = route('auth.login');
        return $instance->builder()
            ->setTableId($tableId)
            ->columns($instance->getColumns())
            ->minifiedAjax()
            ->parameters([
                'drawCallback' => <<<JS
                    function() {
                        // Select all checkbox
                        const datatableCounterInfo = $('#datatableCounterInfo');
                        const datatableCounter = $('#datatableCounter');
                        const datatable = this.api();

                        datatableCounterInfo.addClass('d-none');

                        // DataTable Entries
                        const datatableEntries = $('#datatableEntries');

                        datatableEntries.on('change', function() {
                            const value = $(this).val();
                            if (value == -1) {
                                datatable.page.len(datatable.page.info().recordsTotal).draw();
                            } else {
                                datatable.page.len(value).draw();
                            }
                        });

                        const datatableWithPaginationInfoTotalQty = $('#datatableWithPaginationInfoTotalQty');
                        const totalQty = this.api().page.info().recordsTotal;
                        datatableWithPaginationInfoTotalQty.text(totalQty);

                        // Get total pages
                        const totalPages = this.api().page.info().pages;

                        // Get current page
                        const currentPage = this.api().page.info().page + 1;

                        // build paging navigation
                        const paging = document.querySelector('#datatablePagination');

                        // clear paging navigation
                        paging.innerHTML = '';

                        const pagingNav = document.createElement('div');
                        pagingNav.classList.add('dataTables_paginate', 'paging_simple_numbers');
                        pagingNav.id = 'datatable_paginate';
                        paging.appendChild(pagingNav);

                        const pagingNavList = document.createElement('ul');
                        pagingNavList.classList.add('pagination', 'datatable-custom-pagination');
                        pagingNavList.id = 'datatable_pagination';
                        pagingNav.appendChild(pagingNavList);

                        const pagingNavPrev = document.createElement('li');
                        pagingNavPrev.classList.add('paginate_button', 'page-item');
                        if (currentPage === 1) {
                            pagingNavPrev.classList.add('disabled');
                        }
                        const prevLink = document.createElement('a');
                        prevLink.classList.add('page-link', 'paginate_button', 'previous');
                        prevLink.setAttribute('aria-controls', 'datatable');
                        prevLink.id = 'datatable_previous';
                        prevLink.innerHTML = '<span aria-hidden="true"><i class="ti ti-arrow-narrow-left"/></span>';
                        pagingNavPrev.appendChild(prevLink);
                        pagingNavList.appendChild(pagingNavPrev);

                        // loop through all pages and add page number, or ellipsis if needed (show max 5 pages)
                        for (let i = 1; i <= totalPages; i++) {
                            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                                const pagingNavPage = document.createElement('li');
                                pagingNavPage.classList.add('paginate_button', 'page-item');
                                if (i === currentPage) {
                                    pagingNavPage.classList.add('active');
                                }
                                const pageLink = document.createElement('a');
                                pageLink.classList.add('page-link', 'paginate_button');
                                pageLink.setAttribute('aria-controls', 'datatable');
                                pageLink.innerHTML = i;
                                pagingNavPage.appendChild(pageLink);
                                pagingNavList.appendChild(pagingNavPage);
                            } else if (i === currentPage - 3 || i === currentPage + 3) {
                                const pagingNavEllipsis = document.createElement('li');
                                pagingNavEllipsis.classList.add('paginate_button', 'page-item', 'disabled');
                                const ellipsisLink = document.createElement('a');
                                ellipsisLink.classList.add('page-link', 'paginate_button');
                                ellipsisLink.setAttribute('aria-controls', 'datatable');
                                ellipsisLink.innerHTML = '...';
                                pagingNavEllipsis.appendChild(ellipsisLink);
                                pagingNavList.appendChild(pagingNavEllipsis);
                            }
                        }

                        const pagingNavNext = document.createElement('li');
                        pagingNavNext.classList.add('paginate_button', 'page-item');
                        if (currentPage === totalPages) {
                            pagingNavNext.classList.add('disabled');
                        }
                        const nextLink = document.createElement('a');
                        nextLink.classList.add('page-link', 'paginate_button', 'next');
                        nextLink.setAttribute('aria-controls', 'datatable');
                        nextLink.id = 'datatable_next';
                        nextLink.innerHTML = '<span aria-hidden="true"><i class="ti ti-arrow-right"/></span>';
                        pagingNavNext.appendChild(nextLink);
                        pagingNavList.appendChild(pagingNavNext);

                        // change page if page number is clicked
                        const pagingNavLinks = document.querySelectorAll('#datatable_pagination .page-link');
                        for (const pagingNavLink of pagingNavLinks) {
                            pagingNavLink.addEventListener('click', function () {
                                if (this.classList.contains('previous')) {
                                    datatable.page('previous').draw('page');
                                } else if (this.classList.contains('next')) {
                                    datatable.page('next').draw('page');
                                } else {
                                    const page = this.innerHTML;
                                    datatable.page(page - 1).draw('page');
                                }
                            });
                        }
                        // enable tooltip
                        const tooltipTriggerList = document.querySelectorAll('[data-popup="tooltip-custom"]')
                        for (const tooltipTrigger of tooltipTriggerList) {
                            new bootstrap.Tooltip(tooltipTrigger);
                        }
                    }
                JS,
                'initComplete' => <<<JS
                    function() {
                        $.fn.dataTable.ext.errMode = 'throw';
                        const datatable = this.api();

                        const searchInput = $('#datatableSearch');
                        let oldSearch = '';

                        searchInput.on('keyup', function() {
                            if (oldSearch != this.value) {
                                datatable.search(this.value).draw();
                                oldSearch = this.value;
                            }
                        });

                        searchInput.on('mouseup', function() {
                            const that = this;
                            const oldValue = that.value;

                            if (oldValue == '') return;

                            setTimeout(function(){
                                const newValue = that.value;

                                if (newValue == '') {
                                    $(that).trigger('keyup');
                                }
                            }, 1);
                        });
                    }
                JS,
                'responsive' => false,
                'showPaging' => false,
                'pageLength' => 10,
                'language' => [
                    'zeroRecords' => <<<HTML
                        <div class="text-center p-4">
                          <img class="mb-3" src="/assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                        <p class="mb-0">Tidak ada data untuk ditampilkan</p>
                        </div>
                    HTML,
                    'processing' => <<<HTML
                        <div class="align-items-start p-3">
                          <div class="spinner-border spinner-border-sm ms-auto" role="status" aria-hidden="true"></div>
                          <span>Sedang memproses, mohon tunggu sebentar...</span>
                        </div>
                    HTML,
                ],
            ])
            ->selectStyleSingle()
            ->addTableClass('table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table')
            ->setTableHeadClass('thead-light');
    }



    public static function actionButton( $show_route, $edit_route, $delete_route, string $csrf): string
    {
        if ($delete_route == null && $edit_route == null) {
            return <<<HTML
            <a href="{$show_route}">
              <button type="button" class="btn btn-white p-0 waves-effect waves-light" ><i class="ti ti-eye me-1"></i>Lihat</button>
            </a>
        HTML;
        } elseif ($delete_route != null && $edit_route == null) {
            return <<<HTML
            <div class="dropdown">
                <a href="{$show_route}">
                <button type="button" class="btn btn-white p-0 waves-effect waves-light" ><i class="ti ti-eye me-1"></i>Lihat</button>
                </a>
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-chevron-down"></i></button>
                <div class="dropdown-menu" style="">
                    <form action="{$delete_route}" class="mt-0 pt-0 delete_record" method="POST" >
                    {$csrf}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="dropdown-item delete-btn">
                        <i class="ti ti-trash me-1"></i>Delete
                    </button>
                </form>
                </div>
            </div>
        HTML;
        }

        return <<<HTML
            <div class="dropdown">
                <a href="{$show_route}">
                <button type="button" class="btn btn-white p-0 waves-effect waves-light" ><i class="ti ti-eye me-1"></i>Lihat</button>
                </a>
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-chevron-down"></i></button>
                <div class="dropdown-menu" style="">
                <a class="dropdown-item" href="{$edit_route}"><i class="ti ti-pencil me-1"></i>Edit</a>
                    <form action="{$delete_route}" class="mt-0 pt-0 delete_record" method="POST">
                    {$csrf}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="dropdown-item delete-btn">
                        <i class="ti ti-trash me-1"></i>Delete
                    </button>
                </form>
                </div>
            </div>
        HTML;
    }

    public static function namaPlaceholder($nama, $nim, $src){
        return <<<HTML
            <div class="d-flex">
                <div class="avatar me-2">
                <img alt="Avatar" class="rounded-circle" onerror="onImageErrorGuest(this);" src="{$src}" style="object-fit: cover; aspect-ratio: 1/1; width: 2.5rem; height: 2.5rem;">
            </div>
            <div class="ms-3">
                <h6 class="d-block mb-0 text-inherit mb-0">{$nama}</h6>
                <span class="d-block ">NIM. {$nim}</span>
            </div>
            </div>
    HTML;
    }

    public static function dosenNamaPlaceholder($nama, $no_induk, $src){
        return <<<HTML
            <div class="d-flex">
                <div class="avatar me-2">
                <img alt="Avatar" class="rounded-circle" onerror="onImageErrorGuest(this);" src="{$src}" style="object-fit: cover; aspect-ratio: 1/1; width: 2.5rem; height: 2.5rem; object-position: top;">
            </div>
            <div class="ms-3">
                <h6 class="d-block mb-0 text-inherit mb-0">{$nama}</h6>
                <span class="d-block ">{$no_induk}</span>
            </div>
            </div>
    HTML;

    }

    public static function limitText($text, $limit){
        return strlen($text) > $limit ? substr($text, 0, $limit) . '...' : $text;
    }

    public static function tanggal($date, $hour){
        return date('d M', strtotime($date)) . ' ' . date('H:i', strtotime($hour));
    }

    public static function promotors($promotors){
        $html = '<ul class="list-unstyled avatar-group d-flex align-items-center">';
        foreach ($promotors as $promotor) {

            $html .= <<<HTML
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="{$promotor->nama}" class="avatar pull-up">
                <img class="rounded-circle" src="{$promotor->url}" alt="Avatar" onerror="onImageErrorGuest(this);" style="object-fit: cover; object-position:top;">
            </li>
        HTML;
        }

        $html .= '</ul>';

        return $html;
    }

    public static function pengujis($pengujis){
        $html = '<ul class="list-unstyled avatar-group d-flex align-items-center">';

        foreach ($pengujis as $penguji) {
            $html .= <<<HTML
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="{$penguji->nama}" class="avatar pull-up">
                <img class="rounded-circle" src="{$penguji->url}" alt="Avatar" onerror="onImageErrorGuest(this);" style="object-fit: cover; object-position:top;">
            </li>
        HTML;
        }

        $html .= '</ul>';

        return $html;
    }
}
