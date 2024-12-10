<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{asset('/css/dashboard.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

</head>
<body>

    @include('sidebar')
    @include('headersidebar')
    
    <div class="p-4 sm:ml-64">
        
        <section class="allItems">

            @if (isset($total))

            <div class="divTotal">

                <div>
                    <h1 class="titleTotal">{{$total}}</h1>
                    <h1 class="titleTotal">Total Employees</h1>
                </div>
             

                <div>

                    <img src="{{asset('/icons/employees.png')}}" alt="">

                </div>

            </div>
                
            @endif
          

            <div>

                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                

            </div>
        

        </section>
        

    </div>
  
    @if (isset($ontime) && isset($late))

  
    <script>
        var xValues = ["Late", "OnTime"];
        var yValues = [{{$late}}, {{$ontime}},];
        var barColors = [
          "#b91d47",
          "#1e7145"
        ];
        
        new Chart("myChart", {
          type: "pie",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            title: {
              display: true,
              text: "Employees Attendance"
            }
          }
        });
        </script>
  @endif

</body>
</html>