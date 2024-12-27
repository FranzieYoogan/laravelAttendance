<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('/css/dashboard.css')}}">
</head>
<body>

    @include('sidebar')
    @include('headersidebar')

    <div class="p-4 sm:ml-64">

    <div class="tableLocation relative overflow-x-auto">
        <h1 class="titleMonthly">Daily Attendance</h1>
        
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Employee Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        On Time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Time in
                    </th>
                
                </tr>
            </thead>
            <tbody>

              @foreach ($employeesDay as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                  
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$item->scheduleEmail}}
                    </th>
                    <td class="px-6 py-4">
                      @if ($item->scheduleOntime == "s")
                          <h1 class="onTimeResult">ON TIME</h1>
                
                      @endif
                        
                    </td>
                    <td class="px-6 py-4">
                        {{$item->scheduleDate}}
                    </td>
                    <td class="px-6 py-4">
                        {{$item->scheduleTime}}
                    </td>
    
                     
                </tr>
                @endforeach 
                {{$employeesDay->links()}}

            </tbody>
        </table>
    </div>

    </div>
    
</body>
</html>