<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{asset('/css/sidebar.css')}}">

</head>
<body>

   
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
 </button>
 
 <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="menuStyle h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">

      <div class="containerLogo">
         <img class="logoStyle" src="{{asset('/icons/logo.png')}}" alt="">
      </div>
      

      <ul class="space-y-2 font-medium">
          <li>
             <a href="/dashboard" class="anchorStyle flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
              <img src="{{asset('/icons/dashboard.png')}}" alt="">
                <span class="spanStyle ms-3">Dashboard</span>
             </a>
          </li>
          <li>
             <a href="/employees" class="anchorStyle flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <img src="{{asset('/icons/employees2.png')}}" alt="">
                <span class="spanStyle flex-1 ms-3 whitespace-nowrap">Employees</span>
   
             </a>
          </li>
          <li>
             <a href="/schedule" class="anchorStyle flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <img src="{{asset('/icons/schedule.png')}}" alt="">
                <span class="spanStyle flex-1 ms-3 whitespace-nowrap">Schedule</span>

             </a>
          </li>
          <li>
             <a href="/attendance" class="anchorStyle flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <img src="{{asset('/icons/attendance.png')}}" alt="">
                <span class="spanStyle flex-1 ms-3 whitespace-nowrap">Attendance</span>
             </a>
          </li>
          <li>
             <a href="/late" class="anchorStyle flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <img src="{{asset('/icons/late.png')}}" alt="">
                <span class="spanStyle flex-1 ms-3 whitespace-nowrap">Late Time</span>
             </a>
          </li>
     
          <li>
             <a href="/logout" class="anchorStyle flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
             <img src="{{asset('/icons/signout.png')}}" alt="">
                <span class="spanStyle flex-1 ms-3 whitespace-nowrap">Sign Out</span>
             </a>
          </li>
       </ul>
    </div>
 </aside>
 

 
    
</body>
</html>