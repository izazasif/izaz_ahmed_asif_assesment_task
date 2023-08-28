<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            @if (session('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    {{ session('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    @foreach ($errors->all() as $error)
                        <li><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> &nbsp;{{ $error }}
                        </li>
                    @endforeach
                </div>
            @endif

            
                <!-- <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                            <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-2 mt-3" style="margin-left: 547px;width: 280px;">
                    <h6>Total Balance Now - {{$tot}}</h6>
                    </div>
                    <div class="col-md-10 mt-3 text-right" style="margin-left: 800px;">
                        <!-- <button type="submit" class="btn btn-primary">{{ __('Logout') }}</button> -->
                        <a href="/logout"  class="btn btn-primary" style="margin-top: -91px;">{{ __('Logout') }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                    <button type="button" class="btn btn-primary" id="depositButton">{{ __('Deposite') }}</button>
                    </div>
                    <div class="col-md-6 mt-3">
                        <a href="/withdraw" class="btn btn-primary" >{{ __('Withdraw') }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div class="col md-6">
                        <div class="container mt-5">
                            <h4>Depsite History</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sl. </th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                @php 
                   
                                $count=1;

                                @endphp
                                <tbody>
                                @foreach($deposite as $deposits)  
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$deposits->balance}}</td>
                                        <td>{{ Carbon\Carbon::parse($deposits->created_at)->format('l j,M, Y') }} </td>
                                    </tr>
                                @endforeach   
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="col-md-6">
                           <div class="container mt-5">
                                <h4>Withdraw history</h4>
                                <table class="table" style="width: 511px;">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Amount</th>
                                            <th>Charge</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    @php 
                   
                                    $count=1;

                                    @endphp
                                    <tbody>
                                    @foreach($withdraw as $withdraws)  
                                        <tr>
                                            <td>{{$count++}}</td>
                                            <td>{{$withdraws->balance}}</td>
                                            <td>{{$withdraws->charge}}</td>
                                            <td>{{ Carbon\Carbon::parse($withdraws->created_at)->format('l j,M, Y') }} </td>
                                        </tr>
                                    @endforeach                                          
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="depositModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="depositForm" method="post" action="{{ route('deposit_save') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Deposit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('depositButton').addEventListener('click', function() {
        var modal = new bootstrap.Modal(document.getElementById('depositModal'));
        modal.show();
    });
</script>
</body>
</html>