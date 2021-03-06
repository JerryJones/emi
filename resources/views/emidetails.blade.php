<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <style>
            body,html {
            height: 100%;
            }
        </style>
        <title>EMI - Admin Page</title>
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="#">Dashboad - EMI</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
                                </li>
                            
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('loandetails') }}">Loan Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('emidetails') }}">EMI Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                                </li>
                                @endguest
                            
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container h-100">
            <div class="row">
                <div class="col">
                    <h3 style="margin-top:50px;">EMI Details</h3>
                    <button id="processData" type="button" class="btn btn-outline-success m-3">Process Data</button>
                </div>
            </div>
                
            <div class="row justify-content-center ">
                <div class="col" id="showData"></div>
            </div>  
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $( document ).ready(function() {
                
                //Fetch and generate table
                $("#processData").on('click', function(){
                    let _url = 'emidetails/processdata';
                    let _token   = $('meta[name="csrf-token"]').attr('content')

                    $.ajax({
                        url: _url,
                        type: "GET",
                        data: {
                        _token: _token
                        },
                        success: function(response) {
                            if(response) {
                                var emiTable = CreateTableFromJSON(response);
                                console.log(response);
                            }
                        }
                    });
                });

            });

            function CreateTableFromJSON(tblData) {
                // EXTRACT VALUE FOR HTML HEADER. 
                var col = [];
                for (var i = 0; i < tblData.length; i++) {
                    for (var key in tblData[i]) {
                        if (col.indexOf(key) === -1) {
                            col.push(key);
                        }
                    }
                }

                // CREATE DYNAMIC TABLE.
                var table = document.createElement("table");
                table.classList.add('table');

                // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

                var tr = table.insertRow(-1);                   // TABLE ROW.

                for (var i = 0; i < col.length; i++) {
                    var th = document.createElement("th");      // TABLE HEADER.
                    th.innerHTML = col[i];
                    tr.appendChild(th);
                }

                // ADD JSON DATA TO THE TABLE AS ROWS.
                for (var i = 0; i < tblData.length; i++) {

                    tr = table.insertRow(-1);

                    for (var j = 0; j < col.length; j++) {
                        var tabCell = tr.insertCell(-1);
                        tabCell.innerHTML = tblData[i][col[j]];
                    }
                }

                // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
                var divContainer = document.getElementById("showData");
                divContainer.innerHTML = "";
                divContainer.appendChild(table);
            }
        </script>
</body>
</html>
