<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Form Registration') }}
        </h2>
    </x-slot>
        <section class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 rounded-lg py-8 my-10" 
        x-data="register"
        x-init="getAllProvinces()" 
        x-cloak
        >
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Form Information') }}
            </h2>
        </header>
        <form class="mt-6 space-y-6" method="POST" action="{{ route('admin.update-register', $register->id) }}">
            @csrf
            @method('PATCH')
            <div>
                <x-input-label for="full_name" :value="__('Nama Lengkap')" />
                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" required
                    autofocus autocomplete="full_name" value="{{ $register->full_name }}" />
                <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
            </div>

            <div>
                <x-input-label for="ktp_address" :value="__('Alamat KTP')" />
                <x-text-input id="ktp_address" name="ktp_address" type="text" class="mt-1 block w-full" required
                    autofocus autocomplete="ktp_address" value="{{ $register->ktp_address }}" />
                <x-input-error class="mt-2" :messages="$errors->get('ktp_address')" />
            </div>

            <div>
                <x-input-label for="current_address" :value="__('Alamat Lengkap Saat Ini')" />
                <x-text-input id="current_address" name="current_address" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="current_address" value="{{ $register->current_address }}" />
                <x-input-error class="mt-2" :messages="$errors->get('current_address')" />
            </div>
            <div>
                <x-input-label for="province_name" :value="__('Propinsi')" />
                <select id="province_name" name="province_name" class="w-full rounded-md" 
                x-model="selectedProvince"
                x-on:change="getAllCities()" 
                required>
                    <option value="{{ $register->ProvinceAndCity->province_name }}">{{ $register->ProvinceAndCity->province_name }}</option>
                    <template x-for="province in provinceList">
                        <option x-text="province.province_name" x-bind:value="province.province_name"></option>
                    </template>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('province')" />
            </div>

            <div>
                <x-input-label for="city_name" :value="__('Kabupaten/Kota')" />
                <select name="city_name" id="city_name" class="w-full rounded-md" x-model="selectedCity" required>
                    <option value="{{ $register->ProvinceAndCity->city_name }}">{{ $register->ProvinceAndCity->city_name }}</option>
                    <template x-for="city in cityList">
                        <option x-text="city.city_name" x-bind:value="city.city_name"></option>
                    </template>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div>
                <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" required
                    autofocus autocomplete="kecamatan" value="{{ $register->kecamatan }}" />
                <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
            </div>

            <div>
                <x-input-label for="telephone_number" :value="__('Nomor Telepon')" />
                <x-text-input id="telephone_number" name="telephone_number" type="number" class="mt-1 block w-full"
                    required value="{{ $register->telephone_number }}" />
                <x-input-error class="mt-2" :messages="$errors->get('telephone_number')" />
            </div>

            <div>
                <x-input-label for="phone_number" :value="__('Nomor HP')" />
                <x-text-input id="phone_number" name="phone_number" type="number" class="mt-1 block w-full" required
                    value="{{ $register->phone_number }}" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required
                    value="{{ $register->email }}" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="citizenship" :value="__('Kewarganegaraan')" />
                <select id="citizenship" name="citizenship" class="mt-1 block w-full rounded-md" x-model="citizenship"
                    x-on:change="confirmCitizen()" required>
                    <option value="">Pilih Kewarganegaraan</option>
                    <option value="WNI Asli">WNI Asli</option>
                    <option value="WNI Keturunan">WNI Keturunan</option>
                    <option value="WNA">WNA</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('citizenship')" />
            </div>

            <div x-show="citizen_origin == ''">
                <x-input-label for="citizen_origin" :value="__('Asal Negara')" />
                <x-text-input id="citizen_origin" name="citizen_origin" type="text" class="mt-1 block w-full"
                    x-model="citizen_origin" required value="{{ $register->citizen_origin }}" />
                <x-input-error class="mt-2" :messages="$errors->get('citizen_origin')" />
            </div>

            <div>
                <x-input-label for="birth_date" :value="__('Tanggal Lahir (Sesuai Ijazah)')" />
                <x-text-input type="datetime-local" id="birth_date" name="birth_date" x-model="birth_date"
                    min="1900-06-07T00:00" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
            </div>

            <div>
                <x-input-label for="birth_place" :value="__('Tempat Lahir(Sesuai Ijazah)')" />
                <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" required
                    value="{{ $register->birth_place }}" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
            </div>

            <div>
                <x-input-label for="birth_cities" :value="__('Kota / Kabupaten Lahir')" />
                <x-text-input id="birth_cities" name="birth_cities" type="text" class="mt-1 block w-full"
                    required value="{{ $register->birth_cities }}" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_cities')" />
            </div>

            <div>
                <x-input-label for="birth_provinces" :value="__('Propinsi Lahir')" />
                <x-text-input id="birth_provinces" name="birth_provinces" type="text" class="mt-1 block w-full"
                    required value="{{ $register->birth_provinces }}" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_provinces')" />
            </div>

            <div>
                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                <select id="gender" name="gender" class="mt-1 block w-full rounded-md" x-model="gender"
                    x-on:change="confirmGender()" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            <div>
                <x-input-label for="marriage_status" :value="__('Status Menikah')" />
                <select id="marriage_status" name="marriage_status" class="mt-1 block w-full rounded-md"
                    x-model="marriageStatus" required>
                    <option value="">Pilih Jenis Status Menikah</option>
                    <option value="N">Belum Menikah</option>
                    <option value="Y">Sudah Menikah</option>
                    <option value="O">Lain-Lain (Janda/Duda)</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('marriage_status')" />
            </div>

            <div>
                <x-input-label for="religion" :value="__('Agama')" />
                <select id="religion" name="religion" class="mt-1 block w-full rounded-md" x-model="religion"
                    required>
                    <option value="">Pilih Agama anda</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen Protestan">Kristen Protestan</option>
                    <option value="Kristen Katolik">Kristen Katolik</option>
                    <option value="Kristen Ortodoks">Pilih Jenis Status Menikah</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Khong Hu Ciu">Khong Hu Ciu</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('religion')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </form>
    </section>
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('register', () => {
                return {
                    provinceList: [],
                    cityList: [],
                    selectedProvince: "{{ $register->ProvinceAndCity->province_name }}",
                    selectedCity: "{{ $register->ProvinceAndCity->city_name }}",
                    citizenship: "{{ $register->citizenship }}",
                    gender: "{{ $register->gender }}",
                    marriageStatus: "{{ $register->marriage_status }}",
                    religion: "{{ $register->religion }}",
                    birth_date: new Date( "{{ $register->birth_date }}").toISOString().slice(0, 16),
                    citizen_origin: "{{ $register->citizen_origin }}",
                    async getAllProvinces() {
                        console.log(this.birth_date)
                        console.log(this.selectedProvince)
                        console.log(this.selectedCity)
                        this.showLoading();
                        const res = await fetch('/provinces-and-cities/get-all-provinces');
                        const resJson = await res.json();
                        this.provinceList = resJson;
                        this.hideLoading();
                    },
                    async getAllCities() {
                        if (this.selectedProvince == "") return;
                        this.showLoading();
                        const res = await fetch(
                            `/provinces-and-cities/get-all-cities/${this.selectedProvince}`);
                        const resJson = await res.json();
                        this.cityList = resJson;
                        this.hideLoading();
                    },
                    confirmCitizen() {
                        if (this.citizenship == 'WNA') {
                            this.citizen_origin = '';
                            iziToast.info({
                                title: 'Info',
                                message: 'Silahkan isi asal negara anda',
                                position: 'topRight',
                                overlay: true,
                                close: true,
                                timeout: 5000,
                                overlayClose: true,
                                class: 'info',
                            })
                            return;
                        }
                        this.citizen_origin = 'Indonesia';
                    },
                    confirmGender() {
                        if (this.gender != 'L' && this.gender != "P") {
                            iziToast.info({
                                title: 'Info',
                                message: 'Silahkan pilih jenis kelamin anda',
                                position: 'topRight',
                                overlay: true,
                                close: true,
                                timeout: 5000,
                                overlayClose: true,
                                class: 'info',
                            })
                        }
                    },
                    hideLoading() {
                        var toast = document.querySelector('.iziToast'); // Selector of your toast
                        iziToast.hide({}, toast);
                    },
                    showLoading() {
                        iziToast.info({
                            title: 'Loading',
                            message: 'Please wait a moment...',
                            position: 'topRight',
                            overlay: true,
                            close: false,
                            timeout: false,
                            overlayClose: false,
                            class: 'success',
                        });
                    },
                    validateFormData(formData) {
                        const errors = [];

                        // Validation rules
                        const rules = {
                            full_name: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            ktp_address: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            current_address: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            province_name: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            city_name: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            kecamatan: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            telephone_number: {
                                required: true,
                                type: 'string',
                                max: 16,
                            },
                            phone_number: {
                                required: true,
                                type: 'string',
                                max: 16,
                                startsWith: '08'
                            },
                            email: {
                                required: true,
                                type: 'string',
                                email: true,
                                max: 255
                            },
                            citizenship: {
                                required: true,
                                type: 'string',
                                in: ['WNI Asli', 'WNI Keturunan', 'WNA']
                            },
                            citizen_origin: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            birth_date: {
                                required: true,
                                type: 'date'
                            },
                            birth_place: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            birth_provinces: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            birth_cities: {
                                required: true,
                                type: 'string',
                                max: 255
                            },
                            gender: {
                                required: true,
                                type: 'string',
                                in: ['L', 'P']
                            },
                            marriage_status: {
                                required: true,
                                type: 'string',
                                in: ['N', 'Y', 'O']
                            },
                            religion: {
                                required: true,
                                type: 'string',
                                in: ['Islam', 'Kristen Protestan', 'Kristen Katolik',
                                    'Kristen Ortodoks', 'Katolok', 'Hindu', 'Budha', 'Khong Hu Ciu'
                                ]
                            },
                        };

                        // Validate each field
                        for (const field in rules) {
                            const rule = rules[field];
                            const value = formData[field];

                            if (rule.required && !value) {
                                errors.push({
                                    [field]: `${field} is required`
                                });
                                continue;
                            }

                            if (rule.type === 'string' && typeof value !== 'string') {
                                errors.push({
                                    [field]: `${field} must be a string`
                                });
                                continue;
                            }

                            if (rule.type === 'date' && isNaN(Date.parse(value))) {
                                errors.push({
                                    [field]: `${field} must be a valid date`
                                });
                                continue;
                            }

                            if (rule.max && value.length > rule.max) {
                                errors.push({
                                    [field]: `${field} must not exceed ${rule.max} characters`
                                });
                                continue;
                            }

                            if (rule.startsWith && !value.startsWith(rule.startsWith)) {
                                errors.push({
                                    [field]: `${field} must start with ${rule.startsWith}`
                                });
                                continue;
                            }

                            if (rule.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                                errors.push({
                                    [field]: `${field} must be a valid email address`
                                });
                                continue;
                            }

                            if (rule.in && !rule.in.includes(value)) {
                                errors.push({
                                    [field]: `${field} must be one of ${rule.in.join(', ')}`
                                });
                                continue;
                            }
                        }
                        return errors;
                    },
                    async submitForm(event) {
                        // Get form data
                        const formData = new FormData(event.target);
                        const formEntries = Object.fromEntries(formData.entries());
                        const validateField = this.validateFormData(formEntries);
                        console.log("validateField", validateField);
                        if (validateField.length > 0) {
                            validateField.forEach((error) => {
                                for (const key in error) {
                                    iziToast.error({
                                        title: 'Error',
                                        message: error[key],
                                        position: 'topRight',
                                        overlay: true,
                                        close: true,
                                        timeout: 5000,
                                        overlayClose: true,
                                        class: 'error',
                                    })
                                }
                            });
                            return;
                        }
                        this.showLoading();
                        event.target.submit();
                    }
                }
            });
        })
    </script>
</x-app-layout>

