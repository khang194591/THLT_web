@extends('layouts.app')

{{--
    Sẽ nhận được 1 array đủ các thông tin ở dưới đặt tạm tên là $listResults
 --}}
@php
    $subject = App\Models\Course::all();
    if (isset($_GET['filterSubject'])) {
        $subjectFilter = $_GET['filterSubject'];
        $tmp = [];
        foreach ($listResult as $key => $value) {
            if ($value->course_name == $subjectFilter) {
                $tmp[] = $value;
            }
        }
        $listResult = $tmp;
    }
@endphp

@section('content')
    <div class="p-3 flex-1 bg-slate-100">
        <div class="filter flex justify-between">
            <div class="search w-1/3 relative hidden md:block">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Search icon</span>
                </div>
                <input type="text" id="search-navbar"
                    class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search...">
            </div>
            <div class="fleter_div">
                <form id="filter" class="flex flex-row" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"
                    class="block min-w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <select name="filterSubject" id="" data-palaceholder="Filters"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option <?php if (isset($_GET['filterSubject'])) {
                            echo 'hidden';
                        } ?> selected>
                            {{ isset($_GET['filterSubject']) ? $_GET['filterSubject'] : 'Select' }}</option>
                        @foreach ($subject as $item)
                            <option value="{{ $item->name }}" class="">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-gray-50 ml-2 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">filter</button>
                </form>
            </div>
        </div>

        <div class="my-6 bg-white mx-4">
            <table class="w-full">
                <thead class="">
                    <?php $thClass = 'bg-yellow-400 text-white px-4 py-3'; ?>
                    <tr class="text-md font-semibold">
                        <th class="{{ $thClass }}">Bài thi</th>
                        <th class="{{ $thClass }}">Thời gian</th>
                        <th class="{{ $thClass }}">Khóa học</th>
                        <th class="{{ $thClass }}">Số câu hỏi</th>
                        <th class="{{ $thClass }}">Điểm số</th>
                        <th class="{{ $thClass }}">Ngày kiểm tra</th>
                        <th class="{{ $thClass }}">Giờ làm bài</th>
                        <th class="{{ $thClass }}">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $tdClass = 'text-center px-4 py-3'; ?>
                    @foreach ($listResult as $item)
                        <tr class="hover:bg-yellow-100">
                            <td class="{{ $tdClass }}">{{ $item->exam_name }}</td>
                            <td class="{{ $tdClass }}">{{ $item->exam_time }} minute</td>
                            <td class="{{ $tdClass }}">{{ $item->course_name }}</td>
                            <td class="{{ $tdClass }}">{{ $item->question_lenth }}</td>
                            <td class="{{ $tdClass }}">{{ $item->score }}</td>
                            <td class="{{ $tdClass }}">
                                {{ date('j/m/Y', strtotime($item->created_at)) }}</td>
                            <td class="{{ $tdClass }}">
                                {{ date('H:i:s', strtotime($item->created_at)) }}</td>
                            <td class="{{ $tdClass }}">
                                {{-- send result_id --}}
                                <form action="{{ route('result.show', [$item->id]) }}" method="get">
                                    <button class="bg-yellow-400 text-white p-2 rounded-lg" type="submit">
                                        Xem
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
