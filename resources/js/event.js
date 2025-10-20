import './bootstrap';
import "datatables.net-dt/css/dataTables.dataTables.css";
import $ from 'jquery';
import 'datatables.net-dt';

$(function () {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/events',
            eventColor: '#610a08',
            eventClick: function(info) {
                const event = info.event.extendedProps;
                const details = `
                    Judul: ${info.event.title}
                    Deskripsi: ${event.deskripsi ?? '-'}
                    Lokasi: ${event.lokasi ?? '-'}
                    Peserta: ${event.peserta ?? '-'}
                    Tanggal: ${info.event.startStr} - ${info.event.endStr ?? ''}
                `;
                if (confirm(`${details}\n\nHapus kegiatan ini?`)) {
                    fetch(`/events/${info.event.id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    }).then(() => calendar.refetchEvents());
                }
            }
        });
        calendar.render();
    }

    const table = $('#eventTable').DataTable({
        processing: true,
        scrollX: true,
        serverSide: false,
        ajax: {
            url: '/events',
            dataSrc: ''
        },
        searching:true,
        lengthChange:false,
        pageLength:10,
        info:false,
        dom: 'rt<"flex mt-2 justify-center"p>',
        language: {
            paginate: {
                previous: '<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Prev</span>',
                next: '<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Next</span>'
            }
        },
        columns: [
            { data: 'title', name: 'event', orderable:false, render: data => `<span class="font-medium text-gray-900">${data}</span>` },
            { data: 'description', name: 'deskripsi', orderable:false, render: data => `<span class="text-gray-700">${data || '-'}</span>` },
            { data: 'start', name: 'tanggal_awal', orderable:false, render: data => `<span class="text-gray-700">${data}</span>` },
            { data: 'end', name: 'tanggal_akhir', orderable:false, render: data => `<span class="text-gray-700">${data}</span>` },
            { data: 'lokasi', name: 'lokasi', orderable:false, render: data => `<span class="text-gray-700">${data}</span>` },
            { data: 'peserta', name: 'peserta', orderable:false, render: data => `<span class="text-gray-700">${data}</span>` },
            {
                data: 'id',
                name: 'aksi',
                orderable: false,
                searchable: false,
                render: (id) => `
                    <div class="relative inline-block text-left">
                        <button class="action-btn" title="More options">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                            <a href="/events/${id}/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form method="POST" action="/events/${id}" class="delete-form">
                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                `
            }
        ],
        drawCallback: function() {
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
        }
    });

    $('#searchEvent').on('keyup', function () {
        table.search(this.value).draw();
    });

    
});
