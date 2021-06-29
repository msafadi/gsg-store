<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>

    <h2>{{ $title }}</h2> 

    <table>
        <thead>
            <tr>
                <td>$loop</td>
                <td>ID</td>
                <td>Name</td>
                <td>Slug</td>
                <td>Parent ID</td>
                <td>Status</td>
                <td>Created At</td>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->first? 'First' : ($loop->last? 'Last' : $loop->iteration) }}</td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent_name }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>