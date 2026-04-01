import"./bootstrap-DIuewKhF.js";import{$ as t}from"./dataTables-DiaTurq6.js";t(function(){const s=document.getElementById("calendar");if(s){const e=new FullCalendar.Calendar(s,{initialView:"dayGridMonth",events:"/events",eventColor:"#610a08",eventClick:function(a){const n=a.event.extendedProps,l=`
                    Judul: ${a.event.title}
                    Deskripsi: ${n.deskripsi??"-"}
                    Lokasi: ${n.lokasi??"-"}
                    Peserta: ${n.peserta??"-"}
                    Tanggal: ${a.event.startStr} - ${a.event.endStr??""}
                `;confirm(`${l}

Hapus kegiatan ini?`)&&fetch(`/events/${a.event.id}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":t('meta[name="csrf-token"]').attr("content")}}).then(()=>e.refetchEvents())}});e.render()}const r=t("#eventTable").DataTable({processing:!0,scrollX:!0,serverSide:!1,ajax:{url:"/events",dataSrc:""},searching:!0,lengthChange:!1,pageLength:10,info:!1,dom:'rt<"flex mt-2 justify-center"p>',language:{paginate:{previous:'<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Prev</span>',next:'<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Next</span>'}},columns:[{data:"title",name:"event",orderable:!1,render:e=>`<span class="font-medium text-gray-900">${e}</span>`},{data:"description",name:"deskripsi",orderable:!1,render:e=>`<span class="text-gray-700">${e||"-"}</span>`},{data:"start",name:"tanggal_awal",orderable:!1,render:e=>`<span class="text-gray-700">${e}</span>`},{data:"end",name:"tanggal_akhir",orderable:!1,render:e=>`<span class="text-gray-700">${e}</span>`},{data:"lokasi",name:"lokasi",orderable:!1,render:e=>`<span class="text-gray-700">${e}</span>`},{data:"peserta",name:"peserta",orderable:!1,render:e=>`<span class="text-gray-700">${e}</span>`},{data:"id",name:"aksi",orderable:!1,searchable:!1,render:e=>`
                    <div class="relative inline-block text-left">
                        <button class="action-btn" title="More options">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                            <a href="/events/${e}/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form method="POST" action="/events/${e}" class="delete-form">
                                <input type="hidden" name="_token" value="${t('meta[name="csrf-token"]').attr("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                `}],drawCallback:function(){t(".action-btn").off("click").on("click",function(e){e.stopPropagation();const a=t(this).siblings(".dropdown-menu");t(".dropdown-menu").not(a).addClass("hidden"),a.toggleClass("hidden")}),t(document).off("click").on("click",function(){t(".dropdown-menu").addClass("hidden")}),t(".delete-form").off("submit").on("submit",function(e){e.preventDefault(),confirm("Yakin ingin menghapus guru ini?")&&this.submit()})}});t("#searchEvent").on("keyup",function(){r.search(this.value).draw()})});
