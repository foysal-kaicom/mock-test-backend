@extends('master')


@section('contents')
<div class="space-y-5">
    <section class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
        <h1 class="text-xl font-bold">Welcome {{auth()->user()->name}} !</h1>
        <!-- <div class="px-2 py-1 flex gap-2 bg-white rounded shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M11 2C15.968 2 20 6.032 20 11C20 15.968 15.968 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2ZM11 18C14.8675 18 18 14.8675 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18ZM19.4853 18.0711L22.3137 20.8995L20.8995 22.3137L18.0711 19.4853L19.4853 18.0711Z"></path>
            </svg>
            <input type="text" placeholder="Search .." class="focus:outline-none">
        </div> -->
    </section>

    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
        <div class="bg-red-50 p-4 rounded shadow-sm hover:scale-105 duration-300 ">
            <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                <svg class="p-2 bg-red-600 text-white rounded-full" xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 3V19H21V21H3V3H5ZM20.2929 6.29289L21.7071 7.70711L16 13.4142L13 10.415L8.70711 14.7071L7.29289 13.2929L13 7.58579L16 10.585L20.2929 6.29289Z"></path>
                </svg>
                Total Payment Success
            </h2>
            <p class="text-4xl font-semibold mt-2 text-right md:text-start">{{$dashboardData->total_amount}}</p>
        </div>
        <div class="bg-green-50 p-4 rounded shadow-sm hover:scale-105 duration-300">
            <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                <svg class="p-2 bg-green-600 text-white rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="44" height="44" fill="currentColor">
                    <path d="M14 14.252V16.3414C13.3744 16.1203 12.7013 16 12 16C8.68629 16 6 18.6863 6 22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11ZM18 17V14H20V17H23V19H20V22H18V19H15V17H18Z"></path>
                </svg>
                Candidates in Japan
            </h2>
            <p class="text-4xl font-semibold mt-2 text-right md:text-start">{{$candidates}}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded shadow-sm hover:scale-105 duration-300">
            <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                <svg class="p-2 bg-blue-600 text-white rounded-full" xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.00008 6V9H5.00008V6H8.00008ZM3.00008 4V11H10.0001V4H3.00008ZM13.0001 4H21.0001V6H13.0001V4ZM13.0001 11H21.0001V13H13.0001V11ZM13.0001 18H21.0001V20H13.0001V18ZM10.7072 16.2071L9.29297 14.7929L6.00008 18.0858L4.20718 16.2929L2.79297 17.7071L6.00008 20.9142L10.7072 16.2071Z"></path>
                </svg>
                Booking This Month
            </h2>
            <p class="text-4xl font-semibold mt-2 text-right md:text-start">{{$dashboardData->total_bookings_this_month}}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded shadow-sm hover:scale-105 duration-300">
            <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                <svg class="p-2 bg-orange-600 text-white rounded-full" xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2 13H8V21H2V13ZM16 8H22V21H16V8ZM9 3H15V21H9V3ZM4 15V19H6V15H4ZM11 5V19H13V5H11ZM18 10V19H20V10H18Z"></path>
                </svg>
                Certificate Claimed
            </h2>
            <p class="text-4xl font-semibold mt-2 text-right md:text-start">{{$dashboardData->total_certificates_claimed}}</p>
        </div>
    </section>
</div>


@endsection