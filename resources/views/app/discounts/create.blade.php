<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-gray-800 leading-tight">
            <div class="p-6 bg-white border-b border-gray-200 flex">
                <div class="w-2/3">
                    <div class="text-xl text-gray-800 font-bold pb-2">
                        {{ __('app/discounts/create.create_discount') }}
                    </div>
                    <div class="text-sm text-blue-500">
                        {{ __('app/discounts/create.create_discount_description') }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <script>

        // verify filled fields and enable next input if required
        function check_period_2_enable(load = false) {
            if (load) {
                if ($('input[name="period_1[from_days]"]').val()
                    && $('input[name="period_1[to_days]"]').val()
                    && ($('input[name="period_1[code]"]').val() || $('input[name="period_1[discount]"]').val())) {

                    $("#period_2").find('input').each(function () {
                        $(this).prop('disabled', false).removeClass('bg-neutral-300');
                    });
                    $("#period_2_blackout").addClass('hidden');
                }
            } else {
                if ($('input[name="period_2[from_days]"]').val()
                    || $('input[name="period_2[to_days]"]').val()
                    || ($('input[name="period_2[code]"]').val() || $('input[name="period_2[discount]"]').val())) {

                    $("#period_2").find('input').each(function () {
                        $(this).prop('disabled', false).removeClass('bg-neutral-300');
                    });
                    $("#period_2_blackout").addClass('hidden');
                }
            }
        }

        function check_period_2_disable() {
            if (!$('input[name="period_1[from_days]"]').val()
                || !$('input[name="period_1[to_days]"]').val()
                || (!$('input[name="period_1[code]"]').val() && !$('input[name="period_1[discount]"]').val())) {

                $("#period_2").find('input').each(function () {
                    $(this).val('');
                    $(this).prop('disabled', true).addClass('bg-neutral-300');
                });
                $("#period_3").find('input').each(function () {
                    $(this).val('');
                    $(this).prop('disabled', true).addClass('bg-neutral-300');
                });
                $("#period_2_blackout").removeClass('hidden');
            }
        }

        function check_period_3_enable(load = false) {
            if (load) {
                if ($('input[name="period_2[from_days]"]').val()
                    && $('input[name="period_2[to_days]"]').val()
                    && ($('input[name="period_2[code]"]').val() || $('input[name="period_2[discount]"]').val())) {

                    $("#period_3").find('input').each(function () {
                        $(this).prop('disabled', false).removeClass('bg-neutral-300');
                    });
                    $("#period_3_blackout").addClass('hidden');
                }
            } else {
                if ($('input[name="period_3[from_days]"]').val()
                    || $('input[name="period_3[to_days]"]').val()
                    || ($('input[name="period_3[code]"]').val() || $('input[name="period_3[discount]"]').val())) {

                    $("#period_3").find('input').each(function () {
                        $(this).prop('disabled', false).removeClass('bg-neutral-300');
                    });
                    $("#period_3_blackout").addClass('hidden');
                }
            }
        }

        function check_period_3_disable() {
            if (!$('input[name="period_2[from_days]"]').val()
                || !$('input[name="period_2[to_days]"]').val()
                || (!$('input[name="period_2[code]"]').val() && !$('input[name="period_2[discount]"]').val())) {

                $("#period_3").find('input').each(function () {
                    $(this).val('');
                    $(this).prop('disabled', true).addClass('bg-neutral-300');
                });
                $("#period_3_blackout").removeClass('hidden');
            }
        }

        $(document).ready(function () {
            check_period_2_enable();
            check_period_3_enable();

            $("#period_1").find("input").each(function () {
                $(this).on('blur', function () {
                    check_period_2_disable();
                });
            });
            $("#period_2").find("input").each(function () {
                $(this).on('blur', function () {
                    check_period_3_disable();
                });
            });

            $("#enable_period_2").on('click', function() {
                check_period_2_enable(true);
            });

            $("#enable_period_3").on('click', function() {
                check_period_3_enable(true);
            });

            $("form").submit(function () {
                if (!$('input[name="period_3[from_days]"]').val()
                    && !$('input[name="period_3[to_days]"]').val()
                    && (!$('input[name="period_3[code]"]').val() && !$('input[name="period_3[discount]"]').val())) {

                    $("#period_3").find('input').each(function () {
                        $(this).prop('disabled', true);
                    });
                }

                if (!$('input[name="period_2[from_days]"]').val()
                        && !$('input[name="period_2[to_days]"]').val()
                        && (!$('input[name="period_2[code]"]').val() && !$('input[name="period_2[discount]"]').val())) {

                    $("#period_2").find('input').each(function () {
                        $(this).prop('disabled', true);
                    });
                }
            });
        });
    </script>

    <div class="py-12">
        @if($errors->any())
            <div class="max-w-6xl mx-auto mb-5 px-4 py-2 bg-red-200 border border-red-500 rounded-lg">
                @foreach($errors->all() as $error)
                    {{ $error }} <br />
                @endforeach
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg pl-10 pr-4 py-2">
                <form action="{{ route('discount.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap items-center mt-4">
                        <label for="name" class="h-full font-bold">{{ __('app/discounts/create.rule_name_label') }}</label>
                        <input name="name" id="name" type="text" class="border border-gray-300 rounded rounded-md text-neutral-700 ml-4 w-1/4" value="{{ old('name') }}"/>
                        <div class="bg-gray-200 text-gray-500 ml-4 py-2 px-4 rounded">{{ __('app/discounts/create.rule_name_helper') }}</div>
                        <label for="active" class="ml-auto">{{ __('app/discounts/create.rule_active_label') }}</label>
                        <input name="active" id="active" type="checkbox" value="1" class="mx-4" {{ old('active') ? 'checked' : '' }} />
                    </div>
                    <hr class="my-8">
                    <div class="flex items-center gap-8">
                        <div class="flex flex-col w-1/4">
                            <div class="font-bold ml-2">
                                {{ __('app/discounts/create.brand_label') }}
                            </div>
                            <div>
                                <select class="rounded border-gray-300 w-full" name="brand_id">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col w-1/4">
                            <div class="font-bold ml-2">
                                {{ __('app/discounts/create.access_type_label') }}
                            </div>
                            <div>
                                <select class="rounded border-gray-300 w-full" name="access_type_code">
                                    @foreach($access_types as $access_type)
                                        <option value="{{ $access_type->code }}">{{ $access_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col w-1/4">
                            <div class="font-bold ml-2">
                                {{ __('app/discounts/create.priority_label') }}
                            </div>
                            <div class="h-full w-full">
                                <input type="text" class="border border-gray-300 rounded rounded-md text-neutral-700 w-full" name="priority" value="{{ old('priority') }}" />
                            </div>
                        </div>
                        <div class="flex flex-col w-1/4">
                            <div class="font-bold ml-2">
                                {{ __('app/discounts/create.region_label') }}
                            </div>
                            <div>
                                <select class="rounded border-gray-300 w-full" name="region_id">
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="my-8">
                    <div class="bg-gray-200 text-gray-700 p-8 text-sm rounded-lg">
                        {{ __('app/discounts/create.create_discount_info_bubble') }}
                    </div>
                    <hr class="my-8">
                    <div class="flex gap-2">
                        <div id="period_1" class="flex flex-wrap w-1/3 border border-gray-100 rounded rounded-lg">
                            <div class="p-5 w-full max-w-full">
                                <div class="text-sky-800 font-bold w-full">
                                    {{ __('app/discounts/create.application_period_1') }}
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <div><input class="w-3/5 border-gray-400 rounded" name="period_1[from_days]" type="text" placeholder="{{ __('app/discounts/create.placeholder_from') }}" value="{{ old('period_1.from_days') }}"></div>
                                    <div><input class="w-3/5 border-gray-400 rounded" name="period_1[to_days]" type="text" placeholder="{{ __('app/discounts/create.placeholder_to') }}" value="{{ old('period_1.to_days') }}"></div>
                                </div>
                            </div>
                            <hr class="w-full">
                            <div class="p-5 w-full max-w-full">
                                <div class="text-gray-700 font-bold w-full">
                                    {{ __('app/discounts/create.awd_bcd_discount_code_label') }}
                                </div>
                                <div class="flex mt-2">
                                    <input class="w-full border-gray-400 rounded" name="period_1[code]" type="text" placeholder="{{ __('app/discounts/create.placeholder_code') }}" value="{{ old('period_1.code') }}">
                                </div>
                            </div>
                            <div class="p-5 w-full max-w-full">
                                <div class="text-gray-700 font-bold w-full">
                                    {{ __('app/discounts/create.gsa_discount_percentage_label') }}
                                </div>
                                <div class="flex mt-2">
                                    <input class="w-full border-gray-400 rounded" name="period_1[discount]" type="text" placeholder="{{ __('app/discounts/create.placeholder_discount') }}" value="{{ old('period_1.discount') }}">
                                </div>
                            </div>
                        </div>
                        <div id="period_2" class="flex flex-wrap w-1/3 border border-gray-100 rounded rounded-lg relative">
                            <div id="period_2_blackout" class="absolute w-full h-full">
                                <div class="relative w-full h-full">
                                    <div class="absolute w-full h-full bg-neutral-300 opacity-50 flex items-center"></div>
                                    <div id="enable_period_2" class="cursor-pointer absolute left-1/2 top-1/4 -translate-x-1/2 mx-auto px-4 py-2 bg-blue-600 rounded border border-blue-800 text-neutral-100 opacity-100">
                                        {{ __('main.enable_button') }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 w-full max-w-full">
                                <div class="text-sky-800 font-bold w-full">
                                    {{ __('app/discounts/create.application_period_2') }}
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <div><input disabled class="w-3/5 border-gray-400 rounded bg-neutral-300" name="period_2[from_days]" type="text" placeholder="{{ __('app/discounts/create.placeholder_from') }}" value="{{ old('period_2.from_days') }}"></div>
                                    <div><input disabled class="w-3/5 border-gray-400 rounded bg-neutral-300" name="period_2[to_days]" type="text" placeholder="{{ __('app/discounts/create.placeholder_to') }}" value="{{ old('period_2.to_days') }}"></div>
                                </div>
                            </div>
                            <hr class="w-full">
                            <div class="p-5 w-full max-w-full">
                                <div class="text-gray-700 font-bold w-full">
                                    {{ __('app/discounts/create.awd_bcd_discount_code_label') }}
                                </div>
                                <div class="flex mt-2">
                                    <input disabled class="w-full border-gray-400 rounded bg-neutral-300" name="period_2[code]" type="text" placeholder="{{ __('app/discounts/create.placeholder_code') }}" value="{{ old('period_2.code') }}">
                                </div>
                            </div>
                            <div class="p-5 w-full max-w-full">
                                <div class="text-gray-700 font-bold w-full">
                                    {{ __('app/discounts/create.gsa_discount_percentage_label') }}
                                </div>
                                <div class="flex mt-2">
                                    <input disabled class="w-full border-gray-400 rounded bg-neutral-300" name="period_2[discount]" type="text" placeholder="{{ __('app/discounts/create.placeholder_discount') }}" value="{{ old('period_2.discount') }}">
                                </div>
                            </div>
                        </div>
                        <div id="period_3" class="flex flex-wrap w-1/3 border border-gray-100 rounded rounded-lg relative">
                            <div id="period_3_blackout" class="absolute w-full h-full">
                                <div class="relative w-full h-full">
                                    <div class="absolute w-full h-full bg-neutral-300 opacity-50 flex items-center"></div>
                                    <div id="enable_period_3" class="cursor-pointer absolute left-1/2 top-1/4 -translate-x-1/2 mx-auto px-4 py-2 bg-blue-600 rounded border border-blue-800 text-neutral-100 opacity-100">
                                        {{ __('main.enable_button') }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 w-full max-w-full">
                                <div class="text-sky-800 font-bold w-full">
                                    {{ __('app/discounts/create.application_period_3') }}
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <div><input disabled class="w-3/5 border-gray-400 rounded bg-neutral-300" name="period_3[from_days]" type="text" placeholder="{{ __('app/discounts/create.placeholder_from') }}" value="{{ old('period_3.from_days') }}"></div>
                                    <div><input disabled class="w-3/5 border-gray-400 rounded bg-neutral-300" name="period_3[to_days]" type="text" placeholder="{{ __('app/discounts/create.placeholder_to') }}" value="{{ old('period_3.to_days') }}"></div>
                                </div>
                            </div>
                            <hr class="w-full">
                            <div class="p-5 w-full max-w-full">
                                <div class="text-gray-700 font-bold w-full">
                                    {{ __('app/discounts/create.awd_bcd_discount_code_label') }}
                                </div>
                                <div class="flex mt-2">
                                    <input disabled class="w-full border-gray-400 rounded bg-neutral-300" name="period_3[code]" type="text" placeholder="{{ __('app/discounts/create.placeholder_code') }}" value="{{ old('period_3.code') }}">
                                </div>
                            </div>
                            <div class="p-5 w-full max-w-full">
                                <div class="text-gray-700 font-bold w-full">
                                    {{ __('app/discounts/create.gsa_discount_percentage_label') }}
                                </div>
                                <div class="flex mt-2">
                                    <input disabled class="w-full border-gray-400 rounded bg-neutral-300" name="period_3[discount]" type="text" placeholder="{{ __('app/discounts/create.placeholder_discount') }}" value="{{ old('period_3.discount') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-8">
                    <div>
                        <div date-rangepicker class="flex items-center">
                            <div class="m-4 font-bold ">
                                {{ __('app/discounts/create.application_period') }}
                            </div>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input name="start_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('app/discounts/create.placeholder_start_date') }}" value="{{ old('start_date') }}">
                            </div>
                            <span class="mx-4 text-gray-500">-</span>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input name="end_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('app/discounts/create.placeholder_end_date') }}" value="{{ old('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-12">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('discount.index') }}"><div class="font-bold bg-gray-200 border border-gray-300 rounded py-2 px-4 cursor-default">{{ __('app/discounts/create.cancel_button') }}</div></a>
                            <input type="submit" class="font-bold text-neutral-200 bg-blue-600 border border-blue-900 rounded py-2 px-4" value="{{ __('app/discounts/create.save_button') }}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
