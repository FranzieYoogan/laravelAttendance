
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

   
    <link rel="stylesheet" href="{{asset('/css/schedule2.css')}}">
    <link rel="stylesheet" href="{{asset('/css/addemployees.css')}}">

</head>
<body>

    @include('sidebar')
    @include('headersidebar')

<div class="divAll p-4 sm:ml-64" id="divAll">
   
  


<section class="formStyle" id="formStyle">

    <form action="/addemployees" method="post" class="divForm">
        @csrf

        <span>Name</span>
        <div class="inputStyle mb-6">
            <input name="name" type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <div class="inputStyle mb-6">
           
            <span>Email</span>
            <input  type="text" name="email" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>

        <div class="inputStyle mb-6">

            <span>Password</span>
            <input  type="password" name="password" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        
        
<div>
    
    <select class="selectIn" name="scheduleTimein" id="">

        <option selected>Time in</option>

        @foreach ($time as $item)

        <option value="{{$item->scheduleTimein}}">{{$item->scheduleTimein}}</option>

        @endforeach
        

    </select>

    <select class="selectOut" name="scheduleTimeout" id="">

        <option selected>Time out</option>

        @foreach ($time as $item)

        <option value="{{$item->scheduleTimeout}}">{{$item->scheduleTimeout}}</option>

        @endforeach
        

    </select>

</div>
  

        <div class="divButton">

            <a href="/employees" class="buttonClose text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><img class="imgStyle" src="{{asset('/icons/close.png')}}" alt=""> Close</a>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save</button>

        </div>
        

    </form>

</section>



</body>
</html>

