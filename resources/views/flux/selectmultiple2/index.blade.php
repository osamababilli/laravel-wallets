<div x-data="multiSelect(@js($options), '{{ $optionLabel }}', '{{ $optionValue }}', @entangle($attributes->wire('model')))" class="w-full">
    <flux:label class="block text-sm mb-1 font-medium text-zinc-900 dark:text-white">
        {{ $label }}
    </flux:label>

    <div class="relative mt-1">
        <button type="button" @click="open = !open"
            class="relative w-full bg-white dark:bg-white/10 border border-gray-300 rounded-md shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 pl-3 pr-10 py-2.25 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-zinc-500 focus:border-zinc-500 sm:text-sm">
            <span class="block truncate"
                x-text="selectedOptions.length ? selectedOptions.map(o=>o[labelKey]).join(', ') : '{{ $placeholder }}'">
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg class="shrink-0 size-3.5 text-gray-500 dark:text-zinc-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m7 15 5 5 5-5"></path>
                    <path d="m7 9 5-5 5 5"></path>
                </svg>
            </span>
        </button>

        <div x-show="open" @click.away="open = false" x-transition
            class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-900 shadow-lg max-h-60 rounded-md py-1 text-base overflow-auto sm:text-sm border border-gray-200 dark:border-zinc-700"
            style="display: none;">
            <template x-for="option in options" :key="option[valueKey]">
                <div @click="toggleOption(option)"
                    class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-white">
                    <span x-text="option[labelKey]"
                        :class="{ 'font-semibold text-zinc-900 dark:text-white': isSelected(option) }"
                        class="block truncate">
                    </span>
                    <span x-show="isSelected(option)"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-zinc-600 dark:text-zinc-400">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4L8 12.6l7.3-7.3a1 1 0 011.4 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </template>
        </div>
    </div>
</div>

{{-- V1 --}}

<script>
    function multiSelect(options, labelKey, valueKey, wireModel) {
        return {
            open: false,
            options: options,
            labelKey: labelKey,
            valueKey: valueKey,
            wireModel: wireModel, // الربط مع Livewire

            get selectedOptions() {
                // جلب الخيارات المحددة بناء على IDs من wireModel
                return this.options.filter(option =>
                    this.wireModel.includes(option[this.valueKey])
                );
            },

            isSelected(option) {
                return this.wireModel.includes(option[this.valueKey]);
            },

            toggleOption(option) {
                const optionValue = option[this.valueKey];
                const currentValues = [...this.wireModel]; // نسخ المصفوفة

                if (currentValues.includes(optionValue)) {
                    // إزالة الخيار
                    this.wireModel = currentValues.filter(id => id !== optionValue);
                } else {
                    // إضافة الخيار
                    this.wireModel = [...currentValues, optionValue];
                }
            },

            // تهيئة القيم عند تحميل المكون
            init() {
                // التأكد من أن wireModel هو مصفوفة
                if (!Array.isArray(this.wireModel)) {
                    this.wireModel = [];
                }
            }
        }
    }
</script>


{{-- V2 --}}
{{-- <script>
    function multiSelect(options, labelKey, valueKey, wireModel) {
        return {
            // الحالة الأولية للمكون
            open: false, // للتحكم في فتح وإغلاق القائمة المنسدلة
            options: options, // قائمة الخيارات الكاملة القادمة من الخادم
            labelKey: labelKey, // المفتاح المستخدم لعرض اسم الخيار (e.g., 'name')
            valueKey: valueKey, // المفتاح المستخدم كقيمة للخيار (e.g., 'id' or 'name')
            wireModel: wireModel, // القيمة الحالية المرتبطة بـ wire:model (مصفوفة الأدوار المحددة)

            /**
             * دالة محسوبة (Computed Property) لجلب تفاصيل الخيارات المحددة.
             * تبحث في `options` عن الخيارات التي تتطابق قيمها مع القيم الموجودة في `wireModel`.
             */
            get selectedOptions() {
                if (!Array.isArray(this.wireModel)) {
                    return [];
                }
                return this.options.filter(option =>
                    this.wireModel.includes(option[this.valueKey])
                );
            },

            /**
             * تتحقق مما إذا كان خيار معين محددًا حاليًا أم لا.
             * @param {object} option - الكائن الذي يمثل الخيار.
             * @returns {boolean}
             */
            isSelected(option) {
                if (!Array.isArray(this.wireModel)) {
                    return false;
                }
                return this.wireModel.includes(option[this.valueKey]);
            },

            /**
             * الدالة التي يتم استدعاؤها عند النقر على أي خيار.
             * تقوم باستدعاء دالة في مكون Livewire الخلفي لتحديث الحالة.
             * @param {object} option - الكائن الذي يمثل الخيار الذي تم النقر عليه.
             */
            toggleOption(option) {
                const optionValue = option[this.valueKey];

                // استدعاء دالة `toggleRoleSelection` في مكون Livewire
                // وتمرير قيمة الخيار (e.g., 'admin' or 'editor')
                // هذا هو التغيير الرئيسي لضمان التوافق مع Livewire
                this.$wire.call('toggleRoleSelection', optionValue);
            },

            /**
             * دالة للتهيئة، يتم تشغيلها عند تحميل المكون.
             * تضمن أن `wireModel` هو دائمًا مصفوفة لتجنب الأخطاء.
             */
            init() {
                if (!Array.isArray(this.wireModel)) {
                    this.wireModel = [];
                }
            }
        }
    }
</script> --}}

{{-- V4 --}}
{{-- <script>
    function multiSelect(options, labelKey, valueKey, wireModel) {
        return {
            open: false,
            options: options,
            labelKey: labelKey,
            valueKey: valueKey,
            // لا نستخدم wireModel مباشرة للتحديث، بل كقيمة أولية
            selectedValues: wireModel,

            get selectedOptions() {
                if (!Array.isArray(this.selectedValues)) {
                    return [];
                }
                return this.options.filter(option =>
                    this.selectedValues.includes(option[this.valueKey])
                );
            },

            isSelected(option) {
                if (!Array.isArray(this.selectedValues)) {
                    return false;
                }
                return this.selectedValues.includes(option[this.valueKey]);
            },

            /**
             * تعديل هنا: تحديث المصفوفة محليًا وإطلاق حدث
             */
            toggleOption(option) {
                const optionValue = option[this.valueKey];
                let currentValues = [...this.selectedValues]; // نسخ المصفوفة

                if (currentValues.includes(optionValue)) {
                    // إزالة الخيار
                    this.selectedValues = currentValues.filter(id => id !== optionValue);
                } else {
                    // إضافة الخيار
                    this.selectedValues = [...currentValues, optionValue];
                }

                // إطلاق حدث إلى المكون الأب مع المصفوفة المحدثة
                // this.$wire.emit('selectionUpdated', this.selectedValues);
                // الأفضل هو ربط النموذج مباشرةً وتحديثه
                this.$wire.set('{{ $attributes->wire('model')->value() }}', this.selectedValues);
            },

            init() {
                // التأكد من أن القيمة الأولية هي مصفوفة
                if (!Array.isArray(this.selectedValues)) {
                    this.selectedValues = [];
                }

                // مراقبة التغييرات من الخادم وتحديث الواجهة
                this.$watch('$wire.{{ $attributes->wire('model')->value() }}', (newValue) => {
                    this.selectedValues = newValue;
                });
            }
        }
    }
</script> --}}
