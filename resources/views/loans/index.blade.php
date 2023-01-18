<!DOCTYPE html>
<html>
<head>
    <title>Loans Uploads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     
<div class="container">
    <div class="card mt-3 mb-3">
        <div class="card-header text-center">
            <h4>Employee Loans Uploads</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('loans.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-primary">Import User Data</button>
            </form>
  
            <table class="table table-bordered mt-3">
                <tr>
                    <th colspan="3">
                        List Of loans
                        <a class="btn btn-danger float-end" href="{{ route('loans.export') }}">Export User Data</a>
                    </th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Employee Id</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                @foreach($loans as $loan)
                <tr>
                    <td>{{ $loan->id }}</td>
                    <td>{{ $loan->employee_id }}</td>
                    <th>{{ $loan->product }}</th>
                    <th>{{ $loan->amount }}</th>
                    <td>{{ $loan->created_at }}</td>
                </tr>
                @endforeach
            </table>
  
        </div>
    </div>
</div>
     
</body>
</html>