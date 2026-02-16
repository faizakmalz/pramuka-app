import"./bootstrap-DIuewKhF.js";import{$ as a}from"./dataTables-DiaTurq6.js";a(function(){a.getJSON("/anggota/golongan-pramuka",function(e){e.forEach(function(t){a("#filterMapel").append(`<option value="${t}">${t}</option>`)})});const s=a("#guruTable").DataTable({processing:"",scrollX:!1,searching:!0,serverSide:!0,ajax:{url:"/data-anggota",data:function(e){e.golongan_pramuka=a("#filterMapel").val()},dataSrc:function(e){return a("#anggotaLoading").hide(),a("#guruTable").removeClass("hidden"),!e.data||e.data.length===0?(a("#guruTable tbody").html('<tr><td colspan="10" class="text-center py-4 text-gray-500">Tidak ada data ditemukan</td></tr>'),[]):e.data},beforeSend:function(){a("#anggotaLoading").show(),a("#guruTable").addClass("hidden")},error:function(){a("#anggotaLoading").hide(),alert("Gagal memuat data anggota. Coba lagi nanti.")}},preDrawCallback:function(){a(".dataTables_processing").hide()},columns:[{data:"nomor_anggota",name:"nomor_anggota",orderable:!1,render:e=>`<div class="font-mono text-sm text-gray-600">${String(e)||"-"}</div>`},{data:"nama",name:"nama",orderable:!1,render:e=>`<div class="font-medium text-gray-900">${e}</div>`},{data:"nik",name:"nik",orderable:!1,render:e=>`<span class="text-gray-700">${e||"-"}</span>`},{data:"jenis_kelamin",name:"jenis_kelamin",orderable:!1,render:e=>`<span class="text-gray-700">${e||"-"}</span>`},{data:"golongan_pramuka",name:"golongan_pramuka",orderable:!1,render:e=>`<span class="px-2 py-1 text-xs bg-red-500 text-white rounded whitespace-nowrap">${e||"-"}</span>`},{data:"golongan_darah",name:"golongan_darah",orderable:!1,render:e=>`<span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">${e||"-"}</span>`},{data:null,name:"lahir",orderable:!1,render:(e,t,n)=>{const o=n.tempat_lahir||"-",r=n.tanggal_lahir||"-";return`<div class="text-gray-700 whitespace-nowrap">${o}, ${r}</div>`}},{data:"no_telp",name:"no_telp",orderable:!1,render:e=>`<span class="font-mono text-sm whitespace-nowrap">${e||"-"}</span>`},{data:"nomor_anggota",name:"kta",orderable:!1,searchable:!1,render:e=>`
                    <a href="/anggota/${e}/kta" target="_blank"
                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-[#610a08] hover:bg-[#7D2A26] rounded transition whitespace-nowrap">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        KTA
                    </a>
                `},{data:"nomor_anggota",name:"aksi",orderable:!1,searchable:!1,render:e=>`
                    <div class="relative inline-block text-left">
                        <button class="action-btn p-1.5 rounded hover:bg-gray-100 transition" title="Opsi">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu hidden">
                            <div class="bg-white border border-gray-200 rounded-md shadow-lg py-1 min-w-[140px]">
                                <a href="/anggota/${e}/edit"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form method="POST" action="/anggota/${e}" class="delete-form">
                                    <input type="hidden" name="_token" value="${a('meta[name="csrf-token"]').attr("content")}">
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
                `}],lengthChange:!1,pageLength:10,dom:'rt<"flex mt-4 justify-center"p>',language:{processing:"",paginate:{previous:'<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-[#610a08] hover:text-white transition">Prev</span>',next:'<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-[#610a08] hover:text-white transition">Next</span>'}},drawCallback:function(){a(".action-btn").off("click").on("click",function(t){t.stopPropagation();const n=a(this),o=n.siblings(".dropdown-menu"),r=n[0].getBoundingClientRect();a(".dropdown-menu").not(o).addClass("hidden"),o.toggleClass("hidden"),o.hasClass("hidden")||o.css({position:"fixed",top:r.bottom+5+"px",left:r.right-140+"px",zIndex:9999})}),a(document).off("click.dropdown").on("click.dropdown",function(){a(".dropdown-menu").addClass("hidden")}),a(".delete-form").off("submit").on("submit",function(t){t.preventDefault(),confirm("Yakin ingin menghapus anggota ini?")&&this.submit()}),a("#guruTable thead th").each(function(){let t=a(this).find(".dt-sort-icon");t.length!==0&&(t.html(""),a(this).hasClass("sorting_asc")?t.html('<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3l5 7H5l5-7z" clip-rule="evenodd" /></svg>'):a(this).hasClass("sorting_desc")?t.html('<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 17l-5-7h10l-5 7z" clip-rule="evenodd" /></svg>'):t.html('<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>'))});const e=a(".custom-datatable-wrapper")[0];if(e){const t=()=>{const n=e.scrollLeft>=e.scrollWidth-e.clientWidth-5;a(e).toggleClass("scrolled-end",n)};a(e).off("scroll.check").on("scroll.check",t),t()}}});a("#searchGuru").on("keyup",function(){s.search(this.value).draw()}),a("#filterMapel").on("change",function(){s.ajax.reload()})});
