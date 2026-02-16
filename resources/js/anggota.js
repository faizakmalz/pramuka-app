import './bootstrap';
import "datatables.net-dt/css/dataTables.dataTables.css";
import $ from 'jquery';
import 'datatables.net-dt';

$(function () {
    // Load golongan pramuka untuk filter
    $.getJSON('/anggota/golongan-pramuka', function(kelas) {
        kelas.forEach(function(k) {
            $('#filterMapel').append(`<option value="${k}">${k}</option>`);
        });
    });

    const table = $('#guruTable').DataTable({
        processing: "",
        scrollX: false,
        searching: true,
        serverSide: true,
        ajax: {
            url: '/data-anggota',
            data: function (d) {
                d.golongan_pramuka = $('#filterMapel').val();
            },
            dataSrc: function (json) {
                $('#anggotaLoading').hide();
                $('#guruTable').removeClass('hidden');
                if (!json.data || json.data.length === 0) {
                    $('#guruTable tbody').html(
                        '<tr><td colspan="10" class="text-center py-4 text-gray-500">Tidak ada data ditemukan</td></tr>'
                    );
                    return [];
                }
                return json.data;
            },
            beforeSend: function () {
                $('#anggotaLoading').show();
                $('#guruTable').addClass('hidden');
            },
            error: function () {
                $('#anggotaLoading').hide();
                alert('Gagal memuat data anggota. Coba lagi nanti.');
            }
        },
        preDrawCallback: function() {
            $('.dataTables_processing').hide();
        },
        columns: [
            {
                data: 'nomor_anggota',
                name: 'nomor_anggota',
                orderable: false,
                render: data => `<div class="font-mono text-sm text-gray-600">${String(data) || '-'}</div>`
            },
            {
                data: 'nama',
                name: 'nama',
                orderable: false,
                render: data => `<div class="font-medium text-gray-900">${data}</div>`
            },
            {
                data: 'nik',
                name: 'nik',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            {
                data: 'jenis_kelamin',
                name: 'jenis_kelamin',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            {
                data: 'golongan_pramuka',
                name: 'golongan_pramuka',
                orderable: false,
                render: data => `<span class="px-2 py-1 text-xs bg-red-500 text-white rounded whitespace-nowrap">${data || '-'}</span>`
            },
            {
                data: 'golongan_darah',
                name: 'golongan_darah',
                orderable: false,
                render: data => `<span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">${data || '-'}</span>`
            },
            // Gabungkan tempat & tanggal lahir
            {
                data: null,
                name: 'lahir',
                orderable: false,
                render: (data, type, row) => {
                    const tempat = row.tempat_lahir || '-';
                    const tanggal = row.tanggal_lahir || '-';
                    return `<div class="text-gray-700 whitespace-nowrap">${tempat}, ${tanggal}</div>`;
                }
            },
            {
                data: 'no_telp',
                name: 'no_telp',
                orderable: false,
                render: data => `<span class="font-mono text-sm whitespace-nowrap">${data || '-'}</span>`
            },
            // Kolom KTA
            {
                data: 'nomor_anggota',
                name: 'kta',
                orderable: false,
                searchable: false,
                render: (nomor_anggota) => `
                    <a href="/anggota/${nomor_anggota}/kta" target="_blank"
                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-[#610a08] hover:bg-[#7D2A26] rounded transition whitespace-nowrap">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        KTA
                    </a>
                `
            },
            // Kolom Aksi
            {
                data: 'nomor_anggota',
                name: 'aksi',
                orderable: false,
                searchable: false,
                render: (nomor_anggota) => `
                    <div class="relative inline-block text-left">
                        <button class="action-btn p-1.5 rounded hover:bg-gray-100 transition" title="Opsi">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden">
                            <div class="bg-white border border-gray-200 rounded-md shadow-lg py-1 min-w-[140px]">
                                <a href="/anggota/${nomor_anggota}/edit"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form method="POST" action="/anggota/${nomor_anggota}" class="delete-form">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit"
                                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50 text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                `
            }
        ],
        lengthChange: false,
        pageLength: 10,
        dom: 'rt<"flex mt-4 justify-center"p>',
        language: {
            processing: "",
            paginate: {
                previous: '<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-[#610a08] hover:text-white transition">Prev</span>',
                next: '<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-[#610a08] hover:text-white transition">Next</span>'
            }
        },
        drawCallback: function () {
            // Dropdown dengan positioning yang benar
            $('.action-btn').off('click').on('click', function (e) {
                e.stopPropagation();
                const $button = $(this);
                const $menu = $button.siblings('.dropdown-menu');
                const buttonRect = $button[0].getBoundingClientRect();
                
                // Hide other dropdowns
                $('.dropdown-menu').not($menu).addClass('hidden');
                
                // Toggle current dropdown
                $menu.toggleClass('hidden');
                
                // Position dropdown
                if (!$menu.hasClass('hidden')) {
                    $menu.css({
                        position: 'fixed',
                        top: buttonRect.bottom + 5 + 'px',
                        left: (buttonRect.right - 140) + 'px',
                        zIndex: 9999
                    });
                }
            });

            $(document).off('click.dropdown').on('click.dropdown', function () {
                $('.dropdown-menu').addClass('hidden');
            });

            // Konfirmasi delete
            $('.delete-form').off('submit').on('submit', function (e) {
                e.preventDefault();
                if (confirm('Yakin ingin menghapus anggota ini?')) {
                    this.submit();
                }
            });

            // Sort icons
            $('#guruTable thead th').each(function () {
                let $icon = $(this).find('.dt-sort-icon');
                if ($icon.length === 0) {
                    return;
                }
                $icon.html('');
                if ($(this).hasClass('sorting_asc')) {
                    $icon.html(`<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3l5 7H5l5-7z" clip-rule="evenodd" /></svg>`);
                } else if ($(this).hasClass('sorting_desc')) {
                    $icon.html(`<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 17l-5-7h10l-5 7z" clip-rule="evenodd" /></svg>`);
                } else {
                    $icon.html(`<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>`);
                }
            });

            // Check scroll position for shadow indicator
            const wrapper = $('.custom-datatable-wrapper')[0];
            if (wrapper) {
                const checkScroll = () => {
                    const isScrolledEnd = wrapper.scrollLeft >= (wrapper.scrollWidth - wrapper.clientWidth - 5);
                    $(wrapper).toggleClass('scrolled-end', isScrolledEnd);
                };
                $(wrapper).off('scroll.check').on('scroll.check', checkScroll);
                checkScroll();
            }
        }
    });

    // Search
    $('#searchGuru').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Filter golongan — reload tabel
    $('#filterMapel').on('change', function () {
        table.ajax.reload();
    });
});