
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="{{asset('/js/schedule.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/css/schedule.css')}}">

</head>
<body>

    @include('sidebar')
    @include('headersidebar')

    <div class="p-4 sm:ml-64" id="divAll">

   <section class="tableLocation">

    <section class="containerItems">

        
         

<div class="divTable relative overflow-x-auto">
    <h1 class="titleStyle">Schedules</h1>
    <button type="button" id="newForm" onclick="newForm()" class="buttonStyle text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><img class="imgStyle" src="{{asset('/icons/plus.png')}}" alt=""> New</button>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Time in
                </th>
                <th scope="col" class="px-6 py-3">
                    Time out
                </th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($time as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
               
              
                   
               
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$item->scheduleName}}
                </th>
                <td class="px-6 py-4">
                    {{$item->scheduleTimein}}
                </td>
                <td class="timeoutStyle px-6 py-4">
                    {{$item->scheduleTimeout}}

                    <form action="/edit" method="post">
                        @csrf
                        <input name="id" class="passValue" type="text" value="{{$item->scheduleTheOneId}}">
                       <button type="submit"> <img class="editIcon" src="{{asset('icons/edit.png')}}" alt=""></button>
    
                    </form>

                    <form action="/delete" method="POST">
                        @csrf
                        <input name="id" class="passValue" type="text" value="{{$item->scheduleTheOneId}}">
                        <button> <img class="editIcon" src="{{asset('/icons/delete.png')}}" alt=""> </button>

                    </form>
                </td>

                
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>


    </section>


   </section>

  

</div>


    
</body>
</html>

