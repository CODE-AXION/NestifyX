<div x-data="categoryTree" >
    <button  type="button"  @click="treeSidebar=true" class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">Category Tree</button>


    <div class="relative z-50 w-auto h-auto">

        <template x-teleport="body">

            <div x-show="treeSidebar" @keydown.window.escape="treeSidebar=false" class="relative z-[99]">

                <div x-show="treeSidebar" x-transition.opacity.duration.600ms @click="treeSidebar = false"
                    class="fixed inset-0 bg-black bg-opacity-10"></div>
                <div class="fixed inset-0 overflow-hidden">

                    <div class="absolute inset-0 overflow-hidden">

                        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">

                            <div x-show="treeSidebar" @click.away="treeSidebar = false"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-md">

                                <div
                                    class="flex flex-col h-full py-5 overflow-y-scroll bg-white   border-l shadow-lg border-neutral-100/70">
                                    
                                    <div class="px-4 sm:px-5">
                                        <div class="flex items-start justify-between pb-1">
                                            <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                id="slide-over-title"> <div class="text-slate-800 flex items-center gap-3">
                                                    NestifyX 

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-tree" viewBox="0 0 16 16">
                                                        <path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777zM6.437 4.758A.5.5 0 0 0 6 4.5h-.066L8 1.401 10.066 4.5H10a.5.5 0 0 0-.424.765L11.598 8.5H11.5a.5.5 0 0 0-.447.724L12.69 12.5H3.309l1.638-3.276A.5.5 0 0 0 4.5 8.5h-.098l2.022-3.235a.5.5 0 0 0 .013-.507"/>
                                                      </svg>
                                                </div>
                                            </h2>
                                            <div class="flex items-center h-auto ml-3">
                                                <button @click="treeSidebar=false"
                                                    class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    <span>Close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                        <div class="absolute inset-0 px-4 sm:px-5">
                                            <div
                                                class="relative h-full overflow-hidden   rounded-md border-neutral-300">
    
                                                <div class="flex">

                                                    <div class="my-5 w-full">
                                                       
                                                        <div class="mb-4">
                                                            <div class="relative h-11 w-44">
                                                                <input placeholder="Search... "  id="tree-search" class="peer h-full w-full border-b border-blue-gray-200 bg-transparent pt-4 pb-1.5 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder:opacity-0 placeholder-shown:border-blue-gray-200 focus:border-gray-500 focus:outline-0 focus:placeholder:opacity-100 disabled:border-0 disabled:bg-blue-gray-50"><label class="after:content[''] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all after:absolute after:-bottom-1.5 after:block after:w-full after:scale-x-0 after:border-b-2 after:border-gray-500 after:transition-transform after:duration-300 peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.25] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:after:scale-x-100 peer-focus:after:border-gray-900 peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                                               Search</label>
                                                            </div>
                                                        </div>
        
                                                      
    
                                                        <div class="category-tree"></div>
                                                    </div>

                                                    <div class="space-y-4 my-4 flex flex-col">
                                                        <button type="button" class="inline-flex cursor-pointer items-center justify-center rounded-lg px-5 py-2 text-center tracking-wide outline-none transition-all duration-200 focus:outline-none disabled:pointer-events-none bg-slate-50 border border-slate-200 btn-sm"
                                                        
                                                            @click="createNode();">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                                              </svg>
                                                           
                                                        </button>
                                                        <button type="button" class="inline-flex cursor-pointer items-center justify-center rounded-lg px-5 py-2 text-center tracking-wide outline-none transition-all duration-200 focus:outline-none disabled:pointer-events-none bg-slate-50 border border-slate-200"
                                                            @click="editNode();"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                              </svg>
                                                        </button>
                                                        <button type="button" class="inline-flex cursor-pointer items-center justify-center rounded-lg px-5 py-2 text-center tracking-wide outline-none transition-all duration-200 focus:outline-none disabled:pointer-events-none bg-slate-50 border border-slate-200"
                                                            @click="deleteNode();"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                              </svg>
                                                        </button>

                                                        <button type="button" class="inline-flex cursor-pointer items-center justify-center rounded-lg px-5 py-2 text-center tracking-wide outline-none transition-all duration-200 focus:outline-none disabled:pointer-events-none bg-slate-50 border border-slate-200"
                                                            @click="expandAll();">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-angle-expand" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707m4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707"/>
                                                            </svg>
                                                        </button>

                                                        <button type="button" class="inline-flex cursor-pointer items-center justify-center rounded-lg px-5 py-2 text-center tracking-wide outline-none transition-all duration-200 focus:outline-none disabled:pointer-events-none bg-slate-50 border border-slate-200"
                                                            @click="collapseAll();">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-angle-contract" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M.172 15.828a.5.5 0 0 0 .707 0l4.096-4.096V14.5a.5.5 0 1 0 1 0v-3.975a.5.5 0 0 0-.5-.5H1.5a.5.5 0 0 0 0 1h2.768L.172 15.121a.5.5 0 0 0 0 .707M15.828.172a.5.5 0 0 0-.707 0l-4.096 4.096V1.5a.5.5 0 1 0-1 0v3.975a.5.5 0 0 0 .5.5H14.5a.5.5 0 0 0 0-1h-2.768L15.828.879a.5.5 0 0 0 0-.707"/>
                                                              </svg>
                                                        </button>
                                                     
                                                        
                                                    
                                                    </div>
                                                </div>
    
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>


<style>
    #jstree-marker{
        z-index: 99 !important;
    }
</style>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('categoryTree', () => ({
            treeSidebar: false,
            createNode() {
                var ref = $('.category-tree').jstree(true),
                    sel = ref.get_selected();
                if (!sel.length) { return false; }
                sel = sel[0];
                sel = ref.create_node(sel, {"type": "file"});
                if (sel) {
                    ref.edit(sel);
                }
            },
            editNode() {
                var ref = $('.category-tree').jstree(true),
                    sel = ref.get_selected();
                if(!sel.length) { return false; }
                sel = sel[0];
                ref.edit(sel);
            },
            deleteNode() {
                if (confirm("Are You sure you want to delete this category ?") == true) {

                    var ref = $('.category-tree').jstree(true),
                        sel = ref.get_selected();
                    if(!sel.length) { return false; }
                    ref.delete_node(sel);
                    return
                }

                return false;
            },
            collapseAll() {

                $('.category-tree').jstree('close_all');
            },
            expandAll() {

                $('.category-tree').jstree('open_all');
            },
            init(){
                this.$nextTick(() => {
                   
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    function updateCategoryTree(data,tree) {

                        $.ajax({
                            type: 'PUT',
                            url: '{{route('categories.tree.update')}}',
                            data: {
                                _token:  csrfToken,
                                category_tree: getCategoryTree(tree) 
                            },
                            success: (message) => {
                  
                            },
                            error: (xhr) => {
                                alert(xhr.responseJSON.message);
                            },
                        });
                    }

                    function getCategoryTree(tree) {
                        let categories = tree.jstree(true).get_json('#', { flat: true });

                        return categories.reduce((formatted, category) => {
                            return formatted.concat({
                                id: category.id,
                                name: category.name,
                                parent_id: (category.parent === '#') ? null : category.parent,
                                position: category.data.position,
                            });
                        }, []);
                    }

                    function loading(node, state,tree) {

                    
                        let nodeElement = $('.category-tree').jstree(true).get_node(node, true);
                        console.log(nodeElement)
                        if (state) {
                            $(nodeElement).addClass('jstree-loading');
                        } else {
                            $(nodeElement).removeClass('jstree-loading');
                        }
                    }

                    function fetchCategoryTree() {
                        $.jstree.defaults.dnd.touch = true;
                        $.jstree.defaults.dnd.copy = false;
                       

                        let tree = $('.category-tree');


                        tree.jstree({
                            core: {
                                data: { url: '{{ route('categories.tree')}}' },
                                check_callback: true
                            },
                            
                            plugins: ['dnd','state','search','types'],
                        });

                        var to = false;
                        $('#tree-search').keyup(function () {
                            if(to) { clearTimeout(to); }
                            to = setTimeout(function () {
                                var v = $('#tree-search').val();
                                $('.category-tree').jstree(true).search(v);
                            }, 250);
                        });

                        tree.on('move_node.jstree', (e, data) => {
                            updateCategoryTree(data,tree);
                        });


                        tree.on('rename_node.jstree', function (e, data) {
                            console.log(data)
                            $.ajax({
                                type: 'PUT',
                                url: '{{route('categories.tree.update')}}',
                                data: {
                                    _token:  csrfToken,
                                    category_edit: {'id' : data.node.id,'text' : data.text},
                                    category_tree: getCategoryTree(tree) 
                                },
                                success: (message) => {
                                
                                    updateCategoryTree(data,tree)
                                },
                                error: (xhr) => {
                                    data.instance.refresh();
                                    alert(xhr.responseJSON.message);
                                },
                            });
                        })
                        tree.on('create_node.jstree', function (e, data) {
                            $.ajax({
                                type: 'PUT',
                                url: '{{route('categories.tree.update')}}',
                                data: {
                                    _token:  csrfToken,
                                    create_category: {  'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text},
                                
                                },
                                success: (d) => {
                                  
                                    data.instance.set_id(data.node, d.id);
                                    
                                },
                                error: (xhr) => {
                                    data.instance.refresh();
                                    alert(xhr.responseJSON.message);
                                },
                            });
                        
                        })
                        tree.on('delete_node.jstree', function (e, data) {

                            $.ajax({
                                type: 'PUT',
                                url: '{{route('categories.tree.update')}}',
                                data: {
                                    _token:  csrfToken,
                                    delete_category: { 'id' : data.node.id },
                                
                                },
                                success: (message) => {
                                   
                                },
                                error: (xhr) => {
                        
                                    alert(xhr.responseJSON.message)
                                },
                            });

                         
                        })
     
                    }
                    fetchCategoryTree();
                });
               
            }
        }))
    })
</script>

