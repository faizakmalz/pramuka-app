import './bootstrap';
import "datatables.net-dt/css/dataTables.dataTables.css";
import $ from 'jquery';
import 'datatables.net-dt';

$(function () {
     $.getJSON('/anggota/golongan-pramuka', function(kelas) {
        kelas.forEach(function(k) {
            $('#filterMapel').append(
                `<option value="${k}">${k}</option>`
            );
        });
    });
    const table = $('#guruTable').DataTable({
        processing: true,
        scrollX:true,
        searching: true,
        serverSide: true,
        ajax: {
            url: '/data-anggota',
            data: function(d) {
                d.golongan_pramuka = $('#filterMapel').val();
            }
        },
        columns: [
            { 
                data: 'nomor_anggota', 
                name: 'id', 
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
                name: 'NIK',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'jenis_kelamin', 
                name: 'Jenis Kelamin',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'agama', 
                name: 'Agama',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'golongan_pramuka', 
                name: 'Golongan Pramuka',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'golongan_darah', 
                name: 'Golongan Darah',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'alamat', 
                name: 'Alamat',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'tempat_lahir', 
                name: 'Tempat Lahir',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'tanggal_lahir', 
                name: 'Tanggal Lahir',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'email', 
                name: 'Email',
                orderable: false,
                render: data => `<span class="text-gray-700">${data || '-'}</span>`
            },
            { 
                data: 'no_telp', 
                name: 'No. Telp',
                orderable: false,
                render: data => `<span class="font-mono text-sm">${data || '-'}</span>`
            },
            { 
                data: 'created_at', 
                name: 'Created At',
                orderable: false,
                render: data => `<span class="text-gray-500 text-sm">${data || '-'}</span>`
            },
            { 
                data: 'updated_at', 
                name: 'Updated At',
                orderable: false,
                render: data => `<span class="text-gray-500 text-sm">${data || '-'}</span>`
            },
            {
                data: 'nomor_anggota',
                name: 'aksi',
                orderable: false,
                searchable: false,
                render: (nomor_anggota) => `
                    <div class="relative inline-block text-left">
                        <button class="action-btn" title="More options">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                            <a href="/anggota/${nomor_anggota}/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form method="POST" action="/anggota/${nomor_anggota}" class="delete-form">
                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                `
            }

        ],
        lengthChange: false,
        pageLength: 10,
        dom: 'rt<"flex mt-2 justify-center"p>',
        language: {
            paginate: {
                previous: '<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Prev</span>',
                next: '<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Next</span>'
            }
        },
        drawCallback: function () {
            $('.action-btn').off('click').on('click', function (e) {
                e.stopPropagation();
                const $menu = $(this).siblings('.dropdown-menu');
                $('.dropdown-menu').not($menu).addClass('hidden');
                $menu.toggleClass('hidden');
            });

            $(document).off('click').on('click', function () {
                $('.dropdown-menu').addClass('hidden');
            });

            $('.delete-form').off('submit').on('submit', function (e) {
                e.preventDefault();
                if (confirm('Yakin ingin menghapus guru ini?')) {
                    this.submit();
                }
            });


            $('#guruTable thead th').each(function () {
                let $icon = $(this).find('.dt-sort-icon');
                $icon.html('');
                if ($(this).hasClass('sorting_asc')) {
                    $icon.html(`<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3l5 7H5l5-7z" clip-rule="evenodd" /></svg>`);
                } else if ($(this).hasClass('sorting_desc')) {
                    $icon.html(`<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 17l-5-7h10l-5 7z" clip-rule="evenodd" /></svg>`);
                } else {
                    $icon.html(`<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>`);
                }
            });
        }
    });

    $('#searchGuru').on('keyup', function () {
        table.search(this.value).draw();
    });

    $('#filterMapel').on('change', function() {
        table.ajax.reload();
    });
});
