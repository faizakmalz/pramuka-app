import"./bootstrap-DIuewKhF.js";import{$ as e}from"./dataTables-DiaTurq6.js";e(function(){e.getJSON("/anggota/golongan-pramuka",function(a){a.forEach(function(t){e("#filterMapel").append(`<option value="${t}">${t}</option>`)})});const n=e("#guruTable").DataTable({processing:"",scrollX:!0,searching:!0,serverSide:!0,ajax:{url:"/data-anggota",data:function(a){a.golongan_pramuka=e("#filterMapel").val()},dataSrc:function(a){return e("#anggotaLoading").hide(),e("#guruTable").removeClass("hidden"),!a.data||a.data.length===0?(e("#guruTable tbody").html('<tr><td colspan="12" class="text-center py-4 text-gray-500">Tidak ada data ditemukan</td></tr>'),[]):a.data},beforeSend:function(){e("#anggotaLoading").show(),e("#guruTable").addClass("hidden")},error:function(){e("#anggotaLoading").hide(),alert("Gagal memuat data anggota. Coba lagi nanti.")}},preDrawCallback:function(){e(".dataTables_processing").hide()},columns:[{data:"nomor_anggota",name:"id",orderable:!1,render:a=>`<div class="font-mono text-sm text-gray-600">${String(a)||"-"}</div>`},{data:"nama",name:"nama",orderable:!1,render:a=>`<div class="font-medium text-gray-900">${a}</div>`},{data:"nik",name:"NIK",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"jenis_kelamin",name:"Jenis Kelamin",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"agama",name:"Agama",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"golongan_pramuka",name:"Golongan Pramuka",orderable:!1,render:a=>`<span class="px-2 py-1 text-xs bg-red-500 text-red-100 rounded">${a||"-"}</span>`},{data:"golongan_darah",name:"Golongan Darah",orderable:!1,render:a=>`<span class="px-2 py-1 text-xs bg-red-100 text-red-500 rounded">${a||"-"}</span>`},{data:"alamat",name:"Alamat",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"tempat_lahir",name:"Tempat Lahir",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"tanggal_lahir",name:"Tanggal Lahir",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"email",name:"Email",orderable:!1,render:a=>`<span class="text-gray-700">${a||"-"}</span>`},{data:"no_telp",name:"No. Telp",orderable:!1,render:a=>`<span class="font-mono text-sm">${a||"-"}</span>`},{data:"created_at",name:"Created At",orderable:!1,render:a=>`<span class="text-gray-500 text-sm">${a||"-"}</span>`},{data:"updated_at",name:"Updated At",orderable:!1,render:a=>`<span class="text-gray-500 text-sm">${a||"-"}</span>`},{data:"nomor_anggota",width:100,name:"pdf",orderable:!1,searchable:!1,render:a=>`
                    <div class="relative inline-block text-left">
                        <a 
                            class="text-white bg-[#610a08] hover:bg-gray-700 px-3 py-1 rounded"
                            href="/anggota/${a}/kta"
                            target="_blank"
                        >
                            Lihat KTA
                        </a>
                    </div>
                `},{data:"nomor_anggota",name:"aksi",orderable:!1,searchable:!1,render:a=>`
                    <div class="relative inline-block text-left">
                        <button class="action-btn" title="More options">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                            <a href="/anggota/${a}/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form method="POST" action="/anggota/${a}" class="delete-form">
                                <input type="hidden" name="_token" value="${e('meta[name="csrf-token"]').attr("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                        <button 
                            class="view-kta-btn text-white bg-[#7D2A26] px-3 py-1 rounded"
                            data-id="${a}"
                        >
                            Lihat KTA
                        </button>
                    </div>
                `}],lengthChange:!1,pageLength:10,dom:'rt<"flex mt-2 justify-center"p>',language:{processing:"",paginate:{previous:'<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Prev</span>',next:'<span class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-blue-500 hover:text-white transition">Next</span>'}},drawCallback:function(){e(".action-btn").off("click").on("click",function(a){a.stopPropagation();const t=e(this).siblings(".dropdown-menu");e(".dropdown-menu").not(t).addClass("hidden"),t.toggleClass("hidden")}),e(document).off("click").on("click",function(){e(".dropdown-menu").addClass("hidden")}),e(".delete-form").off("submit").on("submit",function(a){a.preventDefault(),confirm("Yakin ingin menghapus guru ini?")&&this.submit()}),e(".view-kta-btn").on("click",function(a){const o=`/anggota/${a.target.getAttribute("data-id")}/kta`,r=document.querySelector("[x-data]");r.__x.$data.openKta=!0,r.__x.$data.pdfUrl=o}),e("#guruTable thead th").each(function(){let a=e(this).find(".dt-sort-icon");a.html(""),e(this).hasClass("sorting_asc")?a.html('<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3l5 7H5l5-7z" clip-rule="evenodd" /></svg>'):e(this).hasClass("sorting_desc")?a.html('<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 17l-5-7h10l-5 7z" clip-rule="evenodd" /></svg>'):a.html('<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>')})}});e("#searchGuru").on("keyup",function(){n.search(this.value).draw()}),e("#filterMapel").on("change",function(){n.ajax.reload()})});
