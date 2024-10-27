<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List User Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="user" x-init="initData()" x-cloak>
                    <div class="flex justify-start md:justify-end py-4 px-2">
                        <a class="bg-green-500 rounded-md py-2 px-4 md:w-2/12 text-white text-center border-solid hover:scale-95 hover:opacity-95 transition ease-in"
                        href="{{ route('admin.add-user') }}">Create New User</a>
                    </div>
                    <div id="wrapper"></div>
                </div>
                <script type="text/javascript">
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('user', () => ({
                            message: 'Hello, World!',
                            async initData() {
                                const rawData = @json($list_users);
                                this.dataWithNumber = rawData.map((data, index) => {
                                    return {
                                        ...data,
                                        no: index + 1
                                    }
                                });
                                new gridjs.Grid({
                                    columns: [
                                        "no",
                                        "name",
                                        "email",
                                        "role",
                                        {
                                            name:"created_at",
                                            formatter:(cell,row)=>{
                                                // format just take the date
                                                const formattedDate = new Date(cell).toLocaleString('id-ID').split(',')[0]
                                                return formattedDate
                                            }
                                        },
                                        {
                                            name:"updated_at",
                                            formatter:(cell,row)=>{
                                                // format just take the date
                                                const formattedDate = new Date(cell).toLocaleString('id-ID').split(',')[0]
                                                return formattedDate
                                            }
                                        },
                                        {
                                            name: 'Edit & Delete',
                                            formatter: (cell, row) => {
                                                const className =`cursor-pointer text-center py-2 mb-4 px-4 border rounded-md text-white`
                                                return gridjs.html(`
                                                <div class="flex flex-row gap-2 justify-center">
                                                    <a class="${className} bg-green-600" href='/edit-user/${this.dataWithNumber[row.cells[0].data-1].id}'>Edit</a>
                                                    <a class="${className} bg-red-600" href='/delete-user/${this.dataWithNumber[row.cells[0].data-1].id}'>Delete</a>
                                                </div>
                                                `)
                                            }
                                        }
                                    ],
                                    sort: true,
                                    pagination: true,
                                    fixedHeader: true,
                                    data: this.dataWithNumber,
                                    search: true,
                                    resizable: true
                                }).render(document.getElementById("wrapper"));
                            },
                        }));
                    })
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
