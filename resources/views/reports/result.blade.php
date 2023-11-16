<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table {
            margin-top: 10px;
            width: 100%;
            border-spacing: 0;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(96 165 250);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
          
            text-align: center; 

        }
    </style>
</head>

<body>

    <div class="container">

       @foreach  ($data['data'] as $position)
        <div style="font-weight: bold">{{$position->name}}</div>
        <ul>
        @foreach ($position->candidates as $candidate)
        
        <li style="display: flex; width: 400px; justify-content: space-between; margin-right: 20px;">
            <span>{{$candidate->name}}</span>
            <span style="color: rgb(13, 136, 136)">{{$candidate->vote_count}}</span>
        </li>
        

        @endforeach
    </ul>


       @endforeach


    </div>

</body>

</html>